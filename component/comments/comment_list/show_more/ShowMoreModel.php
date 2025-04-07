<?php
class ShowMoreModel
{
    public static function get_comments($post_id, $load_more_count, $offset, $parent_id, $count_comments)
    {
        // Получаем комментарии из базы данных
        $comments = get_comments(array(
            'post_id' => $post_id,
            'order' => 'DESC',
            'orderby' => 'comment_date',
            'status' => array('approve', 'trash'),

        ));

        $filter_comment_trash_and_approve = self::filter_comment_trash_and_approve($comments);

        // Строим дерево комментариев
        $comment_tree = self::build_comment_tree($filter_comment_trash_and_approve);


        // Исключаем комментарии, которые уже были загружены
        $filtered_tree = self::filter_loaded_parents($comment_tree, $parent_id);



        // Ограничиваем первыми 50 комментариями (включая детей)
        $limited_tree = self::limit_comment_tree($filtered_tree, 50);



        // Получаем родительские комментарии
        $parents_only = array_map(function ($parents_only) {
            return [
                'id' => $parents_only['id'],
                'content' => $parents_only['content'],
                'author' => $parents_only['author'],
                'date' => $parents_only['date'],
                'user_id' => $parents_only['user_id'],
                'comment_approved' => $parents_only['comment_approved'],
                'parent' => $parents_only['parent'],

            ];
        }, $limited_tree);

        foreach ($parents_only as $comment) {
            $parent_id[] = $comment['id'];

        }

        $filtered_comments = array_filter($comment_tree, function ($comment) use ($parent_id) {
            return !in_array($comment['id'], $parent_id);
        });



        $total = CountAllComments::countTotalCommentsInFirstFive($filtered_comments);

        // Вычисляем оставшееся количество комментариев
        $remaining_comments = $count_comments - ($load_more_count);
        $remaining_comments = max(0, $total);



        // Проверяем, есть ли еще комментарии для загрузки
        $show_more = $remaining_comments > 0;



        $formatted_comments = array();
        foreach ($parents_only as $comment) {

            $is_deleted = $comment['comment_approved'] === 'trash';
            $comment_class = $is_deleted ? 'user_comment comment-deleted' : 'user_comment';

            $formatted_comments[] = array(
                'id' => $comment['id'],
                'author' => $comment['author'],
                'content' => $comment['content'],
                'date' => $comment['date'],
                'user_id' => $comment['user_id'],
                'is_deleted' => $is_deleted,
                'comment_class' => $comment_class,
                'parent' => $comment['parent'],
            );
        }

        return array(
            'comments' => $formatted_comments,
            'show_more' => $show_more,
            'remaining_comments' => $remaining_comments,
            'total' => $filtered_comments,


        );
    }


    public static function filter_comment_trash_and_approve($comments)
    {
        // Массив для отфильтрованных комментариев
        $filtered_comments = array();

        if (!empty($comments) && is_array($comments)) {
            foreach ($comments as $comment) {
                // Если комментарий одобрен, добавляем его в массив
                if ($comment->comment_approved == '1') {
                    $filtered_comments[] = $comment;
                }
                // Если комментарий в корзине, проверяем, есть ли у него дочерние комментарии
                elseif ($comment->comment_approved == 'trash') {
                    $child_comments_count = get_comments(array(
                        'parent' => $comment->comment_ID, // Ищем дочерние комментарии
                        'count' => true, // Только подсчет количества
                    ));

                    // Если есть дочерние комментарии, добавляем в массив
                    if ($child_comments_count > 0) {
                        $filtered_comments[] = $comment;
                    }
                }
            }
        }

        return $filtered_comments;
    }


    public static function build_comment_tree($comments)
    {
        $comment_tree = [];
        $children_map = [];

        // Разделяем комментарии на родительские и дочерние
        foreach ($comments as $comment) {
            if ($comment->comment_parent == 0) {
                $comment_tree[$comment->comment_ID] = (array) $comment;
                $comment_tree[$comment->comment_ID]['children'] = [];
                $comment_tree[$comment->comment_ID]['comment_approved'] = $comment->comment_approved;
                $comment_tree[$comment->comment_ID]['id'] = $comment->comment_ID;
                $comment_tree[$comment->comment_ID]['author'] = $comment->comment_author;
                $comment_tree[$comment->comment_ID]['content'] = $comment->comment_content;
                $comment_tree[$comment->comment_ID]['date'] = time_ago_short($comment->comment_date);
                $comment_tree[$comment->comment_ID]['user_id'] = $comment->user_id;
                $comment_tree[$comment->comment_ID]['parent'] = $comment->comment_parent;
            } else {
                $children_map[$comment->comment_parent][] = [
                    'id' => $comment->comment_ID,
                    'author' => $comment->comment_author,
                    'content' => $comment->comment_content,
                    'date' => time_ago_short($comment->comment_date),
                    'user_id' => $comment->user_id,
                    'parent' => $comment->comment_parent,
                    'comment_approved' => $comment->comment_approved,
                    'children' => []
                ];
            }
        }
        self::add_children($comment_tree, $children_map);

        return array_values($comment_tree); // Убираем ключи массива
    }



    // Рекурсивно добавляем дочерние комментарии
    public static function add_children(&$tree, $children_map)
    {
        foreach ($tree as &$comment) {
            if (isset($children_map[$comment['id']])) {
                $comment['children'] = $children_map[$comment['id']];
                self::add_children($comment['children'], $children_map);
            }
        }
    }



    // Исключаем комментарии, которые уже были загружены
    public static function filter_loaded_parents($comment_tree, $parent_ids)
    {
        if (!is_array($parent_ids)) {
            $parent_ids = [$parent_ids]; // Преобразуем в массив, если передано число
        }

        return array_filter($comment_tree, function ($comment) use ($parent_ids) {
            return !in_array($comment['id'], $parent_ids);
        });
    }




    // Функция для подсчета и ограничения первых 50 комментариев
    public static function limit_comment_tree($comment_tree, $limit = 50)
    {
        $result = [];
        $count = 0;

        function traverse_tree($tree, &$result, &$count, $limit)
        {
            foreach ($tree as $comment) {
                if ($count >= $limit) {
                    return;
                }

                $result[] = [
                    'id' => $comment['id'],
                    'parent' => $comment['parent'],
                    'content' => $comment['content'],
                    'author' => $comment['author'],
                    'date' => $comment['date'],
                    'user_id' => $comment['user_id'],
                    'comment_approved' => $comment['comment_approved'],
                    'children' => [],
                ];
                $count++;

                if (!empty($comment['children'])) {
                    traverse_tree($comment['children'], $result[count($result) - 1]['children'], $count, $limit);
                }
            }
        }

        traverse_tree($comment_tree, $result, $count, $limit);

        return $result;
    }

}

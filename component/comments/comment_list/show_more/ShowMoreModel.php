<?php
class ShowMoreModel {
    public static function build_comment_tree($comments) {
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
     public static function add_children(&$tree, $children_map) {
        foreach ($tree as &$comment) {
            if (isset($children_map[$comment['id']])) {
                $comment['children'] = $children_map[$comment['id']];
                self::add_children($comment['children'], $children_map);
            }
        }
    }
    // Исключаем комментарии, которые уже были загружены
    public static function filter_loaded_parents($comment_tree, $parent_ids) {
        if (!is_array($parent_ids)) {
            $parent_ids = [$parent_ids]; // Преобразуем в массив, если передано число
        }
        
        return array_filter($comment_tree, function ($comment) use ($parent_ids) {   
            return !in_array($comment['id'], $parent_ids);
        });
    }
    // Функция для подсчета и ограничения первых 50 комментариев
    public static function limit_comment_tree($comment_tree, $limit = 50) {
        $result = [];
        $count = 0;

        function traverse_tree($tree, &$result, &$count, $limit) {
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

    public static function get_comments($post_id, $load_more_count, $offset, $parent_id) {
        // Получаем общее количество комментариев
        $total_comments = get_comments_number($post_id);

        $comments = get_comments(array(
            'post_id' => $post_id,            
            'order' => 'DESC',
            'orderby' => 'comment_date',
            'status' => 'approve',
            //'parent' => 0,
            //.'number' => $load_more_count,
            // 'offset' => $offset,
           
           

        ));
       
        // Строим дерево комментариев
        $comment_tree = self::build_comment_tree($comments);
       
        // Исключаем комментарии, которые уже были загружены
        $filtered_tree = self::filter_loaded_parents($comment_tree, $parent_id);

        // Ограничиваем первыми 50 комментариями (включая детей)
        $limited_tree = self::limit_comment_tree($filtered_tree, 50);

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
        // wp_send_json_success(array(
        //     'parents_only' =>  $parents_only,
        //     'limited_tree' => $limited_tree,
                      
          
            
        // ));
        // Получаем общее количество комментариев
        $total_comments = get_comments_number($post_id);

        // Вычисляем оставшееся количество комментариев
        $remaining_comments = $total_comments - ($offset + $load_more_count);
        $remaining_comments = max(0, $remaining_comments);

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
            'total_comments' => $total_comments,
            //'next_load_count' => $next_load_count,
        );
    }

}

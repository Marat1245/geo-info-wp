<?php
class CommentListModel
{
    /**
     * Количество комментариев для первоначального отображения
     */
    const INITIAL_COMMENTS_COUNT = 5;

    public static function get_comments($post_id, $count = 5)
    {
        // Получаем комментарии из базы данных
        $comments = get_comments(array(
            'post_id' => $post_id,
            'order' => 'DESC',
            'orderby' => 'comment_date',
            'status' => array('approve', 'trash'),

        ));


        // Массив для отфильтрованных комментариев
        $filter_comment_trash_and_approve = ShowMoreModel::filter_comment_trash_and_approve($comments);

        // Строим дерево комментариев
        $commentsTest = ShowMoreModel::build_comment_tree($filter_comment_trash_and_approve);

        // Получаем первые 5 комментариев
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
        }, array_slice($commentsTest, 0, 5));



        // Получаем общее количество комментариев
        $total_comments = get_comments_number($post_id);
        // Считаем общее количество комментариев в первых 5 комментариях
        $total_comments_count = CountAllComments::countTotalCommentsInFirstFive($commentsTest, self::INITIAL_COMMENTS_COUNT);
        // Считаем количество комментариев для показа "Показать еще"
        $last_comments_count = $total_comments - $total_comments_count;




        // Формируем массив комментариев
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
                'is_deleted' => $is_deleted ? 'display: none;' : '',
                'comment_class' => $comment_class,
                'parent' => $comment['parent']
            );
        }



        return array(
            'comments' => $formatted_comments,
            'total' => $total_comments,
            'show_more' => $total_comments > self::INITIAL_COMMENTS_COUNT,
            'last_comments_count' => $last_comments_count
        );
    }






    //
    // Получаем дочерние комментарии для конкретного поста
    //
    public static function get_parrent_comments($post_id)
    {
        $comments = get_comments(array(
            'post_id' => $post_id,
            'order' => 'DESC',
            'orderby' => 'comment_date',
            'status' => 'approve',
        ));

        $under_comments = array();

        foreach ($comments as $comment) {

            $is_deleted = get_comment($comment->comment_ID)->comment_approved === 'trash';
            $comment_class = $is_deleted ? 'user_comment comment-deleted' : 'user_comment';

            $under_comments[] = array(
                'id' => $comment->comment_ID,
                'author' => $comment->comment_author,
                'content' => $comment->comment_content,
                'date' => time_ago_short($comment->comment_date),
                'user_id' => $comment->user_id,
                'is_deleted' => $is_deleted ? 'display: none;' : '',
                'comment_class' => $comment_class,
                'parent' => $comment->comment_parent,

            );
        }
        return $under_comments;
    }




}



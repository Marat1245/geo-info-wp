<?php
// model/comment.php
class CommentModel {

    public static function get_comments_count($post_id) {
        return get_comments(array(
            'post_id' => $post_id,
            'count' => true
        ));
    }

    public static function get_comments($post_id) {
        $comments = get_comments(array(
            'post_id' => $post_id,
            'order' => 'DESC',
            'orderby' => 'comment_date'
        ));

        $user_id = get_current_user_id();
        $formatted_comments = array();

        foreach ($comments as $comment) {
            $likes_count = CommentLikes::get_likes_count($comment->comment_ID);
            $is_liked = $user_id ? CommentLikes::is_liked_by_user($comment->comment_ID, $user_id) : false;

            $formatted_comments[] = array(
                'id' => $comment->comment_ID,
                'author' => $comment->comment_author,
                'content' => $comment->comment_content,
                'date' => $comment->comment_date,
                'likes_count' => $likes_count,
                'is_liked' => $is_liked
            );
        }

        return $formatted_comments;
    }

    public static function add_comment($post_id, $author, $content) {
        // Добавляем новый комментарий
        $comment_data = array(
            'comment_post_ID' => $post_id,
            'comment_author' => $author,
            'comment_content' => $content,
            'comment_approved' => 1,
            'comment_date' => current_time('mysql'),
        );

        return wp_insert_comment($comment_data);
    }

    public static function update_comment($comment_id, $content) {
        // Обновляем текст комментария
        $comment = get_comment($comment_id);
        $comment->comment_content = $content;
        return wp_update_comment((array) $comment);
    }

    public static function delete_comment($comment_id) {
        // Вместо полного удаления, помечаем комментарий как удаленный
        $comment = get_comment($comment_id);
        if ($comment) {
            $comment->comment_approved = 'trash';
            return wp_update_comment((array) $comment);
        }
        return false;
    }

    public static function restore_comment($comment_id) {
        // Восстанавливаем комментарий из корзины
        $comment = get_comment($comment_id);
        if ($comment) {
            $comment->comment_approved = 1;
            return wp_update_comment((array) $comment);
        }
        return false;
    }
} 
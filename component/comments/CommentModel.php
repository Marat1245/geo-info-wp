<?php
// model/comment.php
class CommentModel {

    public static function get_comments($post_id) {
        // Получаем все комментарии для конкретного поста
        return get_comments(array('post_id' => $post_id));
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
        // Удаляем комментарий
        return wp_delete_comment($comment_id, true);
    }
}

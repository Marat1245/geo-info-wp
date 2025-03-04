<?php
// controller/comment-controller.php
class CommentController {

    public static function handle_comment_submission() {
        if (isset($_POST['comment_content']) && isset($_POST['post_id']) && isset($_POST['author'])) {
            $post_id = intval($_POST['post_id']);
            $author = sanitize_text_field($_POST['author']);
            $content = sanitize_textarea_field($_POST['comment_content']);

            if (empty($content)) {
                wp_send_json_error(['message' => 'Комментарий не может быть пустым']);
            }

            $comment_id = CommentModel::add_comment($post_id, $author, $content);
            if ($comment_id) {
                wp_send_json_success(['message' => 'Комментарий добавлен!', 'comment_id' => $comment_id]);
            } else {
                wp_send_json_error(['message' => 'Ошибка при добавлении комментария']);
            }
        }
    }

    public static function handle_comment_update() {
        if (isset($_POST['comment_id']) && isset($_POST['new_content'])) {
            $comment_id = intval($_POST['comment_id']);
            $new_content = sanitize_textarea_field($_POST['new_content']);

            if (empty($new_content)) {
                wp_send_json_error(['message' => 'Комментарий не может быть пустым']);
            }

            $updated = CommentModel::update_comment($comment_id, $new_content);
            if ($updated) {
                wp_send_json_success(['message' => 'Комментарий обновлен!']);
            } else {
                wp_send_json_error(['message' => 'Ошибка при обновлении']);
            }
        }
    }

    public static function handle_comment_delete() {
        if (isset($_POST['comment_id'])) {
            $comment_id = intval($_POST['comment_id']);

            $deleted = CommentModel::delete_comment($comment_id);
            if ($deleted) {
                wp_send_json_success(['message' => 'Комментарий удален!']);
            } else {
                wp_send_json_error(['message' => 'Ошибка при удалении']);
            }
        }
    }
}

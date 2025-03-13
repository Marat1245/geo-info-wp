<?php


class CommentEditController {    

    public static function handle_edit_comment() {
        check_ajax_referer('comment_edit_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error('Пользователь не авторизован');
        }

        $comment_id = intval($_POST['comment_id']);
        
        // Получаем контент
        $content = isset($_POST['content']) ? sanitize_textarea_field($_POST['content']) : '';        
        

        if (!$comment_id) {
            wp_send_json_error('Неверный ID комментария');
        }

        $result = CommentEditModel::update_comment($comment_id, $content);

        if ($result) {
            // Форматируем контент для отображения
            $formatted_content = wpautop($content);
            
            wp_send_json_success(array(
                'message' => 'Комментарий успешно обновлен',
                'content' => $content
            ));
        } else {
            wp_send_json_error('Ошибка при обновлении комментария');
        }
    }
} 

add_action('wp_ajax_edit_comment', array('CommentEditController', 'handle_edit_comment'));
add_action('wp_ajax_nopriv_edit_comment', array('CommentEditController', 'handle_edit_comment'));
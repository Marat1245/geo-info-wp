<?php

class InputCommentController {
    public static function handle_create_comment() {
        check_ajax_referer('comment_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error('Необходимо авторизоваться');
        }
    
        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        $content = isset($_POST['content']) ? sanitize_textarea_field($_POST['content']) : '';
    
        $result = InputCommentModel::create_comment(array(
            'post_id' => $post_id,
            'content' => $content
        ));
    
        if ($result['success']) {
            wp_send_json_success($result['comment']);
        } else {
            wp_send_json_error($result['message']);
        }
    }
}

// Регистрируем AJAX обработчики
add_action('wp_ajax_create_comment', array('InputCommentController', 'handle_create_comment'));
add_action('wp_ajax_nopriv_create_comment', array('InputCommentController', 'handle_create_comment')); 
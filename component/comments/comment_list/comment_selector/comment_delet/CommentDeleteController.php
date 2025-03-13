<?php

class CommentDeleteController {
    public static function init() {
        add_action('wp_ajax_delete_comment', [self::class, 'handle_delete_comment']);  
        add_action('wp_ajax_nopriv_delete_comment', [self::class, 'handle_delete_comment']);
    }

    public static function handle_delete_comment() {
       

        // Проверяем nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'comment_actions_nonce')) {
       
            wp_send_json_error('Ошибка безопасности');
        }

        // Проверяем ID комментария
        $comment_id = isset($_POST['comment_id']) ? intval($_POST['comment_id']) : 0;
        if (!$comment_id) {
          
            wp_send_json_error('ID комментария не указан');
        }

        // Проверяем права пользователя
        if (!current_user_can('edit_comment', $comment_id)) {
           
            wp_send_json_error('Недостаточно прав');
        }

        // Удаляем комментарий
        $result = CommentDeleteModel::delete_comment($comment_id);
        
        if ($result) {
          
            wp_send_json_success();
        } else {
         
            wp_send_json_error('Не удалось удалить комментарий');
        }
    }

    
} 
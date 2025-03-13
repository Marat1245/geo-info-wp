<?php

class CommentRestoreController {
      

    public static function handle_restore_comment() {
        try {
            // Включаем отображение ошибок
            ini_set('display_errors', 1);
            error_reporting(E_ALL);

            // Проверяем авторизацию
            if (!is_user_logged_in()) {
             
                wp_send_json_error('Требуется авторизация');
            }

            // Логируем входящие данные
          

            // Проверяем nonce
            if (!isset($_POST['nonce'])) {
              
                wp_send_json_error('Ошибка безопасности: nonce не установлен');
            }

            if (!wp_verify_nonce($_POST['nonce'], 'comment_actions_nonce')) {
               
                wp_send_json_error('Ошибка безопасности: неверный nonce');
            }

            // Проверяем ID комментария
            $comment_id = isset($_POST['comment_id']) ? intval($_POST['comment_id']) : 0;
            if (!$comment_id) {
            
                wp_send_json_error('ID комментария не указан');
            }

          

            // Проверяем существование комментария
            $comment = get_comment($comment_id);
            if (!$comment) {
              
                wp_send_json_error('Комментарий не найден');
            }

           

            // Проверяем права пользователя
            if (!current_user_can('edit_comment', $comment_id)) {
             
                wp_send_json_error('Недостаточно прав');
            }

            // Проверяем статус комментария
           
            
            if ($comment->comment_approved !== 'trash') {
             
                wp_send_json_error('Комментарий не находится в корзине');
            }

            // Восстанавливаем комментарий
            $result = CommentRestoreModel::restore_comment($comment_id);
            
            if ($result) {
              
                wp_send_json_success();
            } else {
              
                wp_send_json_error('Не удалось восстановить комментарий');
            }
        } catch (Exception $e) {
          
            wp_send_json_error('Произошла ошибка при восстановлении комментария: ' . $e->getMessage());
        }
    }
} 

add_action('wp_ajax_restore_comment', ['CommentRestoreController', 'handle_restore_comment']);
add_action('wp_ajax_nopriv_restore_comment', ['CommentRestoreController', 'handle_restore_comment']);
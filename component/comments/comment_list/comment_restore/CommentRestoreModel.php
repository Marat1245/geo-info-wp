<?php
class CommentRestoreModel {
   

    public static function restore_comment($comment_id) {
        try {
            
            // Получаем предыдущий статус комментария
            $previous_status = get_comment_meta($comment_id, 'previous_status', true);
           
            
            // Проверяем текущий статус комментария
            $comment = get_comment($comment_id);
            if (!$comment) {
              
                return false;
            }
            
         
            
            // Восстанавливаем комментарий
            $result = wp_untrash_comment($comment_id);
          
            
            if ($result && $previous_status) {
             
                // Восстанавливаем предыдущий статус
                $status_result = wp_set_comment_status($comment_id, $previous_status);
       
                
                delete_comment_meta($comment_id, 'previous_status');
             
            }
            
            // Проверяем финальный статус
            $comment = get_comment($comment_id);
        
            
            return $result;
        } catch (Exception $e) {
          
            return false;
        }
    }
} 
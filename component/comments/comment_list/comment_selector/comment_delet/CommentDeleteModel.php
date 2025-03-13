<?php

class CommentDeleteModel {
    public static function delete_comment($comment_id) {
        // Получаем текущий статус комментария
        $comment = get_comment($comment_id);
        if (!$comment) {
            return false;
        }

        // Сохраняем текущий статус как мета-данные для возможности восстановления
        update_comment_meta($comment_id, 'previous_status', $comment->comment_approved);
        
        // Помечаем комментарий как удаленный (trash)
        wp_trash_comment($comment_id);
        
        return true;
    }

    public static function restore_comment($comment_id) {
        // Получаем предыдущий статус комментария
        $previous_status = get_comment_meta($comment_id, 'previous_status', true);
        
        // Восстанавливаем комментарий
        $result = wp_untrash_comment($comment_id);
        
        if ($result && $previous_status) {
            // Восстанавливаем предыдущий статус
            wp_set_comment_status($comment_id, $previous_status);
            delete_comment_meta($comment_id, 'previous_status');
        }
        
        return $result;
    }
} 
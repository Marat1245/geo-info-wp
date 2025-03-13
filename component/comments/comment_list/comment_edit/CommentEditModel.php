<?php
class CommentEditModel {
    public static function update_comment($comment_id, $content) {
        if (!$comment_id) {
            return false;
        }

        $comment = get_comment($comment_id);
        if (!$comment || $comment->user_id != get_current_user_id()) {
            return false;
        }

        $result = wp_update_comment(array(
            'comment_ID' => $comment_id,
            'comment_content' => $content
        ));

        if ($result) {
            // Сохраняем информацию об изменении
            update_comment_meta($comment_id, 'comment_edited', true);
            update_comment_meta($comment_id, 'comment_edited_date', current_time('mysql'));
        }

        return $result ? true : false;
    }

    public static function get_comment_content($comment_id) {
        $comment = get_comment($comment_id);
        return $comment ? $comment->comment_content : '';
    }

    public static function is_comment_edited($comment_id) {
        return get_comment_meta($comment_id, 'comment_edited', true);
    }

    public static function get_comment_edit_date($comment_id) {
        return get_comment_meta($comment_id, 'comment_edited_date', true);
    }
} 
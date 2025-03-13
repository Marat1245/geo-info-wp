<?php

class InputCommentModel {
    /**
     * Создает новый комментарий
     *
     * @param array $comment_data Данные комментария
     * @return array Результат создания комментария
     */
    public static function create_comment($comment_data) {
        if (empty($comment_data['post_id']) || empty($comment_data['content'])) {
            return array(
                'success' => false,
                'message' => 'Необходимо заполнить все поля'
            );
        }

        $user = wp_get_current_user();
        
        $commentdata = array(
            'comment_post_ID' => intval($comment_data['post_id']),
            'comment_content' => wp_kses_post($comment_data['content']),
            'comment_type' => 'comment',
            'comment_parent' => 0,
            'user_id' => $user->ID,
            'comment_author' => $user->display_name,
            'comment_author_email' => $user->user_email,
            'comment_date' => current_time('mysql')
        );

        $comment_id = wp_insert_comment($commentdata);

        if (!$comment_id) {
            return array(
                'success' => false,
                'message' => 'Ошибка при создании комментария'
            );
        }

        $comment = get_comment($comment_id);
        $timestamp = strtotime($comment->comment_date);
        $current_time = current_time('timestamp');
        
        // Если прошло меньше минуты
        if (($current_time - $timestamp) < 60) {
            $date = 'только что';
        } 

        // Получаем количество лайков для нового комментария
        $likes = get_comment_meta($comment_id, 'likes_count', true) ?: 0;
        $my_likes = get_comment_meta($comment_id, 'user_' . $user->ID . '_like', true) ? 'liked' : '';

        return array(
            'success' => true,
            'comment' => array(
                'id' => $comment->comment_ID,
                'author' => $comment->comment_author,
                'content' => $comment->comment_content,
                'date' => $date,
                'likes' => $likes,
                'my_likes' => $my_likes
            )
        );
    }
} 
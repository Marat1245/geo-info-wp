<?php
class LikeModel {
    // Получение количества лайков
    public static function get_likes($post_id) {
        return get_post_meta($post_id, 'load_like', true) ?: 0; // если лайков нет, возвращаем 0
    }

    // Обновление количества лайков
    public static function update_likes($post_id, $likes) {
        update_post_meta($post_id, 'load_like', $likes);
    }

    public static function my_likes($post_id) {
        $user_id = get_current_user_id();

        if (!$user_id) {
            return ''; // Если пользователь не авторизован
        }

        // Получаем список пользователей, которые лайкнули этот пост
        $liked_users = get_post_meta($post_id, '_liked_users', true) ?: [];


        // Проверяем, есть ли ID текущего пользователя в массиве
        return in_array($user_id, $liked_users) ? 'liked' : '';

    }



}

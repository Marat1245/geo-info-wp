<?php
class LikeController {
    public static function load_like() {
        check_ajax_referer('load_like_nonce', 'nonce');

        // Проверяем, авторизован ли пользователь
//        if (is_user_logged_in()) {
//          wp_send_json_error(['message' => 'Для того чтобы поставить лайк, нужно авторизоваться.']);
//
//        }

        if (!isset($_POST['post_id']) || !is_numeric($_POST['post_id'])) {
            wp_send_json_error(['message' => 'Некорректный ID поста.']);
        }

        $post_id = intval($_POST['post_id']);
        $user_id = get_current_user_id(); // ID текущего пользователя

        // Получаем список лайкнувших пользователей
        $liked_users = get_post_meta($post_id, '_liked_users', true);
        if (!is_array($liked_users)) {
            $liked_users = [];
        }

        // Получаем текущее количество лайков
        $likes = (int) get_post_meta($post_id, 'load_like', true);

        if (in_array($user_id, $liked_users)) {
            // Убираем лайк
            $liked_users = array_values(array_diff($liked_users, [$user_id]));
            $likes = max(0, $likes - 1); // Не даём уйти в отрицательные значения
        } else {
            // Добавляем лайк
            $liked_users[] = $user_id;
            $likes++;
        }

        // Обновляем данные в мета-полях
        delete_post_meta($post_id, '_liked_users'); // Удаляем перед обновлением, если массив
        update_post_meta($post_id, '_liked_users', $liked_users);
        update_post_meta($post_id, 'load_like', $likes);

        // Возвращаем ответ с актуальными данными
        wp_send_json_success([
            'likes' => $likes,
            'liked' => in_array($user_id, $liked_users),
        ]);
    }
}

// Регистрируем AJAX-обработчики
add_action('wp_ajax_load_like', array('LikeController', 'load_like'));
add_action('wp_ajax_nopriv_load_like', array('LikeController', 'load_like'));

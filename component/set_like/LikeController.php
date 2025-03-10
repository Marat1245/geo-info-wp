<?php
class LikeController {
    public static function load_like() {
        // Очищаем буфер вывода
        ob_clean();
        
        check_ajax_referer('load_like_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(['message' => 'Необходима авторизация для выполнения этого действия.']);
        }

        if (!isset($_POST['post_id']) || !is_numeric($_POST['post_id'])) {
            wp_send_json_error(['message' => 'Некорректный ID поста.']);
        }

        $post_id = intval($_POST['post_id']);
        $user_id = get_current_user_id();

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
            $likes = max(0, $likes - 1);
        } else {
            // Добавляем лайк
            $liked_users[] = $user_id;
            $likes++;
        }

        // Обновляем данные в мета-полях
        update_post_meta($post_id, '_liked_users', $liked_users);
        update_post_meta($post_id, 'load_like', $likes);

        // Формируем ответ
        $response = [
            'success' => true,
            'data' => [
                'likes' => $likes,
                'liked' => in_array($user_id, $liked_users)
            ]
        ];

        // Отправляем заголовки
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, must-revalidate');
        
        // Отправляем ответ
        echo json_encode($response);
        wp_die();
    }
}

// Регистрируем AJAX-обработчик только для авторизованных пользователей
add_action('wp_ajax_load_like', array('LikeController', 'load_like'));

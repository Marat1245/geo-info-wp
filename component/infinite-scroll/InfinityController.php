<?php
class InfinityController
{
    public static function load_infinity()
    {

        check_ajax_referer('load_infinity_nonce', 'nonce');

        $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        $post_type = isset($_POST['post_type']) ? $_POST["post_type"] : 'news';
        $exclude_post_id = isset($_POST['exclude_post_id']) ? $_POST['exclude_post_id'] : [];


        $posts = InfinityModel::get_infinity($exclude_post_id, $paged, $post_type, 5);

        // Проверка результата получения постов
        if (empty($posts)) {
            wp_send_json_error(array('message' => 'Постов не найдено для данного запроса.'));
        }
        // Формируем результат для успешного ответа      
        ob_start();
        foreach ($posts as $post) {
            InfinityView::render($post);
        }
        $output = ob_get_clean();
        // Успешный ответ
        wp_send_json_success(array(
            'message' => 'Посты успешно загружены.',
            'html' => $output, // Отправляем содержимое
            'page' => $paged // Отправляем текущую страницу
        ));



    }

}

// Регистрация AJAX-обработчиков
add_action('wp_ajax_load_infinity', array('InfinityController', 'load_infinity'));
add_action('wp_ajax_nopriv_load_infinity', array('InfinityController', 'load_infinity'));
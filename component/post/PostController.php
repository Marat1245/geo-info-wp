<?php
class PostController
{
    //
    // Обработчик AJAX-запроса
    //
    public static function load_more_posts()
    {
        // Проверка nonce      
        check_ajax_referer('load_more_posts_nonce', 'nonce');

        // Проверка параметра 'page'
        $paged = isset($_POST['page']) ? intval($_POST['page']) + 1 : 1;
        // Проверка параметра 'post_type'
        $post_type = isset($_POST['post_type']) ? $_POST['post_type'] : '';

        // Получаем посты
        $posts = PostModel::get_news($paged, $post_type, 5);

        // Проверка результата получения постов
        if (empty($posts)) {
            wp_send_json_error(array('message' => 'Постов не найдено для данного запроса.'));
        }

        // Формируем результат для успешного ответа      
        ob_start();
        foreach ($posts as $post) {
            PostView::render($post, $post_type); // Сохранение вывода для всех постов
        }
        $output = ob_get_clean();
        // Успешный ответ
        wp_send_json_success(array(
            'message' => 'Посты успешно загружены.',
            'html' => $output, // Отправляем содержимое
            'page' => $paged // Отправляем текущую страницу
        ));
    }




    //
    // Отображение постов
    //
    public static function show_post($paged = 1, $post_type = 'news', $count = 5)
    {
        // Получаем посты
        $posts = PostModel::get_news($paged, $post_type, $count);

        // Если посты найдены, выводим их
        foreach ($posts as $post) {
            PostView::render($post, $post_type);
        }
    }
}

add_action('wp_ajax_load_more_posts', array('PostController', 'load_more_posts'));
add_action('wp_ajax_nopriv_load_more_posts', array('PostController', 'load_more_posts'));


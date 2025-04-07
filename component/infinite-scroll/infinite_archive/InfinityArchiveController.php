<?php
class InfinityArchiveController
{
    public function __construct()
    {
        add_action('wp_ajax_load_infinity_archive', array($this, 'run'));
        add_action('wp_ajax_nopriv_load_infinity_archive', array($this, 'run'));
    }

    public function run()
    {
        // Security check for AJAX requests
        check_ajax_referer('load_infinity_archive_nonce', 'nonce');

        // Sanitize and set default values for incoming POST data
        $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $post_type = isset($_POST['post_type']) ? $_POST["post_type"] : 'news';
        $post_number = isset($_POST['number']) ? intval($_POST['number']) : 10;


        $posts = InfinityArchiveModel::get_posts($post_type, $post_number, $paged);

        // Проверка результата получения постов
        if (empty($posts)) {
            wp_send_json_error(array('message' => 'Постов не найдено для данного запроса.'));
        }
        // Формируем результат для успешного ответа      
        ob_start();
        foreach ($posts as $post) {
            PostListView::renderPost($post, $post_type);
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

new InfinityArchiveController();
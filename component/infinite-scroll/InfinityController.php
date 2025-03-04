<?php
class InfinityController {
    public static function load_infinity() {

        check_ajax_referer('load_infinity_nonce', 'nonce');
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_infinity_nonce')) {
            wp_send_json_error('Ошибка безопасности.');
        }

        $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        $news_query = InfinityModel::get_infinity($paged);

        if ($news_query->have_posts()) {
            ob_start();
            while ($news_query->have_posts()) {
                $news_query->the_post();
                InfinityView::render_infinity($news_query->post); // Подключаем представление для одного поста

            }
            wp_reset_postdata();
            $output = ob_get_clean();
            echo $output;

            // Подключаем скрипт для работы с комментариями после загрузки
            wp_enqueue_script('comment-reply');
        } else {
            echo ''; // Если постов нет, ничего не выводим
        }
        wp_die();



    }
}

// Регистрация AJAX-обработчиков
add_action('wp_ajax_load_infinity', array('InfinityController', 'load_infinity'));
add_action('wp_ajax_nopriv_load_infinity', array('InfinityController', 'load_infinity'));
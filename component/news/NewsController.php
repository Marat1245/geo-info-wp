<?php
class NewsController {
    public static function load_more_news() {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_more_news_nonce')) {
            wp_send_json_error('Ошибка безопасности. Неверный nonce: ' . $_POST['nonce']);
        }

        $paged = isset($_POST['page']) ? intval($_POST['page']) + 1 : 1;

        $news_query = NewsModel::get_news($paged);

        if ($news_query->have_posts()) {
            ob_start();
            while ($news_query->have_posts()) {
                $news_query->the_post();
                NewsView::render_news($news_query->post);
            }
            wp_reset_postdata();
            $output = ob_get_clean();
            wp_send_json_success($output);
        } else {
            wp_send_json_error(['message' => 'Новостей больше нет']);
        }

        wp_die(); // Для предотвращения лишнего вывода



    }
}

add_action('wp_ajax_load_more_news', array('NewsController', 'load_more_news'));
add_action('wp_ajax_nopriv_load_more_news', array('NewsController', 'load_more_news'));


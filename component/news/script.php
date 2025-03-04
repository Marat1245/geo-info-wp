<?php
function enqueue_load_more_script() {
    wp_enqueue_script('load-more-news', get_template_directory_uri() . '/component/news/load-news.js', array(), null, true);
    wp_localize_script('load-more-news', 'geoInfoNews', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('load_more_news_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_script');
<?php
require_once get_template_directory() . '/component/post/PostModel.php';
require_once get_template_directory() . '/component/post/PostView.php';
require_once get_template_directory() . '/component/post/PostController.php';
function enqueue_load_more_script()
{
    wp_enqueue_script('load_more_posts', get_template_directory_uri() . '/component/post/load-news.js', array(), null, true);
    wp_localize_script('load_more_posts', 'load_more_posts', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('load_more_posts_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_script');
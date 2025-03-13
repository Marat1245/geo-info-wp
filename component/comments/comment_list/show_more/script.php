<?php

require get_template_directory() . '/component/comments/comment_list/show_more/ShowMoreController.php';
require get_template_directory() . '/component/comments/comment_list/show_more/ShowMoreView.php';
function enqueue_show_more_script() {
    wp_enqueue_script('show_more', get_template_directory_uri() . '/component/comments/comment_list/show_more/show_more.js', array(), '1.0', true);

    wp_localize_script('show_more', 'show_more', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('show_more_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_show_more_script');

?>
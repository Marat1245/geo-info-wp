<?php 
require get_template_directory() . '/component/comments/input/InputCommentView.php';

function enqueue_comment_placeholder_main() {
    wp_enqueue_script('comment-placeholder-main', get_template_directory_uri() . '/component/comments/input/comment_placeholder_main.js', array(), null, true);
    wp_localize_script('comment-placeholder-main', 'geoInfoCommentPlaceholder', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('comment_placeholder_main_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_comment_placeholder_main');


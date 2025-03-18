<?php

require get_template_directory() . '/component/comments/comment_list/show_more/ShowMoreController.php';
require get_template_directory() . '/component/comments/comment_list/show_more/ShowMoreView.php';
require get_template_directory() . '/component/comments/comment_list/show_more/ShowMoreModel.php';
require get_template_directory() . '/component/comments/comment_list/show_more/show_undercomment/ShowUndercommentController.php';
require get_template_directory() . '/component/comments/comment_list/show_more/show_undercomment/ShowUndercommentView.php';
require get_template_directory() . '/component/comments/comment_list/show_more/show_undercomment/ShowUndercommentModel.php';

function enqueue_show_more_script() {
    wp_enqueue_script('show_more', get_template_directory_uri() . '/component/comments/comment_list/show_more/show_more.js', array(), '1.0', true);
    wp_enqueue_script('show_undercomment', get_template_directory_uri() . '/component/comments/comment_list/show_more/show_undercomment/show_undercomment.js', array(), '1.0', true);
    
    wp_localize_script('show_more', 'show_more', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('show_more_nonce')
    ));
    wp_localize_script('show_undercomment', 'show_undercomment', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('show_undercomment_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_show_more_script');

?>
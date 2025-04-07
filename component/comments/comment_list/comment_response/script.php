<?php
require_once get_template_directory() . '/component/comments/comment_list/comment_response/CommentResponseController.php';
require_once get_template_directory() . '/component/comments/comment_list/comment_response/CommentResponseView.php';


function enqueue_comment_response_script() {
    wp_enqueue_script( 'comment_manager', get_template_directory_uri() . '/component/comments/comment_list/comment_response/js/manager_comment_response.js', array(), '1.0', true);

    wp_enqueue_script( 'comment_response',  get_template_directory_uri() . '/component/comments/comment_list/comment_response/comment_response.js', array('comment_manager'), '1.0',  true );

    wp_localize_script('comment_response', 'comment_response', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('comment_response_nonce'),
        'templateUrl' => get_template_directory_uri()
    ));

    // Добавляем type="module" к скриптам
    add_filter('script_loader_tag', function ($tag, $handle) {
        if (in_array($handle, array('comment_response'))) {
            return str_replace(' src', ' type="module" src', $tag);
        }
        return $tag;
    }, 10, 2);
}
add_action('wp_enqueue_scripts', 'enqueue_comment_response_script'); 
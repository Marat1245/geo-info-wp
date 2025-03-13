<?php
require_once __DIR__ . '/CommentResponseController.php';

// Инициализируем контроллер
CommentResponseController::init();

function register_comment_response_scripts() {
    wp_enqueue_script(
        'comment-manager',
        get_template_directory_uri() . '/component/comments/comment_list/comment_response/js/manager_comment_response.js',
        array('jquery'),
        '1.0.0',
        true
    );

    wp_enqueue_script(
        'comment-response',
        get_template_directory_uri() . '/component/comments/comment_list/comment_response/comment_response.js',
        array('jquery', 'comment-manager'),
        '1.0.0',
        true
    );

    wp_localize_script('comment-response', 'comment_ajax', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('comment_ajax_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'register_comment_response_scripts'); 
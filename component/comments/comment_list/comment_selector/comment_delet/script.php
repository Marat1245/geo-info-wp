<?php 
require get_template_directory() . '/component/comments/comment_list/comment_selector/comment_delet/CommentDeleteModel.php';
require get_template_directory() . '/component/comments/comment_list/comment_selector/comment_delet/CommentDeleteController.php';

// Инициализируем контроллер
CommentDeleteController::init();

function enqueue_comment_delet_script() {
    wp_enqueue_script('comment-actions', get_template_directory_uri() . '/component/comments/comment_list/comment_selector/comment_delet/js/comment_actions.js', array(), '1.0', true);
    wp_localize_script('comment-actions', 'comment_actions', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('comment_actions_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_comment_delet_script');



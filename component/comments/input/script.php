<?php 
require_once get_template_directory() . '/component/comments/input/InputCommentView.php';
require_once get_template_directory() . '/component/comments/input/InputCommentModel.php';
require_once get_template_directory() . '/component/comments/input/InputCommentController.php';

function enqueue_input_comment_script() {
    wp_enqueue_script('comment-template', get_template_directory_uri() . '/component/comments/input/js/template_comment.js', array(), '1.0', true);
    wp_enqueue_script('input-comment', get_template_directory_uri() . '/component/comments/input/input_comment.js', array(), '1.0', true);
    wp_enqueue_script('comment-placeholder-main', get_template_directory_uri() . '/component/comments/input/js/comment_placeholder_main.js', array(), '1.0', true);
    wp_enqueue_script('comment-text-collapse', get_template_directory_uri() . '/component/comments/input/js/comment_text_collapse.js', array(), '1.0', true);
    
    wp_localize_script('input-comment', 'input_comment', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'templateUrl' => get_template_directory_uri(),
        'nonce' => wp_create_nonce('comment_nonce')
    ));

    // Добавляем type="module" к скриптам
    add_filter('script_loader_tag', function ($tag, $handle) {
        if (in_array($handle, array('input-comment', 'comment-template'))) {
            return str_replace(' src', ' type="module" src', $tag);
        }
        return $tag;
    }, 10, 2);
}
add_action('wp_enqueue_scripts', 'enqueue_input_comment_script');



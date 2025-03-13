<?php
require get_template_directory() . '/component/comments/comment_list/comment_edit/CommentEditView.php';
require get_template_directory() . '/component/comments/comment_list/comment_edit/CommentEditController.php';
require get_template_directory() . '/component/comments/comment_list/comment_edit/CommentEditModel.php';


function enqueue_edit_comment_script() { 
    wp_enqueue_script('comment-edit', get_template_directory_uri() . '/component/comments/comment_list/comment_edit/js/comment_edit.js', array('jquery'),  '1.0',  true );
    wp_localize_script('comment-edit', 'comment_edit', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('comment_edit_nonce'),
        'templateUrl' => get_template_directory_uri()
    ));
     // Добавляем type="module" к скриптам
     add_filter('script_loader_tag', function ($tag, $handle) {
        if (in_array($handle, array('comment-edit'))) {
            return str_replace(' src', ' type="module" src', $tag);
        }
        return $tag;
    }, 10, 2);
}
add_action('wp_enqueue_scripts', 'enqueue_edit_comment_script');

<?php 
require get_template_directory() . '/component/comments/comment_list/comment_controller/CommentControllerView.php';
require get_template_directory() . '/component/comments/comment_list/comment_controller/CommentLikeController.php';
require get_template_directory() . '/component/comments/comment_list/comment_controller/CommentLikeModel.php';

function enqueue_comment_controller_script() {
    wp_enqueue_script('comment_controller', get_template_directory_uri() . '/component/comments/comment_list/comment_controller/comment_controller.js', array(), '1.0.0', true);

    wp_localize_script('comment_controller', 'comment_controller', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('comment_controller_nonce'),
        'isLoggedIn' => is_user_logged_in(),
        'loginUrl' => wp_login_url(get_permalink()),
        'themeUrl' => get_template_directory_uri(),
        'messages' => array(
            'loginRequired' => 'Необходима авторизация для выполнения этого действия.',
            'error' => 'Произошла ошибка при обработке запроса.'
        )
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_comment_controller_script');


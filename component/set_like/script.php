<?php
function enqueue_load_like_script (){
    wp_enqueue_script('load_like', get_template_directory_uri() . '/component/set_like/load-like.js', array(), '1.0.0', true);

    wp_localize_script('load_like', 'geoInfoLike', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce("load_like_nonce"),
        'isLoggedIn' => is_user_logged_in(),
        'loginUrl' => wp_login_url(get_permalink()),
        'messages' => array(
            'loginRequired' => 'Необходима авторизация для выполнения этого действия.',
            'error' => 'Произошла ошибка при обработке запроса.'
        )
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_load_like_script');

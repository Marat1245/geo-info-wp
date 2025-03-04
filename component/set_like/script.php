<?php
function enqueue_load_like_script (){
    wp_enqueue_script('load_like', get_template_directory_uri() . '/component/set_like/load-like.js', array(), null, true);

    wp_localize_script('load_like', 'geoInfoLike', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce("load_like_nonce"),
    ));

}
add_action('wp_enqueue_scripts', 'enqueue_load_like_script');

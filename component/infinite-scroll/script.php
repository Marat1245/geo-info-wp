<?php
function enqueue_load_infinity_script() {
    wp_enqueue_script('load_infinity', get_template_directory_uri() . '/component/infinite-scroll/lazy-load.js', array(), null, true);
    wp_localize_script('load_infinity', 'geoInfoInfinity', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('load_infinity_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_load_infinity_script');


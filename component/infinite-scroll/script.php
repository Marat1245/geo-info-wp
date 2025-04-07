<?php
require_once get_template_directory() . "/component/infinite-scroll/infinite_archive/InfinityArchiveController.php";
require_once get_template_directory() . "/component/infinite-scroll/infinite_archive/InfinityArchiveModel.php";

function enqueue_load_infinity_script()
{
    wp_enqueue_script('load_infinity', get_template_directory_uri() . '/component/infinite-scroll/lazy-load.js', array(), null, true);
    wp_enqueue_script('load_infinity_archive', get_template_directory_uri() . '/component/infinite-scroll/infinite_archive/lazy_load_archive.js', array(), null, true);
    wp_enqueue_script('virtual_scrolling', get_template_directory_uri() . '/component/infinite-scroll/js/virtual_scrolling.js', array(), null, true);

    wp_localize_script('load_infinity', 'geoInfoInfinity', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('load_infinity_nonce'),
    ));
    wp_localize_script('load_infinity_archive', 'load_infinity_archive', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('load_infinity_archive_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_load_infinity_script');


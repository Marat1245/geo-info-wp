<?php
/**
 * Подключение скриптов и стилей для Lightbox
 */

function enqueue_lightbox_scripts() {
    // Подключаем стили Fancybox
    wp_enqueue_style(
        'fancybox-css', 
        'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css',
        array(),
        '5.0'
    );
    
    // Подключаем скрипт Fancybox
    wp_enqueue_script(
        'fancybox-js',
        'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js',
        array('jquery'),
        '5.0',
        true
    );
    
    // Подключаем наш скрипт для инициализации Lightbox
    wp_enqueue_script(
        'lightbox-init',
        get_template_directory_uri() . '/component/lightbox/lightbox.js',
        array('fancybox-js'),
        "1.0.0",
        true
    );
}

add_action('wp_enqueue_scripts', 'enqueue_lightbox_scripts');
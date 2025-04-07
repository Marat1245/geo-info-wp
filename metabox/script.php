<?php

// Регистрируем метаполе для хранения флага "Препринт"
add_action('init', function () {
    register_post_meta('', '_custom_preprint', [
        'show_in_rest' => true,
        'single' => true,
        'type' => 'boolean',
        'auth_callback' => function () {
            return current_user_can('edit_posts');
        }
    ]);
});

function add_preprint_checkbox()
{
    wp_enqueue_script(
        'preprint-checkbox',
        get_template_directory_uri() . '/metabox/preprint-checkbox.js', // Убедитесь, что путь правильный
        ['wp-edit-post', 'wp-element', 'wp-components', 'wp-data', 'wp-api-fetch'],
        null,
        true
    );
}
add_action('enqueue_block_editor_assets', 'add_preprint_checkbox');


//
//
//
//
//
/**
 * Добавляем кастомную секцию для загрузки файлов в панель "Документ"
 */

// 1. Регистрируем метаполе для хранения ID файла
add_action('init', function () {
    register_post_meta('', '_custom_file_id', [
        'show_in_rest' => true,
        'single' => true,
        'type' => 'number',
        'auth_callback' => function () {
            return current_user_can('edit_posts');
        }
    ]);
});

// 2. Подключаем скрипт
add_action('enqueue_block_editor_assets', function () {
    wp_enqueue_script(
        'custom-file-panel',
        get_template_directory_uri() . '/metabox/custom-file-panel.js',
        ['wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data', 'wp-api-fetch'],
        filemtime(get_template_directory() . '/metabox/custom-file-panel.js')
    );

    // Передаем данные в JS
    wp_localize_script('custom-file-panel', 'customFilePanelSettings', [
        'currentFile' => get_post_meta(get_the_ID(), '_custom_file_id', true),
        'allowedTypes' => ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
        'restUrl' => rest_url('wp/v2/media/'),
        'nonce' => wp_create_nonce('wp_rest')
    ]);
});

// 
// 
// 
// 
// 
add_action('enqueue_block_editor_assets', function () {
    wp_enqueue_script(
        'custom-annotation-block', // Имя скрипта
        get_template_directory_uri() . '/metabox/annotation-block.js', // Путь к скрипту
        ['wp-blocks', 'wp-element', 'wp-components', 'wp-editor'], // Все необходимые зависимости
        filemtime(get_template_directory() . '/metabox/annotation-block.js'), // Дата модификации файла
        true // Включаем загрузку в футер
    );
});

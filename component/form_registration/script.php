<?php
require_once get_template_directory() . "/component/form_registration/form_registration.php";
require_once get_template_directory() . "/component/form_registration/form_log_in.php";
require_once get_template_directory() . "/component/form_registration/resend_letter/resend_email.php";
require_once get_template_directory() . '/component/form_registration/reset-password/reset-password.php';

function enqueue_form_registration_scripts()
{
    $scripts = [
        'form_registration' => '/component/form_registration/form_registration.js',
        'switch_form' => '/component/form_registration/switch_form.js',
        'resend_email' => '/component/form_registration/resend_letter/resend_email.js',
        'timer_reset' => '/component/form_registration/reset-password/timer_reset.js',
    ];

    foreach ($scripts as $handle => $relative_path) {
        $full_path = get_template_directory() . $relative_path;
        $uri_path = get_template_directory_uri() . $relative_path;

        $version = file_exists($full_path) ? filemtime($full_path) : '1.0.0';

        wp_enqueue_script(
            $handle,
            $uri_path,
            array(), // Здесь можно указать зависимости, например: array('jquery')
            $version,
            true
        );

        // Только для одного скрипта делаем wp_localize_script
        if ($handle === 'form_registration') {
            wp_localize_script($handle, 'form_registration', [
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('form_registration_nonce'),
            ]);
        }
        if ($handle === 'resend_email') {
            wp_localize_script($handle, 'resend_email', [
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('resend_email_nonce'),
            ]);
        }
    }
}

add_action('wp_enqueue_scripts', 'enqueue_form_registration_scripts');

<?php
add_action('init', 'handle_custom_user_login');

function handle_custom_user_login()
{
    if (!isset($_POST['custom_login']))
        return;

    $username_or_email = sanitize_text_field($_POST['username']);
    $password = $_POST['password'];

    // Определяем логин по email, если введён email
    if (is_email($username_or_email)) {
        $user = get_user_by('email', $username_or_email);
        if ($user) {
            $username = $user->user_login;
        } else {
            $_SESSION['error_message_login'] = 'Пользователь с таким email не найден.';
            exit;
        }
    } else {
        $username = $username_or_email;
    }

    $credentials = [
        'user_login' => $username,
        'user_password' => $password,
        'remember' => true
    ];

    $user = wp_signon($credentials, false);

    if (is_wp_error($user)) {
        $_SESSION['error_message_login'] = 'Неверный логин или пароль.';
        wp_redirect(home_url('/log-in')); // Или твоя кастомная страница входа
        exit;
    }

    // Успешный вход
    wp_set_current_user($user->ID);
    wp_set_auth_cookie($user->ID, true);
    wp_redirect(home_url()); // или на личный кабинет
    exit;
}
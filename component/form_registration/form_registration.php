<?php
// Проверяем, была ли отправлена форма
// В начале вашего кода очистим ошибку, если она существует
if (isset($_SESSION['error_message'])) {
    $_SESSION['error_message'] = ''; // Удаляем сообщение после вывода
    $_SESSION['error_message'] = ''; // Удаляем сообщение после вывода 
}

add_action('init', 'handle_custom_user_registration');


function handle_custom_user_registration()
{
    if (!isset($_POST['custom_registration']))
        return;

    $username = sanitize_user($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    error_log($username);
    error_log($email);
    error_log($password);
    error_log($password_confirm);

    if ($password !== $password_confirm) {
        $_SESSION['error_message'] = 'Пароли не совпадают.';
        wp_redirect(home_url('/log-in'));
        exit;
    }

    // Создаём нового пользователя, но не активируем его сразу
    $user_id = wp_create_user($username, $password, $email);

    if (is_wp_error($user_id)) {
        $_SESSION['error_message'] = $user_id->get_error_message();
        wp_redirect(home_url('/log-in'));
        exit;
    }

    // Сохраняем токен активации
    $activation_key = md5($email . time());
    update_user_meta($user_id, 'activation_key', $activation_key);
    update_user_meta($user_id, 'is_activated', false);

    // Отправляем письмо с ссылкой для активации
    $activation_link = add_query_arg([
        'action' => 'activate',
        'user' => $user_id,
        'key' => $activation_key
    ], home_url('/account-activation'));


    wp_mail(
        $email,
        'Подтвердите ваш аккаунт',
        "Для активации вашего аккаунта, пожалуйста, перейдите по следующей ссылке: $activation_link"
    );

    // Авторизация нового пользователя
    wp_set_auth_cookie($user_id, true);
    wp_set_current_user($user_id);

    // Активируем BuddyPress-профиль, если функция доступна
    if (function_exists('bp_core_activated_user')) {
        bp_core_activated_user($user_id);
    }


    // $_SESSION['error_message'] = 'Проверьте вашу почту для подтверждения регистрации.';
    wp_redirect(home_url('/account-activation')); // Направляем на страницу входа
    exit;
}



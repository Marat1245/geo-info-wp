<?php
add_action('template_redirect', 'handle_custom_password_reset_request');

function handle_custom_password_reset_request()
{
    if (isset($_POST['custom_reset'])) {
        $email = sanitize_email($_POST['email']);

        if (!is_email($email)) {
            $_SESSION['error_message_reset'] = 'Неверный формат email.';
            wp_redirect($_SERVER['REQUEST_URI']);
            exit;
        }

        $user = get_user_by('email', $email);

        if (!$user) {
            $_SESSION['error_message_reset'] = 'Пользователь с такой почтой не найден.';
            wp_redirect($_SERVER['REQUEST_URI']);
            exit;
        }

        // Генерация и отправка ссылки на сброс
        $reset_key = get_password_reset_key($user);
        $reset_url = add_query_arg([
            'key' => $reset_key,
            'login' => rawurlencode($user->user_login)
        ], home_url('/reset-password')); // Указываешь свой путь

        wp_mail($email, 'Сброс пароля', "Ссылка для сброса пароля: $reset_url");


        $_SESSION['error_message_reset_success'] = 'Письмо отправлено! Проверьте почту.';
        wp_redirect($_SERVER['REQUEST_URI']);
        exit;
    }


    // Обработка сброса пароля
    $login = isset($_GET['login']) ? sanitize_user($_GET['login']) : '';
    $key = isset($_GET['key']) ? sanitize_text_field($_GET['key']) : '';
    $user = $login ? get_user_by('login', $login) : false;

    if (isset($_POST['custom_save_new_password']) && $user && check_password_reset_key($key, $login)) {
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];

        // Проверка на совпадение паролей
        if ($password !== $password_confirm) {
            $_SESSION['error_message_reset'] = 'Пароли не совпадают.';
            wp_redirect(get_permalink() . '?key=' . $key . '&login=' . $login);
            exit;
        } else {
            // Сброс пароля
            reset_password($user, $password);
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID);
            wp_redirect(home_url()); // Перенаправление после успешного сброса пароля
            exit;
        }
    }
}

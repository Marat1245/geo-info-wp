<?php
add_action('wp_ajax_resend_activation_email', 'resend_activation_email');
add_action('wp_ajax_nopriv_resend_activation_email', 'resend_activation_email');

function resend_activation_email()
{
    // Логируем начало обработки запроса
    error_log('Received AJAX request for resend_activation_email');

    check_ajax_referer('resend_email_nonce', 'nonce');

    if (isset($_POST['user_id']) && isset($_POST['activation_key'])) {
        $user_id = intval($_POST['user_id']);

        // Найдем пользователя
        $user = get_user_by('id', $user_id);

        if ($user) {

            // Логика для повторной отправки письма
            $new_activation_key = md5($user->user_email . time());
            update_user_meta($user_id, 'activation_key', $new_activation_key);
            update_user_meta($user_id, 'is_activated', false);

            $activation_link = add_query_arg([
                'action' => 'activate',
                'user' => $user_id,
                'key' => $new_activation_key
            ], home_url('/account-activation'));

            $mail_sent = wp_mail(
                $user->user_email,
                'Подтвердите ваш аккаунт',
                "Для активации вашего аккаунта, пожалуйста, перейдите по следующей ссылке: $activation_link"
            );

            if ($mail_sent) {
                error_log('Mail sent successfully');
                wp_send_json_success(['message' => 'Письмо успешно отправлено.']);
            } else {
                error_log('Mail sending failed');
                wp_send_json_error(['message' => 'Ошибка при отправке письма.']);
            }

        } else {
            wp_send_json_error(['message' => 'Пользователь не найден.']);
        }
    } else {
        wp_send_json_error(['message' => 'Отсутствуют необходимые параметры.']);
    }

    wp_die(); // Завершаем выполнение
}


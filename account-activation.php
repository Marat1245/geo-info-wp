<?php
/**
 * Template Name: Станица активации аккаунта
 * 
 * Шаблон для страницы активации аккаунта пользователя.
 */

// Начинаем буферизацию вывода
ob_start();

get_header(); ?>

<div class="seamless_bg">

    <div class="seamless_bg_grad login_page"></div>

    <div class="activation-page login">
        <div class="activation-container registration-form">
            <?php
            // Получаем параметры активации из URL
            if (isset($_GET['action']) && $_GET['action'] === 'activate') {
                $user_id = isset($_GET['user']) ? (int) $_GET['user'] : 0;
                $activation_key = isset($_GET['key']) ? sanitize_text_field($_GET['key']) : '';


                // Проверяем, что переданы все необходимые параметры
                if ($user_id && $activation_key) {

                    // Проверяем, существует ли пользователь с таким ID
                    $user = get_user_by('id', $user_id);
                    if ($user) {

                        $saved_key = get_user_meta($user_id, 'activation_key', true);
                        $is_activated = get_user_meta($user_id, 'is_activated', true);

                        // Если ключи совпадают и аккаунт ещё не активирован
                        if ($saved_key === $activation_key && !$is_activated) {

                            // Активируем аккаунт
                            update_user_meta($user_id, 'is_activated', true);
                            wp_set_current_user($user_id);
                            wp_set_auth_cookie($user_id);

                            // Перенаправляем на страницу активации с успешным сообщением
                            wp_redirect(home_url('/account-activation/?activate=true'));
                            exit; // Завершаем выполнение скрипта
                        } else {
                            wp_redirect(home_url('/account-activation/?error_message=invalid_key&user=' . $user_id . '&key=' . $activation_key));
                            exit; // Завершаем выполнение скрипта
                        }
                    } else {
                        wp_redirect(home_url('/account-activation/?error_message=user_not_found&user=' . $user_id . '&key=' . $activation_key));
                        exit; // Завершаем выполнение скрипта
                    }
                } else {
                    wp_redirect(home_url('/account-activation/?error_message=missing_parameters&user=' . $user_id . '&key=' . $activation_key));
                    exit; // Завершаем выполнение скрипта
                }
            }

            // Показать успешное сообщение, если активирован
            if (isset($_GET['activate']) && $_GET['activate'] === 'true') {
                echo '<h2>Ваш аккаунт успешно активирован!</h2>';
            }
            // Показать ошибки, если есть
            elseif (isset($_GET['error_message'])) {
                $error_message = 'Что то пошло не так. Попробуйте снова.'; // Значение по умолчанию
            
                ?>
                <h2><?= $error_message; ?></h2>
                <button type="button" class="normal_text primary" id="resend-email">Отправить письмо повторно</button>
                <?php

            }
            // Если это первый визит пользователя, показать стандартное сообщение
            else {
                echo '<h2>Пожалуйста, проверьте вашу электронную почту для активации аккаунта</h2>';
            }


            ?>

        </div>
    </div>
</div>

<?php
// Закрываем буферизацию вывода
ob_end_flush();

get_footer(); ?>
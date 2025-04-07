<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GeoInfo
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class('body'); ?>>
    <?php wp_body_open(); ?>

    <header class="container">
        <div class="header_container">
            <!-- Логотип -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="header_logo" alt="<?php bloginfo('name'); ?>">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<img src="' . esc_url(get_template_directory_uri() . '/img/logo.svg') . '" alt="' . esc_attr(get_bloginfo('name')) . '">';
                }
                ?>
            </a>

            <!-- Блок авторизации/аватара -->
            <div class="header_log selector_wrap">
                <?php if (!is_user_logged_in()): ?>
                    <a href="<?= get_permalink(151); ?>">
                        <button class="small_text primary" data-log='off'><span>Войти</span></button>
                    </a>
                <?php else: ?>
                    <div data-log="on">
                        <div class="header_avatar__wrap">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/user_24.svg'); ?>"
                                alt="Аватар" class="header_avatar">
                            <span class="notification_new"></span>
                        </div>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/arrow_down_20.svg'); ?>"
                            alt="Стрелка вниз">
                    </div>
                <?php endif; ?>
                <?php if (is_user_logged_in()): ?>
                    <!-- Выпадающее меню -->
                    <div class="selector selector_notification">
                        <div class="selector_first">
                            <a href="<?php echo esc_url(home_url('/profile')); ?>" class="profile_view">
                                <div class="profile_view_left">
                                    <img class="profile_view_ava"
                                        src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/user_24.svg'); ?>"
                                        alt="Аватар">
                                    <div class="profile_view_text">
                                        <span><?php echo esc_html(wp_get_current_user()->user_login); ?></span>
                                        <!-- <span>Садыров Марат</span> -->
                                        <span class="card_caption_text">Перейти в профиль</span>
                                    </div>
                                </div>
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/arrow_right_20.svg'); ?>"
                                    alt="Стрелка вправо">
                            </a>
                            <ul>
                                <li data-li="share">
                                    <div>
                                        <div class="selector_notification_wrap">
                                            <span class="notification_new"></span>
                                            <img src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/bell_20.svg'); ?>"
                                                alt="Уведомления">
                                        </div>Уведомления
                                    </div>
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/arrow_right_20.svg'); ?>"
                                        alt="Стрелка вправо">
                                </li>
                                <a href="<?php echo esc_url(home_url('/create_post')); ?>">
                                    <li><img src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/Edit_20.svg'); ?>"
                                            alt="Написать">Написать в ленту</li>
                                </a>
                                <a href="<?php echo wp_logout_url(home_url()); ?>">
                                    <li><img src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/logout_20.svg'); ?>"
                                            alt="Выход">Выход</li>
                                </a>

                                <li class="li_sub"><img
                                        src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/device-ipad-horizontal-plus_20.svg'); ?>"
                                        alt="Подписка">Оформить подписку</li>
                            </ul>
                        </div>
                        <div class="selector_second">
                            <div class="back_list">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/arrow_left_20.svg'); ?>"
                                    alt="Назад">Уведомления <span class="back_list_empty"></span>
                            </div>
                            <ul>
                                <li class="notification_li">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/img/avatar.png'); ?>"
                                        alt="Аватар">
                                    Новое мероприятие в 12:00 12.09.2024 Вам нужно генерировать больше лидов для вашего
                                    бизнеса?
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>
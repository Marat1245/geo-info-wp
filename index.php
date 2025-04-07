<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GeoInfo
 */

get_header();
?>
<!-- Большой логотип -->
<section class="header_logo_big container">
    <img src="<?php echo get_template_directory_uri(); ?>/img/logo_big.svg" alt="ГеоИнфо">
</section>

<div class="seamless_bg">
    <div class="seamless_bg_grad"></div>
    <!-- Линия текста, анимация -->
    <section class="anima_line">
        <div class="track">
            <div><img src="<?php echo get_template_directory_uri(); ?>/img/icons/circle.svg" alt=""></div>
            <div class="track_text">Перевод • События отрасли • Геориск • Инженерная геология </div>
            <div><img src="<?php echo get_template_directory_uri(); ?>/img/icons/3_line.svg" alt=""></div>
            <div class="track_text">Инженерные изыскания • Экология • Инженерная геология</div>
            <div><img src="<?php echo get_template_directory_uri(); ?>/img/icons/circle.svg" alt=""></div>
            <div class="track_text">Геофизика • Инженерные изыскания • Экология Инженерная геология • Геофизика</div>
        </div>
        <div class="track">
            <div><img src="<?php echo get_template_directory_uri(); ?>/img/icons/circle.svg" alt=""></div>
            <div class="track_text">Перевод • События отрасли • Геориск • Инженерная геология </div>
            <div><img src="<?php echo get_template_directory_uri(); ?>/img/icons/3_line.svg" alt=""></div>
            <div class="track_text">Инженерные изыскания • Экология • Инженерная геология</div>
            <div><img src="<?php echo get_template_directory_uri(); ?>/img/icons/circle.svg" alt=""></div>
            <div class="track_text">Геофизика • Инженерные изыскания • Экология Инженерная геология • Геофизика</div>
        </div>
    </section>

    <!-- News and menu -->
    <section class="container three_block_grid">
        <?php get_template_part('component/menu/menu'); ?>

        <div class="news__section">
            <div class="title_for_section__wrap title_news">
                <div class="title_for_section">
                    <a href="">
                        <h2>Новости</h2>
                    </a>
                </div>
            </div>
            <div class="news paper">

                <div class="new_list" id="news-container">

                    <?php
                    PostController::show_post(1, 'news');
                    ?>

                </div>


                <?php MoreBtnView::render('load-more-news', 'news'); ?>

            </div>

        </div>
        <div class="news_banner_wrap paper">
            <div class="news_banner">
                <a href=""><img src="<?php echo get_template_directory_uri(); ?>/img/banner_ver.png" alt=""
                        class="banner_top link_company"></a>
            </div>
        </div>

    </section>
    <!-- Banner -->
    <section class="banner container">
        <img src="<?php echo get_template_directory_uri(); ?>/img/banner_hor_01.png"
            class="banner_main_horizont_01 link_company "></img>
    </section>
    <!-- Banner END-->

    <!-- Sponsor and preprint  -->
    <section class="container two_block_grid">
        <?php
        // БЛОК СО СПНСОРАМИ
        get_template_part('template-parts/sponsors');
        ?>
        <div>
            <div class="content_block preprints_wraps">
                <div class="title_for_section__wrap">
                    <div class="title_for_section">
                        <a href="">
                            <h2>Препринты</h2>
                        </a>
                    </div>

                </div>
                <div id="post-container">
                    <?php
                    // ВСТАВЛЯЕМ ПОСТЫ
                    PostController::show_post(1, 'post');
                    ?>
                </div>
                <div class="preprints_more_btn paper">

                    <?php MoreBtnView::render('load-more-preprint', 'post'); ?>
                </div>
                <!-- Banner -->
                <div class="banner">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/banner_hor_01.png"
                        class="banner_main_horizont_01 link_company "></img>
                </div>
                <!-- Banner END-->

                <div class="post_users_wraps">

                    <div class="posts upload_list" data-post-type="post_users">
                        <div class="title_for_section__wrap">
                            <div class="title_for_section">
                                <a href="">
                                    <h2>Стена</h2>
                                </a>
                            </div>
                        </div>

                        <?php
                        // ВСТАВЛЯЕМ ПОСТЫ                        
                        PostController::show_post(1, 'post_users');
                        ?>

                    </div>
                    <!-- <div class="rek_left">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/banner_ver.png" alt=""
                            class="link_company ">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/banner_ver.png" alt=""
                            class="link_company ">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/banner_ver.png" alt=""
                            class="link_company ">
                    </div> -->
                </div>

            </div>

            <div class="container main_block main_block_posts">

                <div class="content_block">

                </div>
            </div>
        </div>

    </section>
    <!-- Sponsor and preprint  END -->

    <!-- POST -->

    <!-- POST END -->
    <?php

    get_footer();
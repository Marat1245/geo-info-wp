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


    <!-- Линия текста, анимация -->
    <section class="anima_line">
        <div class="track">
            <div><img src="<?php echo get_template_directory_uri(); ?>/img/icons/circle.svg" alt=""></div>
            <div>Перевод • События отрасли • Геориск • Инженерная геология </div>
            <div><img src="<?php echo get_template_directory_uri(); ?>/img/icons/3_line.svg" alt=""></div>
            <div>Инженерные изыскания • Экология • Инженерная геология</div>
            <div><img src="<?php echo get_template_directory_uri(); ?>/img/icons/circle.svg" alt=""></div>
            <div>Геофизика • Инженерные изыскания • Экология Инженерная геология • Геофизика</div>
        </div>
    </section>

    <!-- Большой логотип -->
    <section class="header_logo_big container">
        <img src="<?php echo get_template_directory_uri(); ?>/img/logo_big.svg" alt="ГеоИнфо">
    </section>

    <!-- News and menu -->
    <section class="container main_block">
        <?php get_template_part('component/menu/menu'); ?>

        <div class="content_block">
            <div class="title_for_section__wrap title_news">
                <div class="title_for_section">
                    <a href="">
                        <h2>Новости</h2>
                    </a>
                </div>
            </div>
            <div class="news__section">
                <div class="news paper">

                    <div class="new_list" id="news-container">

                        <?php
                        // Настроим параметры запроса
                        $args = array(
                            'post_type'      => 'news', // Тип постов 'news'
                            'posts_per_page' => 5,      // Ограничиваем вывод 5 постами
                            'orderby'        => 'date', // Сортировка по дате
                            'order'          => 'DESC', // В порядке убывания (от самых новых)
                            'paged'          =>  1, // Для пагинации
                        );

                        // Инициализируем WP_Query с нашими параметрами
                        $news_query = new WP_Query($args);

                        // Проверяем, есть ли посты
                        if ($news_query->have_posts()) {

                            // Перебираем посты
                            while ($news_query->have_posts()) {
                                $news_query->the_post(); // Подготавливаем текущий пост

                              NewsView::render_news($news_query);
                            }

                            wp_reset_postdata(); // Сбрасываем данные после цикла
                        } else {
                            echo '<p>Новостей не найдено.</p>';
                        }
                        ?>

                    </div>

                    <div class="more_btn" id="load-more-news">
                        <span >Ещё 5 новостей</span>
                        <img src="<?php echo get_template_directory_uri(); ?>/img/icons/arrow_down_20.svg" alt="">
                    </div>


                </div>

                <div class="news_banner_wrap paper">
                    <div class="news_banner">
                        <a href=""><img src="<?php echo get_template_directory_uri(); ?>/img/banner_ver.png" alt="" class="banner_top link_company"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php

get_footer();

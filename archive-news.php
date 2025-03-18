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

<section class="container main_block inner_page news_list_page">

<?php get_template_part('component/menu/menu'); ?>

<div class="show_list_wrap">
	
	<div class="content_block preprints_wraps">
	
		<?php 
		// ВСТАВЛЯЕМ ТАЙТЛ
		get_template_part('component/tags/tags_search');
	
		?>

            <div class="news paper">

                <div class="new_list" id="news-container">

                    <?php
                        // Настроим параметры запроса
                        $args = array(
                            'post_type'      => 'news', // Тип постов 'news'
                            'posts_per_page' => 50,      // Ограничиваем вывод 5 постами
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
          

        </div>
	</div>
</div>

</section>



<?php

get_footer();
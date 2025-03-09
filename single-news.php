<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package GeoInfo
 */

get_header();
?>
    <!-- Artical -->
    <section class="container main_block inner_page">
        <div class="inner_menu inner_menu_fixed">

            <?php get_template_part('component/menu/menu'); ?>
            <?php get_template_part('component/sponsors'); ?>



        </div>

        <div class="top_menu_mobile paper">
            <button class="flat small_icon"><img src="<?php echo get_template_directory_uri(); ?>/img/icons/arrow_left_20.svg" alt=""></button>
            <span>Новости</span>
            <div class="top_menu_mobile_none">
            </div>
        </div>
        <div>
            <div class="artical_column"  id="posts-container">

                <?php
                    while (have_posts()) : the_post();

                        get_template_part('template-parts/content', 'news');
                    endwhile;
                ?>

            </div>
            <div id="loading-indicator"></div>
            <div id="load-trigger"></div> <!-- Триггерный элемент для подгрузки -->
        </div>




    </section>

    <!-- Artical END /-->


<?php
get_footer();

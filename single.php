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
<div class="seamless_bg">

    <div class="seamless_bg_grad"></div>
    <!-- Artical -->
    <section class="container inner_page_articals inner_page" data-post-type="<?= get_post_type(); ?>">

        <div class="inner_menu inner_menu_fixed">

            <?php get_template_part('component/menu/menu'); ?>
            <?php
            // БЛОК СО СПНСОРАМИ
            get_template_part('template-parts/sponsors');
            ?>



        </div>

        <div class="top_menu_mobile paper">
            <?php $archive_link = get_post_type_archive_link('post'); ?>
            <a href="<?php echo esc_url($archive_link); ?>">
                <button class="flat small_icon"><img
                        src="<?php echo get_template_directory_uri(); ?>/img/icons/arrow_left_20.svg" alt=""></button>
            </a>
            <span><?php
            $post_type = get_post_type(); // Получаем тип текущей записи
            $post_type_object = get_post_type_object($post_type); // Получаем объект типа записи
            
            echo esc_html($post_type_object->labels->name);
            ?>
            </span>

            <div class="top_menu_mobile_none">
            </div>
        </div>
       
            <div class="artical_column" id="posts-container">

                <?php
                while (have_posts()):
                    the_post();


                    $categories = get_the_terms(get_the_ID(), 'category');
                    $categories = !empty($categories) && is_array($categories) ? $categories : [];

                    $post_data = [
                        'id' => get_the_ID(),
                        'title' => get_the_title(),
                        'link' => get_permalink(),
                        'image' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
                        'description' => wp_trim_words(get_the_content(), 60, '...'),
                        'category' => $categories,
                        'author' => get_the_author(),
                        'date' => time_ago_short(get_the_date('Y-m-d H:i:s')),
                        'comments_number' => get_comments_number(get_the_ID()),
                        'views' => get_post_meta(get_the_ID(), 'views', true),
                        'preprint' => has_term('preprint', 'post_tag', get_the_ID()),
                        'thumb' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
                        "thumbnail_caption" => get_the_post_thumbnail_caption(),
                        "content" => apply_filters('the_content', get_the_content()),
                        'tags' => wp_get_post_tags(get_the_ID(), ['fields' => 'names']),
                    ];
                    InfinityView::render($post_data);

                endwhile;
                ?>

            </div>
            <div id="loading-indicator"></div>
            <div id="load-trigger"></div> <!-- Триггерный элемент для подгрузки -->
        




    </section>

    <!-- Artical END /-->
</div>

<?php
get_footer();

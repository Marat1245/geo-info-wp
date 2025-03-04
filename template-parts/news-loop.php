<?php
/**
 * Шаблон для вывода списка новостей.
 *
 * @package GeoInfo
 */

$args = array(
    'post_type'      => 'news', // Тип записи "Пост" (или 'news', если у вас кастомный тип)
    'posts_per_page' => 5,      // Количество новостей
    'orderby'        => 'date', // Сортировка по дате
    'order'          => 'DESC', // По убыванию (новые сначала)
    'paged'          => get_query_var('paged', 1), // Текущая страница пагинации
);

$news_query = new WP_Query($args);

if ($news_query->have_posts()) :
    while ($news_query->have_posts()) : $news_query->the_post();
        get_template_part('component/load-more-news/news'); // Подключаем шаблон для одной новости
    endwhile;
    wp_reset_postdata(); // Сбрасываем настройки поста
else :
    echo '<p>Новостей пока нет.</p>';
endif;
?>
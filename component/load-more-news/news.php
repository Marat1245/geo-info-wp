<?php
/**
 * Шаблон для отображения одной новости.
 *
 * @package GeoInfo
 */

// Получаем данные новости
$post_time = get_the_time('U'); // Время публикации в формате Unix timestamp
$current_time = current_time('U'); // Текущее время в формате Unix timestamp
$time_diff = $current_time - $post_time; // Разница в секундах

// Форматируем время в зависимости от давности
if ($time_diff < 86400) {
    // Меньше суток: показываем время (например, 14:27)
    $time_display = get_the_time('H:i');
} elseif ($time_diff < 31536000) {
    // Меньше года: показываем дату (например, 27 сен)
    $time_display = get_the_time('j M');
} else {
    // Больше года: показываем полную дату (например, 27.09.23)
    $time_display = get_the_time('d.m.y');
}
?>
<div class="news_artical">
    <div class="news_first">
        <div class="news_dot">
            <img src="<?php echo get_template_directory_uri(); ?>/img/icons/circle.svg" alt="">
        </div>
        <a href="<?php the_permalink(); ?>" class="news_title link_grey_color">
            <?php the_title(); ?>
        </a>
    </div>
    <div class="news_second">
        <?php
        // Получаем одну рубрику
        $categories = get_the_terms(get_the_ID(), 'category');
        if ($categories && !is_wp_error($categories)) :
            $category = $categories[0]; // Берем первую рубрику
            ?>
            <span>
                <a href="<?php echo get_category_link($categories[0]->term_id); ?>" class="link_tag">
                    #<?php echo esc_html($categories[0]->name); ?>
                </a>
            </span>
            <span>
                <a href="<?php echo get_category_link($categories[1]->term_id); ?>" class="link_tag">
                    #<?php echo esc_html($categories[1]->name); ?>
                </a>
            </span>
        <?php endif; ?>



        <span class="card_caption_text">·</span>
        <span class="card_caption_text"><?php echo $time_display; ?></span>
    </div>
</div>
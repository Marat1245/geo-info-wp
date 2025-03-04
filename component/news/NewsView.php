<?php
class NewsView {
    public static function render_news($post) {
        setup_postdata($post);

        $post_time = get_the_time('U');
        $current_time = current_time('U');
        $time_diff = $current_time - $post_time;

        if ($time_diff < 86400) {
            $time_display = get_the_time('H:i');
        } elseif ($time_diff < 31536000) {
            $time_display = get_the_time('j M');
        } else {
            $time_display = get_the_time('d.m.y');
        }

        $categories = get_the_terms($post->ID, 'category');
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
                <?php if ($categories && !is_wp_error($categories)) : ?>
                    <?php foreach ($categories as $category) : ?>
                        <span>
                            <a href="<?php echo get_category_link($category->term_id); ?>" class="link_tag">
                                #<?php echo esc_html($category->name); ?>
                            </a>
                        </span>
                    <?php endforeach; ?>
                    <span class="card_caption_text">·</span>
                <?php endif; ?>


                <span class="card_caption_text"><?php echo $time_display; ?></span>
            </div>
        </div>
        <?php
        wp_reset_postdata();
    }
}
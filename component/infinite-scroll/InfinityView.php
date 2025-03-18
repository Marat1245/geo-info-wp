<?php
class InfinityView {
    public static function render_infinity($post, $post_link) {
        setup_postdata($post);

        get_template_part('template-parts/content', 'news', array('post_link' => $post_link));

        wp_reset_postdata(); // Сбрасываем данные поста
    }
}

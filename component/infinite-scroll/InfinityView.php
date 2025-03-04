<?php
class InfinityView {
    public static function render_infinity($post) {
        setup_postdata($post);

        get_template_part('template-parts/content', 'post');

        wp_reset_postdata(); // Сбрасываем данные поста
    }
}

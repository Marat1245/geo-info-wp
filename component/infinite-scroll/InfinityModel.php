<?php
class InfinityModel {
    public static function get_infinity($paged, $posts_per_page = 5): WP_Query
    {
        $post_id = intval($_POST['post_id']);

        $args = array(
            'post_type'      => 'news',
            'posts_per_page' => $posts_per_page, // Загружаем посты
            'post__not_in' => array($post_id), // Исключаем текущий пост
            'paged'          => $paged,
        );
        return new WP_Query($args);
    }
}
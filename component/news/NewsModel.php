<?php
class NewsModel {
    public static function get_news($paged): WP_Query
    {
        $args = array(
            'post_type'      => 'news',
            'posts_per_page' => 5,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'paged'          => $paged,
        );

        return new WP_Query($args);
    }
}
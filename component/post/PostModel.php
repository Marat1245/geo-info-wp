<?php
class PostModel
{
    public static function get_news($paged, $post_type, $count = 5)
    {
        $args = array(
            'post_type' => $post_type,
            'posts_per_page' => $count,
            'orderby' => 'date',
            'order' => 'DESC',
            'paged' => $paged,
        );

        return make_post($args);
    }
}
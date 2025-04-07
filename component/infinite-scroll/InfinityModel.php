<?php
class InfinityModel
{
    public static function get_infinity($exclude_post_id, $paged = 1, $post_type = 'post', $posts_per_page = 5)
    {
        $args = [
            'post_type' => sanitize_text_field($post_type),
            'posts_per_page' => intval($posts_per_page),
            'paged' => intval($paged),
            'post__not_in' => ($exclude_post_id > 0) ? [$exclude_post_id] : [],


        ];

        return make_post($args);
    }



}

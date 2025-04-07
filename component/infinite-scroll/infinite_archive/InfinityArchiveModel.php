<?php
class InfinityArchiveModel
{
    public static function get_posts($post_type, $post_number, $paged)
    {

        $args = [
            'post_type' => sanitize_text_field($post_type),
            'posts_per_page' => $post_number,
            'paged' => intval($paged),

        ];

        return make_post($args);


    }
}
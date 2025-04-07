<?php
class PreprintModel
{
    public static function get_preprint($limit = 5, $paged = 1)
    {
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $limit,
            'orderby' => 'date',
            'order' => 'DESC',
            'paged' => $paged,
        );

        $query = new WP_Query($args);


        $posts = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                $posts[] = [
                    'title' => get_the_title(),
                    'link' => get_permalink(),
                    'image' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
                    'category' => get_the_terms(get_the_ID(), 'category'),
                    'author' => get_the_author(),
                    'date' => time_ago_short(get_the_date('Y-m-d H:i:s')),
                    "id" => get_the_ID(),
                    'comments_number' => get_comments_number(get_the_ID()),
                    'views' => get_post_meta(get_the_ID(), 'views', true),
                    'preprint' => has_term('preprint', 'post_tag', get_the_ID()),
                ];
            }
            wp_reset_postdata();
        }

        return $posts;
    }
}
<?php
function make_post($args)
{
    $query = new WP_Query($args);


    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();


            $categories = get_the_terms(get_the_ID(), 'category');
            $categories = !empty($categories) && is_array($categories) ? $categories : [];

            $post[] = [
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'link' => get_permalink(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
                'description' => wp_trim_words(get_the_content(), 60, '...'),
                'category' => $categories,
                'author' => get_the_author(),
                'date' => time_ago_short(get_the_date('Y-m-d H:i:s')),
                'comments_number' => get_comments_number(get_the_ID()),
                'views' => get_post_meta(get_the_ID(), 'views', true),
                'preprint' => has_term('preprint', 'post_tag', get_the_ID()),
                'thumb' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
                "thumbnail_caption" => get_the_post_thumbnail_caption(),
                "content" => apply_filters('the_content', get_the_content()),
                'tags' => wp_get_post_tags(get_the_ID(), ['fields' => 'names']),
            ];
        }
        wp_reset_postdata();
    }
    return $post;
}

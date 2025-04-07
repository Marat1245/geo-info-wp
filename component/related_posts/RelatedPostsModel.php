<?php
class RelatedPostsModel
{
    public static function get_related_posts($post_id, $count = 2)
    {
        $categories = get_the_category($post_id);
        $tags = get_the_tags($post_id);

        if (empty($categories) && empty($tags)) {
            return [];
        }

        $args = [
             'post_type' => 'any',
            'posts_per_page' => $count,
            'post__not_in' => [$post_id],
            'orderby' => 'rand',
            'tax_query' => [
                'relation' => 'OR',
                [
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => $categories ? wp_list_pluck($categories, 'term_id') : []
                ],
                [
                    'taxonomy' => 'post_tag',
                    'field' => 'term_id',
                    'terms' => $tags ? wp_list_pluck($tags, 'term_id') : []
                ]
            ],
            'meta_query' => [
                [
                    'key' => '_thumbnail_id',
                    'compare' => 'EXISTS'
                ]
            ]
        ];

        $query = new WP_Query($args);
        $posts = [];

        // Если нет постов с изображениями, попробуем найти любые связанные посты
        if (!$query->have_posts()) {
            $args['meta_query'] = [];
            $query = new WP_Query($args);
        }

        // Если все еще нет постов, выдаем любые другие посты
        if (!$query->have_posts()) {
            $args = [
                'post_type' => 'any',
                'posts_per_page' => $count,
                'post__not_in' => [$post_id],
                'orderby' => 'rand'
            ];
            $query = new WP_Query($args);
        }

        if ($query->have_posts()) {
            foreach ($query->posts as $post) {
                $posts[] = [
                    'link' => get_permalink($post),
                    'title' => get_the_title($post),
                    'image' => get_the_post_thumbnail_url($post, 'large'),
                    'description' => wp_trim_words(get_the_excerpt($post), 15),
                    'id' => get_the_ID(),
                ];
            }
        }

        wp_reset_postdata();
        return $posts;
    }



}

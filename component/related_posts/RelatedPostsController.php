<?php
class RelatedPostsController
{
    public static function ajax_get_related_posts()
    {
        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : get_the_ID();
        $count = isset($_POST['count']) ? intval($_POST['count']) : 3;

        $posts = RelatedPostsModel::get_related_posts($post_id, $count);

        wp_send_json_success([
            'html' => RelatedPostsView::render($posts)
        ]);
    }

    public static function get_related_posts_html($post_id = null, $count = 2)
    {
        $posts = RelatedPostsModel::get_related_posts($post_id ?: get_the_ID(), $count);
        $postList = RelatedPostsView::render($posts);

        echo $postList;
    }
}

add_action('wp_ajax_get_related_posts', ["RelatedPostsController", 'ajax_get_related_posts']);
add_action('wp_ajax_nopriv_get_related_posts', ["RelatedPostsController", 'ajax_get_related_posts']);
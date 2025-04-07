<?php
class PostView
{
    public static function render($post, $type = 'news')
    {
        if ($type === 'news') {

            PostListView::renderNews($post);
        } elseif ($type === 'post') {
            PostListView::renderPreprints($post);
        } elseif ($type === 'post_users') {
            PostListView::renderPostUser($post);
        }
    }


}

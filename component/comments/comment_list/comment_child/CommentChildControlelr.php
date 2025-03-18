<?php
class CommentChildController {
    public static function handle_comment_child() {
        $parent_comment_id = isset($_POST['parent_comment_id']) ? intval($_POST['parent_comment_id']) : 0;
        $replies = CommentModel::get_comment_replies($parent_comment_id);
        foreach ($replies as $reply) {
            CommentChildView::render_comment_child($reply);
        }
    }
}
 add_action('wp_ajax_comment_child', array(__CLASS__, 'handle_comment_child'));
        add_action('wp_ajax_nopriv_comment_child', array(__CLASS__, 'handle_unauthorized'));
?>
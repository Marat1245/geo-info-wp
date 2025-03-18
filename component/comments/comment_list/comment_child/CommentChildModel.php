<?php
class CommentModel {
    public static function get_comment_replies($parent_comment_id) {
        return get_comments([
            'parent'    => $parent_comment_id,
            'status'    => 'approve',
            'order'     => 'ASC'
        ]);
    }
}
?>

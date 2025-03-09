<?php 
class CommentListModel {
    public static function get_comments($post_id) {
        $comments = get_comments(array(
            'post_id' => $post_id,
            'order' => 'DESC',
            'orderby' => 'comment_date'
        ));
    
        $user_id = get_current_user_id();
        $formatted_comments = array();
    
        foreach ($comments as $comment) {
            // $likes_count = CommentLikes::get_likes_count($comment->comment_ID);
            // $is_liked = $user_id ? CommentLikes::is_liked_by_user($comment->comment_ID, $user_id) : false;
    
              
            $formatted_comments[] = array(
                'id' => $comment->comment_ID,
                'author' => $comment->comment_author,
                'content' => $comment->comment_content,
                'date' => time_ago_short($comment->comment_date),
                // 'likes_count' => $likes_count,
                // 'is_liked' => $is_liked
            );
        }
    
        return $formatted_comments;
    }

}



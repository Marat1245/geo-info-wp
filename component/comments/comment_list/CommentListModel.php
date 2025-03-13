<?php 
class CommentListModel {
    /**
     * Количество комментариев для первоначального отображения
     */
    const INITIAL_COMMENTS_COUNT = 500;

    public static function get_comments($post_id) {
        // Получаем общее количество комментариев
        $total_comments = get_comments_number($post_id);

        $comments = get_comments(array(
            'post_id' => $post_id,
            'number' => self::INITIAL_COMMENTS_COUNT,
            'order' => 'DESC',
            'orderby' => 'comment_date',
            'status' => 'approve',
           
        ));
    

        $formatted_comments = array();
    
        foreach ($comments as $comment) {     
           
            $is_deleted = get_comment($comment->comment_ID)->comment_approved === 'trash';
            $comment_class = $is_deleted ? 'user_comment comment-deleted' : 'user_comment';

            $formatted_comments[] = array(
                'id' => $comment->comment_ID,
                'author' => $comment->comment_author,
                'content' => $comment->comment_content,
                'date' => time_ago_short($comment->comment_date),
                'user_id' => $comment->user_id,    
                'is_deleted' => $is_deleted ? 'display: none;' : '',
                'comment_class' => $comment_class
            );
        }

        return array(
            'comments' => $formatted_comments,
            'total' => $total_comments,
            'show_more' => $total_comments > self::INITIAL_COMMENTS_COUNT
        );
    }

    // public static function get_replies_comments($comment_id) {
    
        
    //     $replies = get_comments(array(
    //         'parent' => $comment_id,
    //         'status' => 'approve',
    //         'order' => 'DESC',
    //         'orderby' => 'comment_date',
        
    //     ));
        
   
        
    //     $formatted_replies = array();
        
    //     if (!empty($replies)) {
    //         foreach ($replies as $reply) {           
    //             $is_deleted = $reply->comment_approved === 'trash';
    //             $comment_class = $is_deleted ? 'comment-deleted' : '';
                  
    //             $formatted_replies[] = array(
    //                 'id' => $reply->comment_ID,
    //                 'author' => $reply->comment_author,
    //                 'content' => $reply->comment_content,
    //                 'date' => time_ago_short($reply->comment_date),
    //                 'user_id' => $reply->user_id,
    //                 'is_deleted' => $is_deleted ? 'display: none;' : '',
    //                 'comment_class' => $comment_class
    //             );
    //         }
    //     }
        
       
    //     return $formatted_replies;
    // }
    
    
    
}



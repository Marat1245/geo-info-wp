<?php

class CommentManager {
    public static function get_comments($post_id, $page = 1, $per_page = 5) {
        global $wpdb;
        
        $offset = ($page - 1) * $per_page;
        
        // Получаем общее количество комментариев
        $total_comments = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->comments} WHERE comment_post_ID = %d AND comment_approved = '1'",
            $post_id
        ));
        
        // Получаем комментарии для текущей страницы
        $comments = $wpdb->get_results($wpdb->prepare(
            "SELECT 
                comment_ID as id,
                comment_author as author,
                comment_content as content,
                comment_date as date,
                comment_parent as parent_id
            FROM {$wpdb->comments} 
            WHERE comment_post_ID = %d 
            AND comment_approved = '1'
            ORDER BY comment_date DESC
            LIMIT %d OFFSET %d",
            $post_id,
            $per_page,
            $offset
        ), ARRAY_A);
        
        // Получаем количество лайков для каждого комментария
        foreach ($comments as &$comment) {
            $comment['likes_count'] = CommentLikes::get_likes_count($comment['id']);
        }
        
        return array(
            'comments' => $comments,
            'total' => $total_comments,
            'has_more' => ($offset + $per_page) < $total_comments,
            'remaining' => max(0, $total_comments - ($offset + $per_page))
        );
    }
} 
<?php

class CommentLikes {
    private static $table_name = 'comment_likes';

    public static function init() {
        self::create_table();
        add_action('wp_ajax_toggle_comment_like', array(__CLASS__, 'handle_toggle_like'));
        add_action('wp_ajax_nopriv_toggle_comment_like', array(__CLASS__, 'handle_toggle_like'));
    }

    private static function create_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        
        $table_name = $wpdb->prefix . self::$table_name;
        error_log("Creating table: {$table_name}");
        
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            comment_id bigint(20) NOT NULL,
            user_id bigint(20) NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id),
            UNIQUE KEY unique_like (comment_id, user_id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $result = dbDelta($sql);
        
        error_log("Table creation result: " . print_r($result, true));
        
        // Проверяем, существует ли таблица
        $table_exists = $wpdb->get_var("SHOW TABLES LIKE '{$table_name}'");
        error_log("Table exists: " . ($table_exists ? 'yes' : 'no'));
    }

    public static function handle_toggle_like() {
        check_ajax_referer('comment_nonce', 'nonce');

        $comment_id = intval($_POST['comment_id']);
        $is_liked = isset($_POST['is_liked']) && $_POST['is_liked'] === '1';
        $user_id = get_current_user_id();

        error_log("Toggle like request - Comment ID: {$comment_id}, Is liked: " . ($is_liked ? 'true' : 'false') . ", User ID: {$user_id}");

        if (!$user_id) {
            error_log("User not authenticated");
            wp_send_json_error('Пользователь не авторизован');
            return;
        }

        if ($is_liked) {
            error_log("Adding like");
            self::add_like($comment_id, $user_id);
        } else {
            error_log("Removing like");
            self::remove_like($comment_id, $user_id);
        }

        $likes_count = self::get_likes_count($comment_id);
        error_log("Current likes count: {$likes_count}");
        
        wp_send_json_success(array(
            'likes_count' => $likes_count,
            'is_liked' => $is_liked
        ));
    }

    private static function add_like($comment_id, $user_id) {
        global $wpdb;
        error_log("Adding like to database - Comment ID: {$comment_id}, User ID: {$user_id}");
        
        $result = $wpdb->insert(
            $wpdb->prefix . self::$table_name,
            array(
                'comment_id' => $comment_id,
                'user_id' => $user_id
            ),
            array('%d', '%d')
        );
        
        if ($result === false) {
            error_log("Error adding like: " . $wpdb->last_error);
        } else {
            error_log("Like added successfully");
        }
    }

    private static function remove_like($comment_id, $user_id) {
        global $wpdb;
        error_log("Removing like from database - Comment ID: {$comment_id}, User ID: {$user_id}");
        
        $result = $wpdb->delete(
            $wpdb->prefix . self::$table_name,
            array(
                'comment_id' => $comment_id,
                'user_id' => $user_id
            ),
            array('%d', '%d')
        );
        
        if ($result === false) {
            error_log("Error removing like: " . $wpdb->last_error);
        } else {
            error_log("Like removed successfully");
        }
    }

    public static function get_likes_count($comment_id) {
        global $wpdb;
        $count = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}" . self::$table_name . " WHERE comment_id = %d",
            $comment_id
        ));
        error_log("Getting likes count for comment {$comment_id}: {$count}");
        return $count;
    }

    public static function is_liked_by_user($comment_id, $user_id) {
        global $wpdb;
        return $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}" . self::$table_name . " WHERE comment_id = %d AND user_id = %d",
            $comment_id,
            $user_id
        )) > 0;
    }

    public static function get_likes_status($comment_ids, $user_id) {
        global $wpdb;
        if (empty($comment_ids)) {
            return array();
        }

        $placeholders = implode(',', array_fill(0, count($comment_ids), '%d'));
        $query = $wpdb->prepare(
            "SELECT comment_id FROM {$wpdb->prefix}" . self::$table_name . 
            " WHERE comment_id IN ($placeholders) AND user_id = %d",
            array_merge($comment_ids, array($user_id))
        );

        $liked_comments = $wpdb->get_col($query);
        error_log("Getting likes status for comments: " . print_r($comment_ids, true) . ", User ID: {$user_id}, Liked comments: " . print_r($liked_comments, true));

        return $liked_comments;
    }
} 
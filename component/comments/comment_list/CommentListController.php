<?php
class CommentListController {
    public static function handle_load_more() {
        if (!isset($_POST['post_id']) || !isset($_POST['offset'])) {
            wp_send_json_error();
            return;
        }

        $post_id = intval($_POST['post_id']);
        $offset = intval($_POST['offset']);

        $comments_data = CommentListModel::get_comments($post_id, 5, $offset);        
        // Получаем ответы для всех комментариев
        
        
        ob_start();
        CommentListView::render_comments($comments_data['comments'], $parent_comment_id,  $post_id);
        $html = ob_get_clean();
       
        wp_send_json_success(array(
            'html' => $html,
           // 'has_more' => $comments_data['has_more']
           
        ));
        wp_die(); 
    }
}

add_action('wp_ajax_load_more', array('CommentListController', 'handle_load_more'));
add_action('wp_ajax_nopriv_load_more', array('CommentListController', 'handle_load_more')); 
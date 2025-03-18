<?php
class ShowUndercommentController{
    public static function render_undercomment(){
        try{
            check_ajax_referer('show_undercomment_nonce', 'nonce');
                       
            $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;           
            $comment_id = isset($_POST['comment_id']) ? intval($_POST['comment_id']) : 0;
            $offset = isset($_POST['loadedCommentsCount']) ? intval($_POST['loadedCommentsCount']) : 0;
                
            
            //$undercomments = ShowUndercommentModel::get_undercomments($post_id, $comment_id, $offset, $comments_per_load);
            $undercomments = ShowUndercommentModel::get_undercomments($post_id, $comment_id, $offset);
          
            error_log(print_r($undercomments, true));
            ob_start();
            ShowUndercommentView::render_undercomments($undercomments);
            $html = ob_get_clean();

            wp_send_json_success(array(
                'html' => $html,   
                'total_count' => $undercomments[0]['total_count'],
                'loadedCommentsCount' => $undercomments[0]['loadedCommentsCount']
            ));
            
        } catch(Exception $e){
            wp_send_json_error('Ошибка при получении дополнительных комментариев: ' . $e->getMessage());
        }
          wp_die();
    }
}
add_action('wp_ajax_show_undercomment', 'ShowUndercommentController::render_undercomment');
add_action('wp_ajax_nopriv_show_undercomment', 'ShowUndercommentController::render_undercomment');

<?php


class ShowMoreController {       
    const LOAD_MORE_COUNT = 50; // Количество комментариев для подгрузки

    // Обработчик AJAX для загрузки дополнительных комментариев
    public static function handle_load_more_comments() {
       
        try {
            check_ajax_referer('show_more_nonce', 'nonce');                      
            $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
            $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;            
            $parent_id = isset($_POST['parent_id']) ? json_decode(stripslashes($_POST['parent_id'])) : [];
            $count_comments = isset($_POST['count_comments']) ? intval($_POST['count_comments']) : 0;
            
            $comments = ShowMoreModel::get_comments($post_id, self::LOAD_MORE_COUNT, $offset, $parent_id, $count_comments);
                 
                            
            
            // Формируем HTML для новых комментариев
            ob_start();
            ShowMoreView::render_comments($comments['comments']);
            $html = ob_get_clean();

            wp_send_json_success(array(
                'html' => $html,
                'show_more' => $comments['show_more'], // Показывать ли кнопку "Показать ещё"
                'remaining_total' => $comments['remaining_comments'], // Количество оставшихся комментариев
                'next_load_count' => self::LOAD_MORE_COUNT, // Количество комментариев для подгрузки
                'total' => $comments['total'], // Количество комментариев
              
                
            ));
        } catch (Exception $e) {
           
            wp_send_json_error('Произошла ошибка при загрузке комментариев: ' . $e->getMessage());
        }
       
        wp_die(); 
    }
}

// Регистрируем обработчики AJAX
add_action('wp_ajax_load_more_comments', array('ShowMoreController', 'handle_load_more_comments'));
add_action('wp_ajax_nopriv_load_more_comments', array('ShowMoreController', 'handle_load_more_comments'));
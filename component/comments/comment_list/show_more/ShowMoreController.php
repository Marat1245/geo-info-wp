<?php


class ShowMoreController {       
    const LOAD_MORE_COUNT = 50; // Количество комментариев для подгрузки

    // Обработчик AJAX для загрузки дополнительных комментариев
    public static function handle_load_more_comments() {
        try {
          
            check_ajax_referer('show_more_nonce', 'nonce');

            $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
            $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
            
        
            
            if (!$post_id) {
                wp_send_json_error('Неверный ID поста');
                return;
            }

            // Получаем комментарии
            $comments = get_comments(array(
                'post_id' => $post_id,
                'number' => self::LOAD_MORE_COUNT,
                'offset' => $offset,
                'status' => 'approve',
                'order' => 'DESC',

            ));

            if (is_wp_error($comments)) {
               
                wp_send_json_error('Ошибка при получении комментариев: ' . $comments->get_error_message());
                return;
            }

            // Получаем общее количество комментариев
            $total_comments = get_comments_number($post_id);
            
            // Вычисляем оставшееся количество комментариев
            $remaining_comments = $total_comments - ($offset + self::LOAD_MORE_COUNT);
            $remaining_comments = max(0, $remaining_comments);
            
            // Вычисляем, сколько комментариев будет загружено в следующий раз
            $next_load_count = min(self::LOAD_MORE_COUNT, $remaining_comments);
            
            // Проверяем, есть ли еще комментарии для загрузки
            $show_more = $remaining_comments > 0;

            // Форматируем комментарии
            $formatted_comments = array();
            foreach ($comments as $comment) {
                $is_deleted = $comment->comment_approved === 'trash';
                $comment_class = $is_deleted ? 'comment-deleted' : '';
                
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

            // Получаем ответы для всех комментариев
            $replies = array();
            foreach ($formatted_comments as $comment) {
                $replies[$comment['id']] = ShowMoreModel::get_comments($comment['id']);
            }
            error_log( $replies, true);
            
            // Формируем HTML для новых комментариев
            ob_start();
            CommentListView::render_comments($formatted_comments, $replies);
            $html = ob_get_clean();

            wp_send_json_success(array(
                'html' => $html,
                'show_more' => $show_more,
                'remaining_total' => $remaining_comments,
                'next_load_count' => $next_load_count
            ));
        } catch (Exception $e) {
           
            wp_send_json_error('Произошла ошибка при загрузке комментариев: ' . $e->getMessage());
        }
    }
}

// Регистрируем обработчики AJAX
add_action('wp_ajax_load_more_comments', array('ShowMoreController', 'handle_load_more_comments'));
add_action('wp_ajax_nopriv_load_more_comments', array('ShowMoreController', 'handle_load_more_comments'));
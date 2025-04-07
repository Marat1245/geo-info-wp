<?php
// require_once __DIR__ . '/CommentResponseView.php';
// require_once __DIR__ . '/../comment_controller/CommentControllerView.php';
// require_once __DIR__ . '/../comment_selector/CommentSelectorView.php';
// require_once __DIR__ . '/../comment_restore/CommentRestoreView.php';

class CommentResponseController {  

    public static function handle_unauthorized() {
        wp_send_json_error(array(
            'message' => 'Необходимо авторизоваться для ответа на комментарий'
        ));
    }

    public static function handle_comment_response() {
        try {
            // Проверяем nonce
            if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'comment_response_nonce')) {
                throw new Exception('Ошибка безопасности');
            }

            // Проверяем авторизацию
            if (!is_user_logged_in()) {
                throw new Exception('Необходимо авторизоваться');
            }

            // Получаем и проверяем данные
            $parent_id = isset($_POST['parent_id']) ? intval($_POST['parent_id']) : 0;
            $content = isset($_POST['content']) ? trim($_POST['content']) : '';
            $comment_subparent = isset($_POST['comment_subparent']) ? intval($_POST['comment_subparent']) : 0;
            if (empty($content)) {
                throw new Exception('Текст комментария не может быть пустым');
            }

            // Проверяем существование родительского комментария
            $parent_comment = get_comment($parent_id);
            if (!$parent_comment) {
                throw new Exception('Родительский комментарий не найден');
            }

            // Получаем данные текущего пользователя
            $user = wp_get_current_user();
            if (!$user->ID) {
                throw new Exception('Ошибка получения данных пользователя');
            }

            // Подготавливаем данные для нового комментария
            $comment_data = array(
                'comment_post_ID' => $parent_comment->comment_post_ID,
                'comment_content' => $content,
                'user_id' => $user->ID,
                'comment_parent' => $parent_id,
                'comment_subparent' => $comment_subparent,
                'comment_author' => $user->display_name,
                'comment_author_email' => $user->user_email,
                'comment_approved' => 1,
                'comment_type' => 'comment',
                'comment_meta' => array(
                    'is_edited' => false
                )
            );

            // Добавляем комментарий
            $comment_id = wp_insert_comment($comment_data);
            if (!$comment_id) {
                throw new Exception('Ошибка при добавлении комментария');
            }

            // Получаем добавленный комментарий
            $comment = get_comment($comment_id);
            if (!$comment) {
                throw new Exception('Ошибка при получении добавленного комментария');
            }

            // Определяем класс комментария
            // $comment_class = 'user_comment';
            // if ($comment->comment_parent > 0) {
            //     $comment_class .= ' comment_response';
            // }

            // Генерируем HTML для нового комментария
            ob_start();
            ?>
            <div class="response user_comment " data-comment-id="<?php echo esc_attr($comment_id); ?>">
                <div class="user_comment_info">
                    <img class="comment_avatar"
                         src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/user_24.svg'); ?>" alt="">
                    <span class="comment_name"><?php echo esc_html($user->display_name); ?></span>
                    <span class="comment_time card_caption_text"><?php echo time_ago_short($comment->comment_date); ?></span>
                </div>

                <div class="comment_text" data-collapsed="false">
                    <span><?php echo nl2br(esc_html($content)); ?></span>
                    <span class="link_tag card_caption_text toggle_text">...еще</span>
                </div>

                <div class="comment_control">
                    <?php CommentControllerView::render_comment_controller($comment_id); ?>
                    <?php CommentSelectorView::render_comment_selector($comment_id, $user->ID); ?>
                </div>
                <?php CommentRestoreView::render_comment_restore(false); ?>                
                <?php //CommentResponseController::render_response_form($comment_id); ?>
            </div>
            <?php
            $html = ob_get_clean();

            // Отправляем успешный ответ
            wp_send_json_success(array(
                'html' => $html,
                'message' => 'Комментарий успешно добавлен'
            ));

        } catch (Exception $e) {
            wp_send_json_error(array(
                'message' => $e->getMessage()
            ));
        }
    }

    public static function render_response_form($comment_id) {
        return CommentResponseView::render_response_form($comment_id);
    }
}

// Инициализируем контроллер
add_action('wp_ajax_comment_response', array('CommentResponseController', 'handle_comment_response'));
add_action('wp_ajax_nopriv_comment_response', array('CommentResponseController', 'handle_unauthorized'));
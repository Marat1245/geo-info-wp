<?php 
require_once get_template_directory() . '/component/format_time.php';

class ShowMoreView
{
    public static function render_comments($comments)
    {
        $user_id = get_current_user_id();
        
        foreach ($comments as $comment) {
            // Определяем формат данных комментария
            $comment_id = is_object($comment) ? $comment->comment_ID : $comment['id'];
            $comment_author = is_object($comment) ? $comment->comment_author : $comment['author'];
            $comment_content = is_object($comment) ? $comment->comment_content : $comment['content'];
            $comment_date = is_object($comment) ? time_ago_short($comment->comment_date) : $comment['date'];
            $comment_user_id = is_object($comment) ? $comment->user_id : $comment['user_id'];
            
            // Проверяем статус комментария
            $is_deleted = is_object($comment) 
                ? $comment->comment_approved === 'trash'
                : get_comment($comment['id'])->comment_approved === 'trash';
                
            $comment_class = $is_deleted ? 'user_comment comment-deleted' : 'user_comment';
            ?>
            <div class="<?php echo esc_attr($comment_class); ?>" data-comment-id="<?php echo $comment_id; ?>">
                <div class="user_comment_info">
                    <img class="comment_avatar"
                         src="<?php echo esc_url(get_template_directory_uri() . './img/icons/user_24.svg') ?>" alt="">
                    <span class="comment_name"><?php echo esc_html($comment_author); ?></span>
                    <span class="comment_time card_caption_text"><?php echo $comment_date; ?></span>
                </div>

                <div class="comment_text" data-collapsed="false">
                    <span><?php echo nl2br(esc_html($comment_content)); ?></span>
                    <span class="link_tag card_caption_text toggle_text">...еще</span>
                </div>

                <div class="comment_control" style="<?php echo $is_deleted ? 'display: none;' : ''; ?>">
                   <?php CommentControllerView::render_comment_controller($comment_id); ?>
                   <?php CommentSelectorView::render_comment_selector($comment_id, $comment_user_id); ?>
                </div>
                <?php CommentRestoreView::render_comment_restore($is_deleted); ?>
               
            </div>
            <?php
        }
    }

    public static function render_more_button($comments_data) {
        if ($comments_data['show_more']) {
            $remaining_total = $comments_data['total'] - CommentListModel::INITIAL_COMMENTS_COUNT;
            $next_load_count = min(ShowMoreController::LOAD_MORE_COUNT, $remaining_total);
            ?>
            <button class="more_btn">
                <span>
                    <?php 
                    if ($next_load_count === $remaining_total) {
                        echo "Ещё {$next_load_count} комментариев";
                    } else {
                        echo "{$next_load_count} из {$remaining_total} комментариев";
                    }
                    ?>
                </span>
                <img src="<?php echo get_template_directory_uri(); ?>/img/icons/arrow_down_20.svg" alt="">
            </button>
            <?php
        }
    }
}


<?php 
class CommentListView
{
    public static function render_comments($comments)
    {
        if (empty($comments)) {
            return;
        }
        error_log('comments: ' . print_r($comments, true));
        foreach ($comments as $comment) {     
            $is_deleted = get_comment($comment['id'])->comment_approved === 'trash';
            $comment_class = $is_deleted ? 'comment-deleted' : '';
            ?>
            <div class="user_comment <?php echo esc_attr($comment_class); ?>" data-comment-id="<?php echo esc_attr($comment['id']); ?>">
                <div class="user_comment_info">
                    <img class="comment_avatar"
                            src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/user_24.svg'); ?>" alt="">
                    <span class="comment_name"><?php echo esc_html($comment['author']); ?></span>
                    <span class="comment_time card_caption_text"><?php echo $comment['date']; ?></span>
                </div>

                <div class="comment_text" data-collapsed="false">
                    <span><?php echo nl2br(esc_html($comment['content'])); ?></span>
                    <span class="link_tag card_caption_text toggle_text">...еще</span>
                </div>

                <div class="comment_control" style="<?php echo $is_deleted ? 'display: none;' : ''; ?>">
                    <?php CommentControllerView::render_comment_controller($comment['id']); ?>
                    <?php CommentSelectorView::render_comment_selector($comment['id'], $comment['user_id']); ?>
                </div>
                <?php CommentRestoreView::render_comment_restore($is_deleted); ?>                
                <?php CommentResponseController::render_response_form($comment['id']); ?>       
                <div class="comment_responses"></div>
            </div>
            <?php
        }
    }

   
}



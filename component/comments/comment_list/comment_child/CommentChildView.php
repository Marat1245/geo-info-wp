<?php
class CommentChildView {
    public static function render_comment_child($comment) {
        $comment_id = $comment->comment_ID;
        $user = get_userdata($comment->user_id);
        $content = $comment->comment_content;
        ?>
        <div class="response user_comment" data-comment-id="<?php echo esc_attr($comment_id); ?>">
            <div class="user_comment_info">
                <img class="comment_avatar"
                        src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/user_24.svg'); ?>" alt="">
                <span class="comment_name"><?php echo esc_html($user->display_name ?? 'Гость'); ?></span>
                <span class="comment_time card_caption_text"><?php echo esc_html(human_time_diff(strtotime($comment->comment_date), current_time('timestamp'))) . ' назад'; ?></span>
            </div>

            <div class="comment_text" data-collapsed="false">
                <span><?php echo nl2br(esc_html($content)); ?></span>
                <span class="link_tag card_caption_text toggle_text">...еще</span>
            </div>

            <div class="comment_control">
                <?php CommentControllerView::render_comment_controller($comment_id); ?>
                <?php CommentSelectorView::render_comment_selector($comment_id, $comment->user_id); ?>
            </div>
            <?php CommentRestoreView::render_comment_restore(false); ?>                
            <?php CommentResponseController::render_response_form($comment_id); ?>
        </div>
        <?php
    }
}
?>

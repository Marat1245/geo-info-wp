`<?php 
class CommentListView
{
    public static function render_comments($comments)
    {
        $user_id = get_current_user_id();
        $comment_ids = array_map(function($comment) {
            return $comment['id'];
        }, $comments);

        
        
       
        foreach ($comments as $comment) {
            //$is_liked = in_array($comment['id'], $liked_comments);
            ?>
            <div class="user_comment" data-id="<?php echo $comment['id']; ?>">
                <div class="user_comment_info">
                    <img class="comment_avatar"
                         src="<?php echo esc_url(get_template_directory_uri() . './img/icons/user_24.svg') ?>" alt="">
                    <span class="comment_name"><?php echo esc_html($comment['author']); ?></span>
                    <span class="comment_time card_caption_text"><?php echo $comment['date']; ?></span>
                </div>

                <div class="comment_text" data-collapsed="false">
                    <?php echo esc_html($comment['content']); ?>
                    <span class="link_tag card_caption_text toggle_text" style="display: none;">...еще</span>
                </div>

                <div class="comment_control">
                   <?php  ?>

                   <?php ?>
                </div>
                <?php ?>
            </div>
            <?php
        }
    }
}


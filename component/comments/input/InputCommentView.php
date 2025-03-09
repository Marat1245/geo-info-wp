<?php 
class InputCommentView
{

    public static function render_comment_form($post_id)
    {
        $current_user = wp_get_current_user();

        ?>

        <form method="post" class="comment_input_wrap">
            <div contenteditable="true" data-placeholder="Написать комментарий"
                 class="t_contenteditable input_accent input_normal_size input_icon_right comment_input"></div>
                <div class="comment_right_block">
  
                <button type="submit" class="flat small_icon">
                    <img src="<?php echo esc_url(get_template_directory_uri() . './img/icons/leter_36.svg') ?>" alt="">
                </button>
            </div>
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>"/>
            <input type="hidden" name="author" value="<?php echo $current_user->user_login; ?>"/>
        </form>


        <?php
    }
}
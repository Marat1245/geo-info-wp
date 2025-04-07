<?php
class InputCommentView
{

    public static function render_comment_form($post_id, $size = "normal_size", $type = '')
    {
        $current_user = wp_get_current_user();

        ?>

        <form method="post" class="comment_input_wrap <?= $type ? $type . '_wrap' : ""; ?>">

            <div contenteditable="true" data-placeholder="Написать комментарий" class="t_contenteditable 
                comment_input
                <?php echo $size ? $size : "normal_size"; ?>
                <?php echo $type ? $type : ""; ?>
                input_icon_right  placeholder" data-max-length="2500"></div>
            <div class="comment_char_counter" style="display: none;">
                <span class="current_chars">0</span>/2500
            </div>

            <div class="comment_right_block">
                <button type="submit" class="flat small_icon">
                    <img src="<?php echo esc_url(get_template_directory_uri() . './img/icons/leter_36.svg') ?>" alt="Отправить"
                        data-default-icon="<?php echo esc_url(get_template_directory_uri() . '/img/icons/leter_36.svg'); ?>"
                        data-active-icon="<?php echo esc_url(get_template_directory_uri() . '/img/icons/leter_act_36.svg'); ?>">
                </button>
            </div>
            <input type="hidden" name="post_id" value="<?php echo esc_attr($post_id); ?>" />
            <input type="hidden" name="author" value="<?php echo esc_attr($current_user->user_login); ?>" />
            <?php wp_nonce_field('comment_nonce', 'comment_nonce'); ?>
        </form>


        <?php
    }
}
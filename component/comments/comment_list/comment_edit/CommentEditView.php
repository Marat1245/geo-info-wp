<?php 
class CommentEditView
{
    public static function render_edit_form($comment_id, $current_content)
    {
        ?>
        <div class="comment_edit_form" style="display: none;">
            <div class="comment_input_wrap">
                <div contenteditable="true" 
                     data-placeholder="Написать комментарий"
                     class="t_contenteditable input_accent input_normal_size input_icon_right comment_input"
                     data-max-length="2500"><?php echo esc_textarea($current_content); ?></div>
                <div class="comment_char_counter" style="display: none;">
                    <span class="current_chars">0</span>/2500
                </div>
                <div class="comment_right_block">
                    <button type="submit" class="flat small_icon save_edit" data-comment-id="<?php echo esc_attr($comment_id); ?>">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/leter_36.svg') ?>" 
                             alt="Сохранить"
                             data-default-icon="<?php echo esc_url(get_template_directory_uri() . '/img/icons/leter_36.svg'); ?>" 
                             data-active-icon="<?php echo esc_url(get_template_directory_uri() . '/img/icons/leter_act_36.svg'); ?>">
                    </button>
                </div>
            </div>
            <div class="comment_edit_actions">
                <button class="small_text flat text_icon_btn cancel_edit">
                    <span class="card_caption_text">Отмена</span>
                </button>
            </div>
        </div>
        <?php
    }
}

    
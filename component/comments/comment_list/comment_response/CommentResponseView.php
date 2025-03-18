<?php
class CommentResponseView {
    public static function render_response_form($parent_comment_id) {
        ?>
        <div class="comment_response_form  " style="display: none;" data-parent-id="<?php echo esc_attr($parent_comment_id); ?>">
            <div class="comment_input_wrap">
                <div contenteditable="true" 
                     data-placeholder="Написать ответ"
                     class="t_contenteditable input_accent input_normal_size input_icon_right comment_input"
                     data-max-length="2500"></div>
                <div class="comment_char_counter" style="display: none;">
                    <span class="current_chars">0</span>/2500
                </div>
                <div class="comment_right_block">
                    <button type="button" class="flat small_icon cancel_response">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/close_20.svg') ?>" alt="Отменить">
                    </button>
                    <button type="submit" class="flat small_icon save_response" data-parent-id="<?php echo esc_attr($parent_comment_id); ?>">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/leter_36.svg') ?>" 
                             alt="Отправить"
                             data-default-icon="<?php echo esc_url(get_template_directory_uri() . '/img/icons/leter_36.svg'); ?>" 
                             data-active-icon="<?php echo esc_url(get_template_directory_uri() . '/img/icons/leter_act_36.svg'); ?>">
                    </button>
                </div>
                
            </div>
           
        </div>
        <?php
    }
} 
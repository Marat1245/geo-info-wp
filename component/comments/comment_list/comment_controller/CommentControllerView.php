<?php 
class CommentControllerView
{
    public static function render_comment_controller($post_id)
    {
        ?>
        <div>
            <button class="small_text flat text_icon_btn answer_comment">
                <span class="card_caption_text">Ответить</span>
            </button>
            <button class="small_text flat text_icon_btn like-button <?php echo esc_attr($disabled_class); ?> <?php echo esc_attr($my_likes); ?>" data-post-id="<?php echo esc_attr($post_id); ?>">
            <img class="like-icon" 
                src="<?php echo esc_url($my_likes === 'liked' ? get_template_directory_uri() . '/img/icons/heart_act_20.svg' : get_template_directory_uri() . '/img/icons/heart_20.svg'); ?>" 
                alt="<?php echo $my_likes === 'liked' ? 'Пользователь поставил лайк' : 'Лайк'; ?>" 
                data-default-icon="<?php echo esc_url(get_template_directory_uri() . '/img/icons/heart_20.svg'); ?>" 
                data-active-icon="<?php echo esc_url(get_template_directory_uri() . '/img/icons/heart_act_20.svg'); ?>">
            <span class="card_caption_text like-count" style="display: <?php echo $likes > 0 ? 'flex' : 'none'; ?>"><?php echo esc_html($likes); ?></span>
        </button>
        </div>
        <?php
    }
}


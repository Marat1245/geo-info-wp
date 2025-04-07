<?php


class CommentControllerView
{
    public static function render_comment_controller($comment_id)
    {
        // Получаем количество лайков для комментария
        $likes = get_comment_meta($comment_id, 'comment_likes', true) ?: 0;

        // Проверяем, поставил ли текущий пользователь лайк
        $user_id = get_current_user_id();
        $liked_users = get_comment_meta($comment_id, 'liked_users', true) ?: array();
        $my_likes = in_array($user_id, $liked_users) ? 'liked' : '';

        // Класс для неавторизованных пользователей
        $disabled_class = !is_user_logged_in() ? 'disabled' : '';

        // Проверяем, был ли комментарий отредактирован
        $is_edited = CommentEditModel::is_comment_edited($comment_id);
        $edited_class = $is_edited ? 'active' : '';
        ?>
        <button class="micro flat text_icon_btn answer_comment <?php echo esc_attr($disabled_class); ?>">

            <span class="card_caption_text ">Ответить</span>

        </button>
        <button
            class="micro flat text_icon_btn like-comment-button <?php echo esc_attr($disabled_class); ?> <?php echo esc_attr($my_likes); ?>"
            data-comment-id="<?php echo esc_attr($comment_id); ?>">
            <img class="like-icon"
                src="<?php echo esc_url($my_likes === 'liked' ? get_template_directory_uri() . '/img/icons/button_heart_act_20.svg' : get_template_directory_uri() . '/img/icons/button_heart_20.svg'); ?>"
                alt="<?php echo $my_likes === 'liked' ? 'Пользователь поставил лайк' : 'Лайк'; ?>"
                data-default-icon="<?php echo esc_url(get_template_directory_uri() . '/img/icons/button_heart_20.svg'); ?>"
                data-active-icon="<?php echo esc_url(get_template_directory_uri() . '/img/icons/button_heart_act_20.svg'); ?>">
            <span class="card_caption_text like-count" style="display: <?php echo $likes > 0 ? 'flex' : 'none'; ?>">
                <?php echo esc_html($likes); ?>
            </span>
        </button>
        <div class="comment_changed card_caption_text <?php echo esc_attr($edited_class); ?>">Изменено</div>


        <?php
    }
}



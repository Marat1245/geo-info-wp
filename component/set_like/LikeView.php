<?php
class LikeButton {
    public static function render($post_id) {
        $likes = LikeModel::get_likes($post_id); // например, получите количество лайков
        $my_likes = LikeModel::my_likes($post_id);
        $is_logged_in = is_user_logged_in(); // Проверяем, авторизован ли пользователь
        $disabled_class = $is_logged_in ? ' ' : 'disabled';
        ?>
        <button class="small_text flat text_icon_btn like-button <?php echo esc_attr($disabled_class); ?> <?php echo esc_attr($my_likes); ?>">
            <img class="like-icon" 
                src="<?php echo esc_url($my_likes === 'liked' ? get_template_directory_uri() . '/img/icons/heart_act_20.svg' : get_template_directory_uri() . '/img/icons/heart_20.svg'); ?>" 
                alt="<?php echo $my_likes === 'liked' ? 'Пользователь поставил лайк' : 'Лайк'; ?>" 
                data-default-icon="<?php echo esc_url(get_template_directory_uri() . '/img/icons/heart_20.svg'); ?>" 
                data-active-icon="<?php echo esc_url(get_template_directory_uri() . '/img/icons/heart_act_20.svg'); ?>">
            <span class="card_caption_text like-count" style="display: <?php echo $likes > 0 ? 'flex' : 'none'; ?>"><?php echo esc_html($likes); ?></span>
        </button>
        <?php
    }
}
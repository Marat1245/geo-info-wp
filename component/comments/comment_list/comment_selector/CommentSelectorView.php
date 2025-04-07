<?php 
class CommentSelectorView
{
    public static function render_comment_selector($post_id, $comment_author_id)
    {
        if(!is_user_logged_in()){
            return;
        }
        $current_user_id = get_current_user_id();
        ?>
          <div class="selector_wrap">
            <button class="flat micro"><img
                        src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/point_menu_20.svg') ?>"
                        alt=""></button>
            <!-- Selector -->
            <div class="selector" style="display: none;">
                <?php if ($current_user_id == $comment_author_id): ?>
                    <ul>
                        <li data-li="" class="edit-comment">
                            <img
                                    src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/Edit_20.svg') ?>"
                                    alt="">Редактировать комментарий
                        </li>
                        <li data-li="" class="delete-comment">
                            <img
                                    src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/delete_20.svg') ?>"
                                    alt="">Удалить комментарий
                        </li>
                    </ul>
                <?php else: ?>
                    <ul>
                        <li data-li=""><img
                                    src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/Warning_outline_20.svg') ?>"
                                    alt="">Пожаловаться
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
            <!-- End Selector -->
        </div>
        <?php
    }
}


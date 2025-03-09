<?php 
class CommentSelectorView
{
    public static function render_comment_selector($post_id)
    {
        ?>
          <div class="selector_wrap">
            <button class="flat small_icon"><img
                        src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/point_menu_20.svg') ?>"
                        alt=""></button>
            <!-- Selector -->
            <div class="selector" style="display: none;">
                
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
                
                    <ul>
                        <li data-li=""><img
                                    src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/Warning_outline_20.svg') ?>"
                                    alt="">Пожаловаться
                        </li>
                    </ul>
                
            </div>
            <!-- End Selector -->
        </div>
        <?php
    }
}


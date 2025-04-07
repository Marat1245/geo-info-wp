<?php
class ControlePostView
{
    public static function render($post)
    {
        ?>
        <div class="controle_bottom card_controle_bottom">
            <div class="sub_controller">
                <?php LikeButton::render($post['id'], true); ?>
                <?php CountMessageView::render($post['comments_number']); ?>
            </div>
            <?php CountViewsView::render($post['views']); ?>
        </div>
        <?php
    }
}
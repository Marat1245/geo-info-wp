<?php 
class CommentRestoreView
{
    public static function render_comment_restore()
    {
        ?>
         <div class="delete_comment_wrap hidden">
            <div>Комментарий удалён.</div>
            <button class="small_text flat text_icon_btn restore_comment"><span class="card_caption_text">Восстановить</span>

        </div>
        <?php
    }
}


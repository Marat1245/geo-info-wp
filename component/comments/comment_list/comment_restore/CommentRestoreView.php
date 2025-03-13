<?php 
class CommentRestoreView
{
    public static function render_comment_restore($is_deleted = false)
    {
        ?>
         <div class="delete_comment_wrap comment-restore" style="<?php echo $is_deleted ? 'display: flex;' : 'display: none;';?>">
            <div>Комментарий удалён</div>
            <button class="small_text flat text_icon_btn restore_comment"><span class="card_caption_text">Восстановить</span>
        </div>
        <?php
    }
}


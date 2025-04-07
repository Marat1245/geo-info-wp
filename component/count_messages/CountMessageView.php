<?php
class CountMessageView
{
    public static function render($comments_number)
    {
        ?>
        <div class="view">
            <img src="<?php echo get_template_directory_uri(); ?>/img/icons/message_20.svg" alt="">
            <?php if ($comments_number > 0): ?>
                <span class="card_caption_text"><?= $comments_number; ?></span>
            <?php endif; ?>

        </div>
        <?php
    }
}
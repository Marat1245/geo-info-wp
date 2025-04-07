<?php
class CountViewsView
{
    public static function render($views)
    {
        ?>
        <div class="view">
            <img src="<?php echo get_template_directory_uri(); ?>/img/icons/eye-filled.svg" alt="">
            <?php if ($views > 0): ?>
                <span class="view_count card_caption_text"><?= $views; ?></span>
            <?php endif; ?>
        </div>
        <?php
    }
}
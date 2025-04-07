<?php
class FixController
{
    public static function render($id, $total)
    {
        ?>
        <div class="fix_controller">
            <div class="sub_controller">
                <?php
                LikeButton::render($id); ?>

                <a href="#comment_block_<?= esc_attr($id); ?>">
                    <button class="small_text flat text_icon_btn">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/icons/message_20.svg" alt="">

                        <span class="card_caption_text comments-count"><?= esc_html($total); ?></span>

                    </button>
                </a>
                <?php ShareBtn::render(); ?>
            </div>
        </div>
        <?php
    }
}

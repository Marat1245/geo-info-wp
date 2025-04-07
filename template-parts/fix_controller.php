<div class="fix_controller">
    <div class="sub_controller">
        <?php
        LikeButton::render(get_the_ID()); ?>

        <a href="#comment_block_<?php echo get_the_ID(); ?>">
            <button class="small_text flat text_icon_btn">
                <img src="<?php echo get_template_directory_uri(); ?>/img/icons/message_20.svg" alt="">

                <span class="card_caption_text comments-count"><?php echo $comments_data['total']; ?></span>

            </button>
        </a>
        <?php ShareBtn::render(); ?>
    </div>
</div>
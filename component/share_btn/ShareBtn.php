<?php

class ShareBtn {
    public static function render() {
        ?>
        <button class="small_text flat text_icon_btn artical_share">
            <img src="<?php echo get_template_directory_uri(); ?>/img/icons/share_20.svg" alt="">
            <span class="card_caption_text"></span>
        </button>
        <?php
    }
}




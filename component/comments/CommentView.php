<?php

// view/comment-view.php
class CommentView
{

    public static function render_comment_form($post_id)
    {
        $current_user = wp_get_current_user();

        ?>

        <form method="post" class="comment_input_wrap">
            <div contenteditable="true" data-placeholder="Написать комментарий"
                 class="t_contenteditable input_accent input_normal_size input_icon_right comment_input"></div>
            <!--                <textarea maxlenght="2500" placeholder="Написать комментарий" class="input_accent input_normal_size input_icon_right textarea_comment" style="height: 32px;"></textarea>-->
            <div class="comment_right_block">
                <!--                    <span class="card_caption_text char_count">1</span>-->
                <!--                    <span class="card_caption_text">/ 2500</span>-->
                <button type="submit" class="flat small_icon">
                    <img src="<?php echo esc_url(get_template_directory_uri() . './img/icons/leter_36.svg') ?>" alt="">
                </button>
            </div>
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>"/>
            <input type="hidden" name="author" value="<?php echo $current_user->user_login; ?>"/>
        </form>


        <?php
    }

    public static function render_comments($comments)
    {
        foreach ($comments as $comment) {
            ?>
            <div class="user_comment">

                <div class="user_comment_info">
                    <img class="comment_avatar"
                         src="<?php echo esc_url(get_template_directory_uri() . './img/icons/user_24.svg') ?>" alt="">
                    <span class="comment_name"><?php echo $comment->comment_author; ?></span>
                    <span class="comment_time card_caption_text"> <?php echo time_ago_short($comment->comment_date); ?></span>
                </div>

                <div class="comment_text" data-collapsed="false"><?php echo $comment->comment_content; ?> <span
                            class="link_tag card_caption_text toggle_text" style="display: none;">...еще</span></div>

                <div class="comment_control">
                    <div>
                        <button class="small_text flat text_icon_btn answer_comment"><span class="card_caption_text">Ответить</span>
                        </button>
                        <button class="small_text flat text_icon_btn">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.9 7.2005V7.20035C2.89985 6.32296 3.26233 5.47685 3.91486 4.85401C4.56831 4.2303 5.45763 3.8839 6.3838 3.90058L6.39422 3.90076L6.40465 3.90071C7.52948 3.8949 8.5966 4.35896 9.33725 5.1651L10 5.88646L10.6628 5.1651C11.4034 4.35896 12.4705 3.8949 13.5954 3.90071L13.6058 3.90076L13.6162 3.90058C14.5424 3.8839 15.4317 4.2303 16.0851 4.85401C16.7377 5.47685 17.1002 6.32296 17.1 7.20035V7.2005C17.1 8.9076 16.0495 10.5124 14.4538 12.0888C13.6691 12.864 12.7892 13.5971 11.9092 14.3024C11.662 14.5005 11.4126 14.6981 11.1652 14.8941C10.7667 15.2099 10.3734 15.5215 10.0026 15.8247C9.61017 15.5013 9.19253 15.1693 8.76984 14.8333C8.54496 14.6546 8.31865 14.4747 8.09394 14.2943C7.21351 13.5877 6.33324 12.8554 5.54786 12.0813C3.95099 10.5075 2.9 8.90824 2.9 7.2005Z"
                                      stroke="#BBBBBB" stroke-width="1.8"/>
                            </svg>
                            <span class="card_caption_text">111</span>
                        </button>
                    </div>

                    <div class="selector_wrap">
                        <button class="flat small_icon"><img
                                    src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/point_menu_20.svg') ?>"
                                    alt=""></button>
                        <!-- Selector -->
                        <div class="selector" style="display: none;">
                            <ul>
                                <li data-li=""><img
                                            src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/Warning_outline_20.svg') ?>"
                                            alt="">Пожаловаться
                                </li>
                            </ul>
                        </div>
                        <!-- End Selector -->
                    </div>
                </div>
            </div>
            <?php
        }
    }
}

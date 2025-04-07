<?php
class CommentPost
{
    public function render($comment)
    {
        ?>
          <div class="comment_post">
            <?php include "./component/comments.php" ?>
            <div class="comment_input_wrap comment_input_wrap_post">

                <textarea maxlength="2500" placeholder="Написать комментарий" class="textarea_comment input_icon_right"
                    required></textarea>
                <div class="comment_right_block">
                    <span class="card_caption_text char_count">0</span>
                    <span class="card_caption_text">/ 2500</span>
                    <button type="submit" class="flat small_icon">
                        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M28 18L8 30L9.76471 24.0001L10.6471 21.0001L11.0882 19.5002L23.2941 18.0002L11.0882 16.5002L10.6471 15.0001L9.76471 12.0001L8 6L28 18Z"
                                fill="#BFCADA" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <?php
    }
}
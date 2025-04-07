<?php
class PreprintView
{
    public static function render($post)
    {
        ;
        ?>
        <div class="preprints paper">
            <div class="preprints_artical">
                <div class="preprints_artical_content">
                    <div class="preprints_artical_top">
                        <div class="preprints_title">
                            <a href="<?php echo esc_url($post['link']); ?>"
                                class="link_grey_color"><?php echo esc_attr($post['title']); ?></a>
                        </div>
                        <div class="preprints__tags">
                            <?php
                            if (!empty($post['category']) && !is_wp_error($post['category'])) {
                                foreach ($post['category'] as $category) {
                                    ?>
                                    <a class="card_caption_text link_tag" href=""><?php echo esc_html($category->name) ?></a>
                                    <?php
                                }
                                ?> <span class="card_caption_text">·</span> <?php
                            }
                            ?>
                            <span class="card_caption_text"><?= $post['date']; ?></span>
                        </div>
                    </div>
                    <div class="controle_bottom card_controle_bottom">
                        <div class="sub_controller">
                            <?php LikeButton::render($post['id'], true); ?>
                            <?php CountMessageView::render($post['comments_number']); ?>
                        </div>
                        <?php CountViewsView::render($post['views']); ?>
                    </div>
                </div>
                <a class="preprints_artical_img_link" href="<?php echo esc_url($post['link']); ?>">

                    <?php if ($post['preprint']): ?>
                        <div class="preprint_bage">Препринт</div>
                    <?php endif; ?>
                    <img class="preprints_artical_img" src="<?php echo esc_url($post['image']); ?>"
                        alt="<?php echo esc_attr($post['title']); ?>">
                </a>
            </div>
        </div>

    <?php }
}
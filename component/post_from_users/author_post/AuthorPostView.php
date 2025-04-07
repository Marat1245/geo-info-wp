<?php
class AuthorPostView
{
    public static function render($post)
    {
        ?>
        <div class="post_top">
            <div class="post_left">
                <a href="" class="link_company post_avatar_wrap">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/icons/user_24.svg" alt="" class="post_avatar">
                </a>
                <div class="post_info">
                    <a href="" class="post_aut link_grey_color">
                        <?php echo $post['author']; ?>
                    </a>
                    <div class="tag_wrap">
                        <?php
                        if (!empty($post['category']) && !is_wp_error($post['category'])) {
                            foreach ($post['category'] as $category) {
                                ?>
                                <a href="<?= esc_url(get_term_link($category)); ?>"
                                    class="post_tag link_tag">#<?php echo esc_html($category->name) ?></a>
                                <?php
                            }

                        }

                        if (!empty($post['tags']) && !is_wp_error($post['tags'])):
                            foreach ($post['tags'] as $tag_name):
                                $tag = get_term_by('name', $tag_name, 'post_tag');
                                if ($tag && !is_wp_error($tag)): ?>
                                    <a class="card_caption_text link_tag" href="<?= esc_url(get_term_link($tag)); ?>">
                                        #<?= esc_html($tag_name); ?>
                                    </a>
                                <?php endif;
                            endforeach;
                        endif;
                        if ($post['tags'] || $post['category']) { ?>
                            <span class="card_caption_text">·</span>
                        <?php } ?>


                        <span class="card_caption_text"><?php echo $post["date"] ?></span>
                    </div>
                </div>
            </div>
            <div class="selector_wrap">
                <button class="flat small_icon"><img
                        src="<?php echo get_template_directory_uri(); ?>/img/icons/Point_menu_36.svg" alt=""></button>
                <!-- Selector -->

                <!-- End Selector -->
            </div>
        </div>
        <?php
    }
}
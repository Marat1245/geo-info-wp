<?php
class PostListView
{
    public static function renderPost($post, $post_type)
    {
        if ($post_type == 'post_users') {
            self::renderPostUser($post); // Сохранение вывода для всех постов
        } else if ($post_type == 'news') {
            self::renderNews($post); // Сохранение вывода для всех постов
        } else if ($post_type == 'post') {
            self::renderPreprints($post);
        }
    }
    public static function renderNews($post)
    {
        ?>
        <div class="news_artical post_item">
            <div class="news_first">
                <div class="news_dot">
                    <img src="<?= esc_url(get_template_directory_uri() . '/img/icons/circle.svg'); ?>" alt="">
                </div>
                <a href="<?= esc_url($post['link']); ?>" class="news_title link_grey_color">
                    <?= esc_html($post['title']); ?>
                </a>
            </div>
            <div class="news_second">
                <?php if ($post['category']):
                    foreach ($post['category'] as $category): ?>
                        <span>
                            <a href="<?= esc_url(get_term_link($category)); ?>" class="link_tag">
                                #<?= esc_html($category->name); ?>
                            </a>
                        </span>
                    <?php endforeach;

                endif;

                if (!empty($post['tags']) && !is_wp_error($post['tags'])):
                    foreach ($post['tags'] as $tag_name):
                        $tag = get_term_by('name', $tag_name, 'post_tag');
                        if ($tag && !is_wp_error($tag)): ?>
                            <a class="link_tag" href="<?= esc_url(get_term_link($tag)); ?>">
                                #<?= esc_html($tag_name); ?>
                            </a>
                        <?php endif;
                    endforeach;
                endif;
                if ($post['tags'] || $post['category']) { ?>
                    <span class="card_caption_text">·</span>
                <?php } ?>
                <span class="card_caption_text"><?= esc_html($post['date']); ?></span>
            </div>
        </div>
        <?php
    }

    // Функция для рендера препринта
    public static function renderPreprints($post)
    {
        ?>
        <div class="preprints paper post_item" data-post-id="<?= $post['id']; ?>">
            <div class="preprints_artical">
                <div class="preprints_artical_content">
                    <div class="preprints_artical_top">
                        <div class="preprints_title">
                            <a href="<?= esc_url($post['link']); ?>"
                                class="link_grey_color"><?= esc_html($post['title']); ?></a>
                        </div>
                        <div class="preprints__tags">
                            <?php if (!empty($post['category']) && !is_wp_error($post['category'])): ?>
                                <?php foreach ($post['category'] as $category): ?>
                                    <a class="card_caption_text link_tag" href="<?= esc_url(get_term_link($category)); ?>">
                                        #<?= esc_html($category->name); ?>
                                    </a>
                                <?php endforeach; ?>

                            <?php endif;
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
                            <span class="card_caption_text"><?= esc_html($post['date']); ?></span>
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
                <a class="preprints_artical_img_link" href="<?= esc_url($post['link']); ?>">
                    <?php if ($post['preprint'] || $post['image']): ?>
                        <?php if ($post['preprint']): ?>
                            <div class="preprint_bage">Препринт</div>
                        <?php endif; ?>
                        <?php if ($post['image']): ?>
                            <img class="preprints_artical_img" src="<?= esc_url($post['image']); ?>"
                                alt="<?= esc_attr($post['title']); ?>">
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="preprint_plug"></div>
                    <?php endif; ?>

                </a>
            </div>
        </div>
        <?php
    }

    public static function renderPostUser($post)
    {
        ?>
        <div class="post post_item  <?php echo $post['image'] ? '' : 'post_desc'; ?>" data-post-id="<?= $post['id']; ?>">
            <?php AuthorPostView::render($post); ?>

            <div>
                <a href="<?php echo esc_url($post['link']); ?>" class="link_grey_color post_title">
                    <?php echo esc_html($post['title']); ?>
                </a>
            </div>

            <?php if (!empty($post['image'])): ?>
                <a href="<?php echo esc_url($post['link']); ?>">
                    <img src="<?php echo esc_url($post['image']); ?>" alt="<?php echo esc_attr($post['title']); ?>"
                        class="post_img">
                </a>
            <?php else: ?>
                <a href="<?php echo esc_url($post['link']); ?>" class="post_desc_text">
                    <?php echo esc_html($post['description']); ?>
                </a>
            <?php endif;

            ControlePostView::render($post);

            ?>

            <div class="devide devide_post">
                <div class="stroke"></div>
            </div>


            <div class="post_comments_list comment_list comment_block <?= (int) $post['comments_number'] > 0 ? "have_comments" : "" ?>"
                data-post-id="<?= $post['id']; ?>">
                <?php
                $comments_data = CommentListModel::get_comments($post['id']); // Получаем комментарии
        
                CommentListView::render_comments($comments_data['comments']); // Рендер комментариев
                ?>
                <?php echo ShowMoreView::render_show_more_btn($comments_data['last_comments_count']); ?>
            </div>

            <?php InputCommentView::render_comment_form($post['id'], 'normal_size', 'post_input'); ?>
        </div>
        <?php
    }
}
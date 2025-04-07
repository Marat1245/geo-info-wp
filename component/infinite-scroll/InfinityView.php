<?php
class InfinityView
{

    public static function render($post)
    {

        $has_preprint = get_post_meta($post['id'], '_custom_preprint', true);
        $file_id = get_post_meta($post['id'], '_custom_file_id', true);
        $file_url = $file_id ? wp_get_attachment_url($file_id) : '';
        ?>

        <div class="content_block artical_wrap post_item" data-post-id="<?= esc_attr($post['id']); ?>"
            data-post-link="<?= esc_url($post['link']); ?>">

            <?php
            self::get_post_category($post);
            ?>
            <h1><?= esc_html($post['title']) ?></h1>
            <?php
            self::get_post_thumb($post, $has_preprint, $file_url);
            self::get_post_content($post, $has_preprint, $file_url);

            ?>


            <div class="sub_controller artical_controller">

                <?php
                LikeButton::render($post['id']);
                ShareBtn::render(); ?>

            </div>
            <div class="comment_block" id="comment_block_<?= esc_attr($post['id']); ?>"
                data-post-id="<?= esc_attr($post['id']); ?>">
                <span class="comment_title">Комментарии</span>
                <?php
                InputCommentView::render_comment_form($post['id']); // Рендер формы комментария
        
                $comments_data = CommentListModel::get_comments($post['id']); // Получаем комментарии
                ?>
                <div class="comment_list">
                    <?php
                    CommentListView::render_comments($comments_data['comments']); // Рендер комментариев
            

                    ?>
                </div>

            </div>


            <!-- SHOW MORE BUTTON -->
            <?php //require get_template_directory() . '/template-parts/button_show_more.php'; ?>
            <?php echo ShowMoreView::render_show_more_btn($comments_data['last_comments_count']); ?>
            <!-- SHOW MORE BUTTON END -->


            <div class="donate_block">
                <span>Журнал остается бесплатным и продолжает развиваться.Нам очень нужна поддержка читателей.</span>
            </div>



            <?php RelatedPostsController::get_related_posts_html($post['id'], 3); ?>


            <!-- FIX CONTROLLER -->

            <?php
            FixController::render($post['id'], $comments_data['total']);
            //get_template_part('template-parts/fix_controller', null, ['id' => $post['id']]); ?>
            <!-- FIX CONTROLLER -->

        </div>
        <?php
    }



    private static function get_post_data($post)
    {
        $day = get_the_date('d'); // День (01-31)
        $month = get_the_date('F'); // Полное название месяца (Январь, Февраль...)
        $year = get_the_date('Y'); // Год (2024)
        ?>
        <div class="article_page_data">
            <span><?= $day; ?></span>
            <span><?= $month; ?></span>
            <span><?= $year; ?></span>
        </div>
        <?php
    }



    private static function get_post_category($post)
    {
        ?>
        <div class="article_page_tag">
            <?php if (!empty($post['category']) && !is_wp_error($post['category'])): ?>
                <?php foreach ($post['category'] as $category): ?>

                    <a class=" link_tag" href="<?= esc_url(get_term_link($category)); ?>">#<?= esc_html($category->name); ?></a>
                <?php endforeach;
            endif; ?>
            <?php if (!empty($post['tags']) && !is_wp_error($post['tags'])): ?>

                <?php foreach ($post['tags'] as $tag_name): ?>
                    <?php $tag = get_term_by('name', $tag_name, 'post_tag'); ?>
                    <?php if ($tag && !is_wp_error($tag)): ?>
                        <a class="link_tag" href="<?= esc_url(get_term_link($tag)); ?>">
                            #<?= esc_html($tag_name); ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>

            <?php endif; ?>
        </div>

        <?php
    }


    private static function get_post_thumb($post, $has_preprint, $file_url)
    {
        ?>
        <div class="article_page_img_wrap">
            <?php if ($has_preprint): ?>
                <div class="preprint_bage">Препринт</div>
            <?php endif; ?>
            <?php if ($post['thumb']) {  // Если миниатюра существует, выводим её ?>
                <img src="<?= esc_url($post['thumb']); ?>" alt="<?= esc_attr($post['title']); ?>" class="article_page_img">
            <?php } ?>
            <?php if ($post['thumbnail_caption']): ?>
                <p class="wp-caption-text"><?= esc_html($post['thumbnail_caption']); ?></p>
            <?php endif; ?>
            <?php
            if ($file_url && $has_preprint) {
                ?>
                <!-- <iframe src="< //esc_url($file_url) ?>" class="preprint_iframe"></iframe> -->
            <?php } ?>
        </div>
        <?php
    }




    private static function get_post_content($post, $has_preprint, $file_url)
    {

        ?>
        <div class="article_page_content">
            <div class="article_page_text">

                <?php

                if ($file_url && $has_preprint) {
                    ?>
                    <a href="<?= esc_url($file_url) ?>" target="_blank" class="download_preprint">
                        <span>Скачать препринт</span>
                        <img class="article_page_download" src="<?= get_template_directory_uri(); ?>/img/icons/download.svg"
                            alt="Скачать препринт">
                    </a>

                <?php } else {
                    $annotation = get_post_meta(get_the_ID(), '_annotation', true);
                    if (!empty($annotation)) {
                        echo '<div class="post-annotation">';
                        echo apply_filters('the_content', $annotation);
                        echo '</div>';
                    }
                    echo $post['content'];
                }
                ?>

            </div>

            <?php self::get_post_data($post); ?>

        </div>
        <?php
    }
}
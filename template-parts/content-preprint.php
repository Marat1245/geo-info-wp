<?php
$post_link = $args['post_link'] ?? ''; // Получаем параметры, переданные через get_template_part()
$post_id = get_the_ID();
$categories = get_the_terms(get_the_ID(), 'category');
$thumb = get_the_post_thumbnail_url(get_the_ID(), 'full');
$day = get_the_date('d'); // День (01-31)
$month = get_the_date('F'); // Полное название месяца (Январь, Февраль...)
$year = get_the_date('Y'); // Год (2024)
$has_preprint = has_term('preprint', 'post_tag', get_the_ID());
$file_id = get_post_meta($post->ID, '_custom_file_id', true);
$file_url = $file_id ? wp_get_attachment_url($file_id) : '';
?>

<div class="content_block artical_wrap post_item" data-post-id="<?php the_ID(); ?>"
    data-post-link="<?php echo esc_url($post_link); ?>">
    <div class="article_page_tag">
        <?php
        if (!empty($categories) && !is_wp_error($categories)) {
            foreach ($categories as $category) {
                echo '<a class="link_tag" href="' . esc_url(get_term_link($category)) . '"> #' . esc_html($category->name) . '</a>';
            }
        }
        ?>
    </div>
    <h1><?php the_title(); ?></h1>
    <div class="article_page_img_wrap">
        <?php if ($has_preprint): ?>
            <div class="preprint_bage">Препринт</div>
        <?php endif; ?>
        <?php if ($thumb) {  // Если миниатюра существует, выводим её ?>
            <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
                class="article_page_img">
        <?php } ?>

        <?php
        if ($file_url && $has_preprint) {
            ?>
            <iframe src="<?= esc_url($file_url) ?>" class="preprint_iframe"></iframe>
        <?php } ?>
    </div>


    <div class="article_page_content">
        <div class="article_page_text">

            <?php

            if ($file_url && $has_preprint) {
                ?>
                <!-- <iframe src="<?= esc_url($file_url) ?>" class="preprint_iframe"></iframe> -->
                <a href="<?= esc_url($file_url) ?>" target="_blank" class="download_preprint">
                    <span>Скачать препринт</span>
                    <img src="<?= get_template_directory_uri(); ?>/img/icons/download.svg" alt="Скачать препринт">
                </a>

            <?php } else {
                the_content();
            }
            ?>


        </div>

        <div class="article_page_data">
            <span><?php echo $day; ?></span>
            <span><?php echo $month; ?></span>
            <span><?php echo $year; ?></span>
        </div>

    </div>

    <div class="donate_block">
        <span>Журнал остается бесплатным и продолжает развиваться.Нам очень нужна поддержка читателей.</span>
    </div>

    <div class="sub_controller artical_controller">

        <?php
        LikeButton::render(get_the_ID());
        ShareBtn::render(); ?>




    </div>
    <div class="comment_block" id="comment_block_<?php echo get_the_ID(); ?>"
        data-post-id="<?php echo get_the_ID(); ?>">
        <span class="comment_title">Комментарии</span>
        <?php
        InputCommentView::render_comment_form(get_the_ID()); // Рендер формы комментария
        
        $comments_data = CommentListModel::get_comments(get_the_ID()); // Получаем комментарии
        ?>
        <div class="comment_list">
            <?php
            CommentListView::render_comments($comments_data['comments']); // Рендер комментариев
            

            ?>
        </div>
        <!---->
        <!--            </div>-->
        <!--            <div class="add_article">-->
        <!--                <div class="add_article_caption">Читайте также</div>-->
        <!--                <div>-->
        <!--                    <div class="add_article_scroll mySwiper">-->
        <!--                        <div class="add_article_wrap  swiper-wrapper">-->
        <!--                          --><?php ////include "./component/add_artical.php" ?>
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!---->
        <!---->
        <!--            </div>-->

        <!-- SHOW MORE BUTTON -->
        <?php //require get_template_directory() . '/template-parts/button_show_more.php'; ?>
        <?php echo ShowMoreView::render_show_more_btn($comments_data['last_comments_count']); ?>
        <!-- SHOW MORE BUTTON END -->


    </div>
    <!-- FIX CONTROLLER -->
    <?php
    FixController::render(get_the_ID(), $comments_data['total']);
    //require get_template_directory() . '/template-parts/fix_controller.php'; ?>
    <!-- FIX CONTROLLER -->
</div>
<?php
// Получаем параметры, переданные через get_template_part()
$post_link = $args['post_link'] ?? '';


?>
<div class="content_block artical_wrap post-item" data-post-id="<?php the_ID(); ?>" data-post-link="<?php echo esc_url($post_link); ?>">

    <div class="artical-page_tag">
        <?php
        $post_id = get_the_ID();
    
        $categories = get_the_terms(get_the_ID(), 'category');
        if (!empty($categories) && !is_wp_error($categories)) {
            foreach ($categories as $category) {
                echo '<a class="link_tag" href="' . esc_url(get_term_link($category)) . '"> #' . esc_html($category->name) . '</a>';
            }
        }
        ?>
    </div>
    <h1><?php the_title(); ?></h1>
    <?php
    $thumb = get_the_post_thumbnail_url(get_the_ID(), 'full');

    if ($thumb) {
        // Если миниатюра существует, выводим её
        ?>
        <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
             class="artical-page_img">
        <?php
    }
    ?>

    <div class="artical-page_content">
        <div class="artical-page_text">
            <div class="autor">
                <div class="autor_data">
                    <a href="" class="autor_name link_tag">Королев Владимир Александрович</a>
                    <span class="autor_profesia card_caption_text">Профессор кафедры инженерной и экологической
                                геологии геологического факультета МГУ имени М.В. Ломоносова, д. г.-м. н.
                            </span>
                    <a href="" class="autor_mail card_caption_text link_tag"> va-korolev@bk.ru</a>

                </div>
                <a href=""><img src="<?php echo get_template_directory_uri(); ?>/img/icons/user_24.svg" alt=""
                                class="autor_img"></a>
            </div>
            <div class="autor">
                <!--   Еще автор -->
            </div>
            <?php the_content(); ?>

        </div>
        <div class="artical-page_data">
            <?php
            $day = get_the_date('d'); // День (01-31)
            $month = get_the_date('F'); // Полное название месяца (Январь, Февраль...)
            $year = get_the_date('Y'); // Год (2024)
            ?>

            <span><?php echo $day; ?></span>
            <span><?php echo $month; ?></span>
            <span><?php echo $year; ?></span>


        </div>

    </div>
    <div class="donat_block">
        <span>Журнал остается бесплатным и продолжает развиваться.Нам очень нужна поддержка читателей.</span>
    </div>
    <div class="sub_controller artical_controller">

        <?php
        LikeButton::render(get_the_ID());
        ?>
        <div class="selector_wrap">
            <button class="small_text flat text_icon_btn artical_share">
                <img src="<?php echo get_template_directory_uri(); ?>/img/icons/share_20.svg" alt="">

                <span class="card_caption_text"></span>

            </button>
         
        </div>
    </div>
    <div class="comment_block" id="comment_block_<?php echo get_the_ID(); ?>" data-post-id="<?php echo get_the_ID(); ?>">
        <span class="comment_title">Комментарии</span>
        <?php
        InputCommentView::render_comment_form(get_the_ID());
        $comments_data = CommentListModel::get_comments(get_the_ID());
        CommentListView::render_comments($comments_data['comments']);
       

        ?>
  
    <!---->
    <!--            </div>-->
    <!--            <div class="add_articals">-->
    <!--                <div class="add_articals_caption">Читайте также</div>-->
    <!--                <div>-->
    <!--                    <div class="add_articals_scroll mySwiper">-->
    <!--                        <div class="add_articals_wrap  swiper-wrapper">-->
    <!--                          --><?php ////include "./component/add_artical.php" ?>
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!---->
    <!---->
    <!--            </div>-->
                
  
    <?php 
    if ($comments_data['show_more']): ?>
        <?php             
       
        $remaining_total = $comments_data['total'] - CommentListModel::INITIAL_COMMENTS_COUNT;
        $next_load_count = min(ShowMoreController::LOAD_MORE_COUNT, $remaining_total);
        ?>
        <div class="more_btn comment_more_btn">
            <span>
                <?php 
                if ($next_load_count === $remaining_total) {
                    echo "Ещё {$next_load_count} комментариев";
                } else {
                    echo "{$next_load_count} из {$remaining_total} комментариев";
                }

                
                ?>
            </span>
            <img src="<?php echo get_template_directory_uri(); ?>/img/icons/arrow_down_20.svg" alt="">
        </div>
    <?php endif; ?>

        <!-- FIX CONTROLLER -->
        <div class="fix_controller">
            <div class="sub_controller">
                <?php
                LikeButton::render(get_the_ID());
                ?>

                <a href="#comment_block_<?php echo get_the_ID(); ?>">
                    <button class="small_text flat text_icon_btn">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/icons/message_20.svg" alt="">
                      
                            <span class="card_caption_text comments-count"></span>
                     
                    </button>
                </a>

                <div class="selector_wrap">
                    <button class="small_text flat text_icon_btn artical_share">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/icons/share_20.svg" alt="">

                        <span class="card_caption_text"></span>

                    </button>
                    
                </div>
            </div>
        </div>
    </div>
</div>

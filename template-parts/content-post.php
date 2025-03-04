<div class="content_block artical_wrap post-item" data-post-id="<?php the_ID(); ?>">

    <div class="artical-page_tag">
        <?php
        $post_id = get_the_ID();
        //        $args = [
        //            'post_id' => get_the_ID(),
        //            'likes' => LikeModel::get_likes(get_the_ID())
        //        ];
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
            <!--                   --><?php ////get_template_part('component/selector.php'); ?>
            <!--                    --><?php
            //                    require_once "component/selector.php";
            //                    renderSelector(true); ?>
        </div>
    </div>
    <div class="comment_block">
        <span class="comment_title">Комментарии</span>
        <?php

        // Загружаем комментарии для текущего поста
        //                   if (comments_open() || get_comments_number()) {
        //                        echo $post_id;
        //                       comments_template();
        //
        //                   }
        // Обработчик формы
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['comment_content'])) {
                CommentController::handle_comment_submission();
            } elseif (isset($_POST['comment_id']) && isset($_POST['new_content'])) {
                CommentController::handle_comment_update();
            } elseif (isset($_POST['comment_id'])) {
                CommentController::handle_comment_delete();
            }
        }

        // Получаем комментарии
        $comments = CommentModel::get_comments($post_id);

        // Отображаем форму и комментарии
        CommentView::render_comment_form($post_id);
        CommentView::render_comments($comments);

        ?>
    </div>
    <!--            <div class="comment_block" id="comment_block">-->
    <!--                <span class="comment_title">Комментарии</span>-->
    <!---->
    <!--                <div class="comment_input_wrap">-->
    <!--                    <textarea maxlenght="2500" placeholder="Написать комментарий"-->
    <!--                              class="input_accent input_normal_size input_icon_right textarea_comment"></textarea>-->
    <!--                    <div class="comment_right_block">-->
    <!--                        <span class="card_caption_text char_count">0</span>-->
    <!--                        <span class="card_caption_text">/ 2500</span>-->
    <!--                        <button type="submit" class="flat small_icon">-->
    <!--                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none"-->
    <!--                                 xmlns="http://www.w3.org/2000/svg">-->
    <!--                                <path-->
    <!--                                        d="M28 18L8 30L9.76471 24.0001L10.6471 21.0001L11.0882 19.5002L23.2941 18.0002L11.0882 16.5002L10.6471 15.0001L9.76471 12.0001L8 6L28 18Z"-->
    <!--                                        fill="#BFCADA" />-->
    <!--                            </svg>-->
    <!--                        </button>-->
    <!--                    </div>-->
    <!---->
    <!--                </div>-->
    <!---->
    <!--               -->
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


    <!-- FIX CONTROLLER -->
    <div class="fix_controller">
        <div class="sub_controller">
            <?php
            LikeButton::render(get_the_ID());
            ?>

            <a href="#comment_block">
                <button class="small_text flat text_icon_btn">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/icons/message_20.svg" alt="">

                    <span class="card_caption_text"></span>

                </button>
            </a>

            <div class="selector_wrap">
                <button class="small_text flat text_icon_btn artical_share">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/icons/share_20.svg" alt="">

                    <span class="card_caption_text"></span>

                </button>
                <!--            --><?php
                //            require_once "component/selector.php";
                //            renderSelector(true); ?>
            </div>
        </div>
    </div>
</div>
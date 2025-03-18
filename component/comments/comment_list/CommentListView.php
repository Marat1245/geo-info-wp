<?php
class CommentListView
{
    public static function render_comments($comments, $parent_id = 0, $post_id = 0)
    {
        // Проходим по всем комментариям и рендерим их
        foreach ($comments as $comment) {
          
            // Отображаем только комментарии с parent_id = 0 для начальной рендеринга
            if ($comment['parent'] == 0) {
                $is_deleted = get_comment($comment['id'])->comment_approved === 'trash';
                $comment_class = $is_deleted ? 'comment-deleted' : '';
                
                // Считаем количество подкомментариев для текущего родительского комментария
                $under_comments = CommentListModel::get_parrent_comments($post_id);
                $filtered_comments = array_filter($under_comments, function($under_comment) use ($comment) {
                    return $under_comment['parent'] == $comment['id'];
                });

                // Рекурсивная функция для подсчета всех подкомментариев
                $total_under_comments_count = self::count_all_undercomments($filtered_comments, $under_comments);

                // Количество комментариев
                $total_comments_count = count($filtered_comments) + $total_under_comments_count; // +1 для текущего комментария

                ?>
                <!-- Родительский комментарий -->
                <div class="user_comment parent_comment" 
                    data-comment-id="<?php echo esc_attr($comment['id']); ?>">
                    
                    <div class="user_comment_info">
                        <img class="comment_avatar"
                            src="<?php echo esc_url(get_template_directory_uri() . '/img/icons/user_24.svg'); ?>" alt="">
                        <span class="comment_name"><?php echo esc_html($comment['author']); ?></span>
                        <span class="comment_time card_caption_text"><?php echo esc_html($comment['date']); ?></span>
                    </div>

                    <div class="comment_text" data-collapsed="false">
                        <span><?php echo nl2br(esc_html($comment['content'])); ?></span>
                        <span class="link_tag card_caption_text toggle_text" style="display: none;">...еще</span>
                    </div>

                    <div class="comment_control" style="<?php echo $is_deleted ? 'display: none;' : ''; ?>">
                        <?php CommentControllerView::render_comment_controller($comment['id']); ?>
                        <?php CommentSelectorView::render_comment_selector($comment['id'], $comment['user_id']); ?>
                    </div>

                    <?php CommentRestoreView::render_comment_restore($is_deleted); ?>                
                    <?php CommentResponseController::render_response_form($comment['id']); ?>

                </div>
               
                <?php 
                // Если есть подкомментарии, выводим их
                if ($total_comments_count > 0) {
                    ?>
                    <div class="comment_responses">
                        <div class="more_btn under_comment_more_btn">
                            <span>Показать  <?php 
                            
                            $word = 'ответ';

                            if ($total_comments_count % 10 == 1 && $total_comments_count % 100 != 11) {
                                $word = 'ответ';
                            } elseif (in_array($total_comments_count % 10, [2, 3, 4]) && !in_array($total_comments_count % 100, [12, 13, 14])) {
                                $word = 'ответа';
                            } else {
                                $word = 'ответов';
                            }
                            
                            echo $total_comments_count . ' ' . $word; ?> 
                            </span>
                            <img src="<?php echo get_template_directory_uri(); ?>/img/icons/arrow_down_20.svg" alt="">
                        </div>
                    </div>
                    <?php
                    // Рекурсивно выводим подкомментарии
                    self::render_comments($filtered_comments, $comment['id'], $post_id);
                }
            }
        }
    }

    // Рекурсивная функция для подсчета всех подкомментариев
    private static function count_all_undercomments($comments, $all_comments)
    {
        $count = 0;

        foreach ($comments as $comment) {
            // Фильтруем все подкомментарии для текущего комментария
            $filtered_comments = array_filter($all_comments, function($under_comment) use ($comment) {
                return $under_comment['parent'] == $comment['id'];
            });

            $count += count($filtered_comments);

            // Если есть подкомментарии, рекурсивно считаем их
            if (!empty($filtered_comments)) {
                $count += self::count_all_undercomments($filtered_comments, $all_comments);
            }
        }

        return $count;
    }
}

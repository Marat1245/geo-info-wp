<?php
if ($comments_data['show_more']):
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
        <!-- <img src="<?php echo get_template_directory_uri(); ?>/img/icons/arrow_down_20.svg" alt=""> -->
    </div>
<?php endif; ?>
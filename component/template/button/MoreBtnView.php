<?php
/**
 * @var array $args
 * @var string $args['id'] - id элемента
 * @var string $args['data_type'] - тип данных
 */
class MoreBtnView
{
    public static function render($id, $data_type)
    {
        ?>
        <div class="more_btn" id="<?php echo isset($id) ? $id : ''; ?>"
            data-post-type="<?php echo isset($data_type) ? $data_type : ''; ?>">
            <span>Ещё 5 новостей</span>
            <!-- <img src="<?php //echo get_template_directory_uri(); ?>/img/icons/arrow_down_20.svg" alt=""> -->
        </div>
        <?php

    }


}

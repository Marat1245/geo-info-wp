<?php
class PreprintController
{
    public static function run()
    {
        $preprintPost = PreprintModel::get_preprint();


        if (!empty($preprintPost)) {
            foreach ($preprintPost as $post) {
                PreprintView::render($post);
            }
        } else {
            echo '<p>Постов не найдено.</p>';
        }

    }
}
add_action('wp_ajax_preprint_post', ['PreprintController', 'run']);
add_action('wp_ajax_nopriv_preprint_post', ['PreprintController', 'run']);
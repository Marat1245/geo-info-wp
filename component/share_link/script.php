<?php

function enqueue_share_link_script() {
    wp_enqueue_script('share-link', get_template_directory_uri() . '/component/share_link/share_link.js', array(), null, true);

    // Добавляем `type="module"` ко всем зарегистрированным скриптам
    add_filter('script_loader_tag', function ($tag, $handle) {
        if ($handle === 'share-link') {
            return str_replace('src=', 'type="module" src=', $tag);
        }
        return $tag;
    }, 10, 2);
}
add_action('wp_enqueue_scripts', 'enqueue_share_link_script');

?>
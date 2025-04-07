<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
/**
 * GeoInfo functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package GeoInfo
 */

if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function geoinfo_setup()
{
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on GeoInfo, use a find and replace
     * to change 'geoinfo' to the name of your theme in all the template files.
     */
    load_theme_textdomain('geoinfo', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
        array(
            'menu-1' => esc_html__('Primary', 'geoinfo'),
        )
    );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Set up the WordPress core custom background feature.
    add_theme_support(
        'custom-background',
        apply_filters(
            'geoinfo_custom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
        'custom-logo',
        array(
            'height' => 250,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        )
    );
}
add_action('after_setup_theme', 'geoinfo_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function geoinfo_content_width()
{
    $GLOBALS['content_width'] = apply_filters('geoinfo_content_width', 640);
}
add_action('after_setup_theme', 'geoinfo_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function geoinfo_widgets_init()
{
    register_sidebar(
        array(
            'name' => esc_html__('Sidebar', 'geoinfo'),
            'id' => 'sidebar-1',
            'description' => esc_html__('Add widgets here.', 'geoinfo'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        )
    );
}
add_action('widgets_init', 'geoinfo_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function geoinfo_scripts()
{
    wp_enqueue_style('geoinfo-style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_style_add_data('geoinfo-style', 'rtl', 'replace');

    wp_enqueue_script('geoinfo-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'geoinfo_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

function geoinfo_enqueue_styles()
{
    // Подключение Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Lato&display=swap', array(), null, 'print');

    // Подключение Swiper CSS
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0');

    // Подключение Cropper.js CSS
    wp_enqueue_style('cropper-css', 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css', array(), '1.6.2');
}
add_action('wp_enqueue_scripts', 'geoinfo_enqueue_styles');






function geoinfo_enqueue_local_styles()
{
    $styles = [
        'data-css' => '/style/data.css',
        'main-css' => '/style/main.css',
        'button-css' => '/style/button.css',
        'input-css' => '/style/input.css',
        'editor-css' => '/style/editor.css',
        'mobile-css' => '/style/mobile.css',
    ];

    foreach ($styles as $handle => $path) {
        $full_path = get_template_directory() . $path;
        $version = file_exists($full_path) ? filemtime($full_path) : '1.0.1';

        wp_enqueue_style(
            $handle,
            get_template_directory_uri() . $path,
            array(),
            $version
        );
    }
}
add_action('wp_enqueue_scripts', 'geoinfo_enqueue_local_styles');

function custom_admin_styles()
{
    $admin_css_path = get_template_directory() . '/style/admin-style.css';
    $version = file_exists($admin_css_path) ? filemtime($admin_css_path) : '1.0.1';

    wp_enqueue_style(
        'custom-admin-css',
        get_template_directory_uri() . '/style/admin-style.css',
        array(),
        $version
    );
}
add_action('admin_enqueue_scripts', 'custom_admin_styles');






function geoinfo_custom_body_class($classes)
{
    // Добавляем ваш класс
    $classes[] = 'body';
    return $classes;
}
add_filter('body_class', 'geoinfo_custom_body_class');







function geoinfo_enqueue_scripts()
{
    // Подключение jQuery через Google CDN
    wp_enqueue_script('jquery-cdn', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), '3.6.0', true);

    // Подключение Swiper JS
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true);

    // Подключение Cropper.js
    wp_enqueue_script('cropper-js', 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js', array(), '1.6.2', true);

    // Подключение IMask
    wp_enqueue_script('imask-js', 'https://unpkg.com/imask', array(), null, true);
}
add_action('wp_enqueue_scripts', 'geoinfo_enqueue_scripts');




function geoinfo_enqueue_local_scripts()
{
    $scripts = [
        'notification-js' => '/script/notification.js',
        'selectors-js' => '/script/selectors.js',
        'mobile-menu-js' => '/script/mobile_menu.js',
        'comments-js' => '/script/comments.js',
        'swiper-custom-js' => '/script/swiper.js',
        'profile-run-js' => '/script/profile/run.js',
        'button-run-js' => '/script/button/run.js',
        'selector-all-js' => '/script/selector_all.js',
        'pop-up-js' => '/script/pop_up/pop_up.js',
        'input-js' => '/script/input/input.js',
        'img-loader-js' => '/script/img_load_inpit/img_loader.js',
        'skills-js' => '/script/skills/skills.js',
        'tags-js' => '/script/tags/main_tags.js',
        'search-js' => '/script/search/main_search.js',
        'create-post-js' => '/script/create_post/main_create_post.js',
        'friends-js' => '/script/friends/main_friends.js',
        'messenger-js' => '/script/messanger/main_messenger.js',
        'editor-2-js' => '/script/editor_2/main.js',
        'main-js' => '/script/main.js',
        'set_active_fixed_controller' => '/script/set_active_fixed_controller.js',


    ];

    foreach ($scripts as $handle => $path) {
        $full_path = get_template_directory() . $path;
        $version = file_exists($full_path) ? filemtime($full_path) : '1.0.1';

        wp_enqueue_script(
            $handle,
            get_template_directory_uri() . $path,
            array(),
            $version, // Версия = время последнего изменения файла
            true
        );
    }
    wp_localize_script('load-news-js', 'geoInfo', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
    ));
    // Добавляем `type="module"` ко всем зарегистрированным скриптам
    add_filter('script_loader_tag', function ($tag, $handle) use ($scripts) {
        if (array_key_exists($handle, $scripts)) {
            return str_replace('src=', 'type="module" src=', $tag);
        }
        return $tag;
    }, 10, 2);
}
add_action('wp_enqueue_scripts', 'geoinfo_enqueue_local_scripts');





// Переименовываем "Записи" в "Новости"
function change_post_menu_label()
{
    global $menu, $submenu;

    $menu[5][0] = 'Препринты'; // Основное меню
    $submenu['edit.php'][5][0] = 'Все препринты'; // Подменю
    $submenu['edit.php'][10][0] = 'Добавить препринт'; // Добавить новую
}

// Переименовываем в интерфейсе
function change_post_object_label()
{
    global $wp_post_types;

    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Препринты';
    $labels->singular_name = 'Препринт';
    $labels->add_new = 'Добавить препринт';
    $labels->add_new_item = 'Добавить препринт';
    $labels->edit_item = 'Редактировать препринт';
    $labels->new_item = 'Препринт';
    $labels->view_item = 'Просмотреть препринт';
    $labels->search_items = 'Поиск препринтов';
    $labels->not_found = 'Препринт не найдено';
    $labels->not_found_in_trash = 'В корзине препринты не найдено';
    $labels->all_items = 'Все препринты';
    $labels->menu_name = 'Препринты';
    $labels->name_admin_bar = 'Препринт';
}

add_action('admin_menu', 'change_post_menu_label');
add_action('init', 'change_post_object_label');




//
// Добавляем поддержку архивов для типа записи 'post'
//
function enable_post_type_archive($args, $post_type)
{
    if ('post' === $post_type) {
        $args['has_archive'] = 'preprints'; // URL будет /preprints/
        $args['rewrite'] = array(
            'slug' => 'preprint', // URL одиночных записей: /preprint/slug/
            'with_front' => false
        );
    }
    return $args;
}
add_filter('register_post_type_args', 'enable_post_type_archive', 10, 2);







// Переименовываем "Метки" в "Теги" и "Рубрики" в "Категории"
function rename_taxonomies()
{
    global $wp_taxonomies;

    // Меняем название "Рубрики" на "Категории"
    if (!empty($wp_taxonomies['category']->labels)) {
        $wp_taxonomies['category']->labels->name = 'Категории';
        $wp_taxonomies['category']->labels->singular_name = 'Категория';
        $wp_taxonomies['category']->labels->menu_name = 'Категории';
        $wp_taxonomies['category']->labels->all_items = 'Все категории';
        $wp_taxonomies['category']->labels->edit_item = 'Редактировать категорию';
        $wp_taxonomies['category']->labels->view_item = 'Просмотреть категорию';
        $wp_taxonomies['category']->labels->update_item = 'Обновить категорию';
        $wp_taxonomies['category']->labels->add_new_item = 'Добавить новую категорию';
        $wp_taxonomies['category']->labels->new_item_name = 'Название новой категории';
        $wp_taxonomies['category']->labels->search_items = 'Искать категории';
    }

    // Меняем название "Метки" на "Теги"
    if (!empty($wp_taxonomies['post_tag']->labels)) {
        $wp_taxonomies['post_tag']->labels->name = 'Теги';
        $wp_taxonomies['post_tag']->labels->singular_name = 'Тег';
        $wp_taxonomies['post_tag']->labels->menu_name = 'Теги';
        $wp_taxonomies['post_tag']->labels->all_items = 'Все теги';
        $wp_taxonomies['post_tag']->labels->edit_item = 'Редактировать тег';
        $wp_taxonomies['post_tag']->labels->view_item = 'Просмотреть тег';
        $wp_taxonomies['post_tag']->labels->update_item = 'Обновить тег';
        $wp_taxonomies['post_tag']->labels->add_new_item = 'Добавить новый тег';
        $wp_taxonomies['post_tag']->labels->new_item_name = 'Название нового тега';
        $wp_taxonomies['post_tag']->labels->search_items = 'Искать теги';
    }
}
add_action('init', 'rename_taxonomies', 999);




// Делаем метки иерархическими (как рубрики)
function make_tags_hierarchical()
{
    register_taxonomy('post_tag', 'post', [
        'hierarchical' => true,  // Включаем иерархию
        'labels' => [
            'name' => 'Теги',   // Переименовываем "Метки" в "Теги"
            'singular_name' => 'Тег',
            'menu_name' => 'Теги',
            'all_items' => 'Все теги',
            'edit_item' => 'Редактировать тег',
            'view_item' => 'Просмотреть тег',
            'update_item' => 'Обновить тег',
            'add_new_item' => 'Добавить новый тег',
            'new_item_name' => 'Название нового тега',
            'search_items' => 'Искать теги',
        ],
        'rewrite' => ['slug' => 'tag'],
        'show_admin_column' => true,
        'show_in_rest' => true,
    ]);
}
add_action('init', 'make_tags_hierarchical', 1);
// Стилизация меток под рубрики в админке
function admin_tags_like_categories()
{
    echo '<style>
        .taxonomy-post_tag .term-parent-wrap,
        .taxonomy-post_tag .form-field.term-slug-wrap {
            display: block !important;
        }
        .taxonomy-post_tag .term-description-wrap {
            display: none;
        }
    </style>';
}
add_action('admin_head', 'admin_tags_like_categories');






// Регистрация типа записи 'news'
function create_news_post_type()
{
    $args = array(
        'labels' => array(
            'name' => __('Новости'),
            'singular_name' => __('Новость'),
            'add_new' => __('Добавить новость'),
            'add_new_item' => __('Добавить новую новость'),
            'edit_item' => __('Редактировать новость'),
            'new_item' => __('Новая новость'),
            'view_item' => __('Просмотреть новость'),
            'search_items' => __('Искать новости'),
            'not_found' => __('Новостей не найдено'),
            'not_found_in_trash' => __('Новостей в корзине не найдено'),
            'menu_name' => __('Новости')
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'news'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'comments', 'revisions'),
        'taxonomies' => array('category', 'post_tag'),
        'menu_icon' => 'dashicons-media-text',
        'menu_position' => 5,
        'show_in_rest' => true, // Ключевой параметр для Гутенберга
        'rest_base' => 'news',
        'capability_type' => 'post',
        'map_meta_cap' => true
    );
    register_post_type('news', $args);
}
add_action('init', 'create_news_post_type');

// Регистрация типа записи 'post_users'
function create_post_users_post_type()
{
    $args = array(
        'labels' => array(
            'name' => __('Посты пользователей'),
            'singular_name' => __('Пост пользователя'),
            'add_new' => __('Добавить пост'),
            'add_new_item' => __('Добавить новый пост'),
            'edit_item' => __('Редактировать пост'),
            'new_item' => __('Новый пост'),
            'view_item' => __('Просмотреть пост'),
            'search_items' => __('Искать посты'),
            'not_found' => __('Постов не найдено'),
            'not_found_in_trash' => __('Постов в корзине не найдено'),
            'menu_name' => __('Посты пользователей')
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'user-posts'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'author', 'custom-fields'),
        'taxonomies' => array('category', 'post_tag'),
        'menu_icon' => 'dashicons-format-chat',
        'menu_position' => 6,
        'show_in_rest' => true, // Ключевой параметр для Гутенберга
        'rest_base' => 'post_users',
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'show_in_admin_bar' => true
    );
    register_post_type('post_users', $args);
}
add_action('init', 'create_post_users_post_type');





function enable_comments_globally($status, $post_id)
{
    return true; // Включает комментарии для всех постов
}
add_filter('comments_open', 'enable_comments_globally', 10, 2);






function custom_gutenberg_block()
{
    wp_register_script(
        'custom-interesting-post',
        get_template_directory_uri() . '/blocks/interesting-post/index.js',
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-data'),
        filemtime(get_template_directory() . '/blocks/interesting-post/index.js'),
        true
    );

    register_block_type('custom/interesting-post', array(
        'editor_script' => 'custom-interesting-post',
    ));
}
add_action('init', 'custom_gutenberg_block');

function custom_rest_api_fields()
{
    register_rest_field('post', 'featured_media_src_url', [
        'get_callback' => function ($post) {
            $image_id = get_post_thumbnail_id($post['id']);
            return $image_id ? wp_get_attachment_image_url($image_id, 'full') : '';
        },
    ]);
}
add_action('rest_api_init', 'custom_rest_api_fields');





// Функция для увеличения счетчика просмотров
function increment_post_views($post_id)
{
    $views = get_post_meta($post_id, 'views', true); // Получаем текущее значение
    $views = ($views ? $views : 0) + 1; // Увеличиваем на 1
    update_post_meta($post_id, 'views', $views); // Обновляем мета-данные
}

add_action('wp_head', function () {
    if (is_single()) {
        increment_post_views(get_the_ID()); // Увеличиваем счетчик при просмотре поста
    }
});




require_once get_template_directory() . '/component/form_registration/script.php';

require_once get_template_directory() . '/component/Helper/format_time.php';

require_once get_template_directory() . '/component/template/script.php';

require_once get_template_directory() . '/component/count_view/script.php';
require_once get_template_directory() . '/component/count_messages/script.php';
require_once get_template_directory() . '/component/fix_controller/script.php';


require_once get_template_directory() . '/component/post/script.php';

require_once get_template_directory() . '/component/infinite-scroll/InfinityModel.php';
require_once get_template_directory() . '/component/infinite-scroll/InfinityView.php';
require_once get_template_directory() . '/component/infinite-scroll/InfinityController.php';
require_once get_template_directory() . '/component/infinite-scroll/script.php';

require_once get_template_directory() . '/component/set_like/LikeModel.php';
require_once get_template_directory() . '/component/set_like/LikeView.php';
require_once get_template_directory() . '/component/set_like/LikeController.php';
require_once get_template_directory() . '/component/set_like/script.php';

require_once get_template_directory() . '/component/comments/input/script.php';

require_once get_template_directory() . '/component/comments/comment_list/script.php';

require_once get_template_directory() . '/component/comments/comment_list/comment_controller/script.php';

require_once get_template_directory() . '/component/comments/comment_list/comment_selector/script.php';

require_once get_template_directory() . '/component/comments/comment_list/comment_restore/script.php';

require_once get_template_directory() . '/component/comments/comment_list/comment_selector/comment_delet/script.php';

require_once get_template_directory() . '/component/comments/comment_list/comment_edit/script.php';

require_once get_template_directory() . '/component/comments/comment_list/show_more/script.php';

require_once get_template_directory() . '/component/comments/comment_list/comment_response/script.php';

require_once get_template_directory() . '/component/share_btn/script.php';

require_once get_template_directory() . '/component/share_link/script.php';

require_once get_template_directory() . '/component/comments/comment_list/helper/script.php';

require_once get_template_directory() . '/component//post_from_users/script.php';

require_once get_template_directory() . '/component/preprint/script.php';

require_once get_template_directory() . "/metabox/script.php";

require_once get_template_directory() . "/component/related_posts/script.php";

// Подключаем компонент Lightbox для изображений
require_once get_template_directory() . "/component/lightbox/script.php";












// Добавляем столбец и делаем его сортируемым
// 1. Добавляем столбец в таблицу пользователей
function add_activation_status_column($columns)
{
    $columns['activation_status'] = 'Статус активации';
    return $columns;
}
add_filter('manage_users_columns', 'add_activation_status_column');

// 2. Делаем столбец сортируемым
function make_activation_status_column_sortable($columns)
{
    $columns['activation_status'] = 'is_activated'; // Ключ meta_field для сортировки
    return $columns;
}
add_filter('manage_users_sortable_columns', 'make_activation_status_column_sortable');

// 3. Обрабатываем сортировку
function handle_activation_status_sorting($query)
{
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    $orderby = $query->get('orderby');

    if ('is_activated' == $orderby) {
        $query->set('meta_key', 'is_activated');
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_users', 'handle_activation_status_sorting');

// 4. Отображаем содержимое столбца
function show_activation_status_column_content($value, $column_name, $user_id)
{
    if ('activation_status' === $column_name) {
        $is_activated = get_user_meta($user_id, 'is_activated', true);
        return $is_activated ? 'Активирован' : 'Нет';
    }
    return $value;
}
add_filter('manage_users_custom_column', 'show_activation_status_column_content', 10, 3);





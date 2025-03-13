<?php
/**
 * GeoInfo functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package GeoInfo
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function geoinfo_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on GeoInfo, use a find and replace
		* to change 'geoinfo' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'geoinfo', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'geoinfo' ),
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
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'geoinfo_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function geoinfo_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'geoinfo_content_width', 640 );
}
add_action( 'after_setup_theme', 'geoinfo_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function geoinfo_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'geoinfo' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'geoinfo' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'geoinfo_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function geoinfo_scripts() {
	wp_enqueue_style( 'geoinfo-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'geoinfo-style', 'rtl', 'replace' );

	wp_enqueue_script( 'geoinfo-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'geoinfo_scripts' );

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
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

function geoinfo_enqueue_styles() {
    // Подключение Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Lato&display=swap', array(), null, 'print');

    // Подключение Swiper CSS
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0');

    // Подключение Cropper.js CSS
    wp_enqueue_style('cropper-css', 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css', array(), '1.6.2');
}
add_action('wp_enqueue_scripts', 'geoinfo_enqueue_styles');

function geoinfo_enqueue_local_styles() {
    // Подключение локальных стилей
    wp_enqueue_style('data-css', get_template_directory_uri() . '/style/data.css', array(), '1.0.0');
    wp_enqueue_style('main-css', get_template_directory_uri() . '/style/main.css', array(), '1.0.0');
    wp_enqueue_style('button-css', get_template_directory_uri() . '/style/button.css', array(), '1.0.0');
    wp_enqueue_style('input-css', get_template_directory_uri() . '/style/input.css', array(), '1.0.0');
    wp_enqueue_style('editor-css', get_template_directory_uri() . '/style/editor.css', array(), '1.0.0');
    wp_enqueue_style('mobile-css', get_template_directory_uri() . '/style/mobile.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'geoinfo_enqueue_local_styles');

function geoinfo_custom_body_class($classes) {
    // Добавляем ваш класс
    $classes[] = 'body';
    return $classes;
}
add_filter('body_class', 'geoinfo_custom_body_class');

function geoinfo_enqueue_scripts() {
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


function geoinfo_enqueue_local_scripts() {
    
   

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
        wp_enqueue_script($handle, get_template_directory_uri() . $path, array(), '1.0.0', true);
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



function get_news($count) {
    // Пример: Получаем новости из базы данных
    $args = array(
        'post_type'      => 'post', // Тип записи "Пост"
        'posts_per_page' => $count, // Количество новостей
        'orderby'        => 'date', // Сортировка по дате
        'order'          => 'DESC', // По убыванию (новые сначала)
    );

    $news_query = new WP_Query($args);

    if ($news_query->have_posts()) {
        return $news_query->posts; // Возвращаем массив постов
    }

    return array(); // Если новостей нет, возвращаем пустой массив
}


function create_news_post_type() {
    register_post_type('news', // Идентификатор типа записи
        array(
            'labels' => array(
                'name' => __('Новости'), // Название типа записи
                'singular_name' => __('Новость'), // Название одной записи
                'add_new' => __('Добавить новость'), // Текст для добавления новой записи
                'add_new_item' => __('Добавить новую новость'), // Текст для добавления новой записи
                'edit_item' => __('Редактировать новость'), // Текст для редактирования записи
                'new_item' => __('Новая новость'), // Текст для новой записи
                'view_item' => __('Просмотреть новость'), // Текст для просмотра записи
                'search_items' => __('Искать новости'), // Текст для поиска записей
                'not_found' => __('Новостей не найдено'), // Текст, если записи не найдены
                'not_found_in_trash' => __('Новостей в корзине не найдено'), // Текст, если записи не найдены в корзине
            ),
            'public' => true, // Делаем тип записи публичным
            'has_archive' => true, // Включаем архив для этого типа записи
            'rewrite' => array('slug' => 'news'), // URL-префикс для записей
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'), // Поддерживаемые поля
            'taxonomies' => array('category', 'post_tag'), // Подключаем рубрики и метки
            'menu_icon' => 'dashicons-media-text', // Иконка в админке
            'menu_position' => 1,
        )
    );
}
add_action('init', 'create_news_post_type');



function enable_comments_globally($status, $post_id) {
    return true; // Включает комментарии для всех постов
}
add_filter('comments_open', 'enable_comments_globally', 10, 2);

require get_template_directory() . '/component/format_time.php';

require get_template_directory() . '/component/news/NewsModel.php';
require get_template_directory() . '/component/news/NewsView.php';
require get_template_directory() . '/component/news/NewsController.php';
require get_template_directory() . '/component/news/script.php';

require get_template_directory() . '/component/infinite-scroll/InfinityModel.php';
require get_template_directory() . '/component/infinite-scroll/InfinityView.php';
require get_template_directory() . '/component/infinite-scroll/InfinityController.php';
require get_template_directory() . '/component/infinite-scroll/script.php';

require get_template_directory() . '/component/set_like/LikeModel.php';
require get_template_directory() . '/component/set_like/LikeView.php';
require get_template_directory() . '/component/set_like/LikeController.php';
require get_template_directory() . '/component/set_like/script.php';

require get_template_directory() . '/component/comments/input/script.php';

require get_template_directory() . '/component/comments/comment_list/script.php';

require get_template_directory() . '/component/comments/comment_list/comment_controller/script.php';

require get_template_directory() . '/component/comments/comment_list/comment_selector/script.php';

require get_template_directory() . '/component/comments/comment_list/comment_restore/script.php';

require get_template_directory() . '/component/comments/comment_list/comment_selector/comment_delet/script.php';

require get_template_directory() . '/component/comments/comment_list/comment_edit/script.php';

require get_template_directory() . '/component/comments/comment_list/show_more/script.php';

require get_template_directory() . '/component/comments/comment_list/comment_response/script.php';
function register_my_custom_endpoint() {
    register_rest_route('commentlist/v1', '/get_replies_comments2', array(
        'methods' => 'POST',
        'callback' => 'CommentListModel::get_replies_comments2',
        'permission_callback' => '__return_true'  // Можно сделать публичным, или использовать кастомную проверку прав
    ));
}
add_action('rest_api_init', 'register_my_custom_endpoint');
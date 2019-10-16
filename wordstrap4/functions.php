<?php
/**
 * wordstrap4 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wordstrap4
 */

if ( ! function_exists( 'wordstrap4_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function wordstrap4_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on wordstrap4, use a find and replace
		 * to change 'wordstrap4' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'wordstrap4', get_template_directory() . '/languages' );

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
		
		// Include custom navwalker
		require_once('bs4navwalker.php');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'wordstrap4' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'wordstrap4_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'wordstrap4_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wordstrap4_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'wordstrap4_content_width', 640 );
}
add_action( 'after_setup_theme', 'wordstrap4_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wordstrap4_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wordstrap4' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'wordstrap4' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'wordstrap4_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wordstrap4_scripts() {
//deregister outdated scripts
wp_deregister_script('jquery');
wp_deregister_script('jquery-ui-core');
//reenable outdated scripts with updated versions
wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', array(), '3.2.1', true );
wp_enqueue_script( 'jquery-ui-core', "https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js", array('jquery'), '1.12.1', false );
// Enqueue Stylesheet
wp_enqueue_style( 'wordstrap4-style', get_stylesheet_uri() );  
// Enqueue Bootstrap 4 CSS
wp_enqueue_style( 'wordstrap4-bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '4.1.3' );     		
// Enqueue Bootstrap 4 Popper
wp_enqueue_script( 'wordstrap4-popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', array('jquery'), '1.0.0', true );
// Enqueue Bootstrap 4 JS
wp_enqueue_script( 'wordstrap4-bootstrapjs', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('wordstrap4-popper'), '4.1.3', true );
// Load Fontawesome 5
wp_enqueue_script( 'wordstrap4-fontawesome', get_template_directory_uri() . '/assets/js/all.min.js', array('jquery'), '5.11.2', true ); 

if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
}
}
add_action( 'wp_enqueue_scripts', 'wordstrap4_scripts' );

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


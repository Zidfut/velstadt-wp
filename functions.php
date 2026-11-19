<?php
/**
 * Velstadt functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Velstadt
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
function velstadt_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Velstadt, use a find and replace
		* to change 'velstadt' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'velstadt', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Use the front-end design system inside the Gutenberg canvas.
	add_theme_support( 'editor-styles' );
	add_editor_style( 'markup/css/styles.css' );
	add_editor_style( 'css/editor.css' );

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
			'menu-1' => esc_html__( 'Primary', 'velstadt' ),
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
			'velstadt_custom_background_args',
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
add_action( 'after_setup_theme', 'velstadt_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function velstadt_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'velstadt_content_width', 640 );
}
add_action( 'after_setup_theme', 'velstadt_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function velstadt_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'velstadt' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'velstadt' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'velstadt_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function velstadt_scripts() {
	$theme_dir = get_template_directory();
	$asset_version = static function ( $relative_path ) use ( $theme_dir ) {
		$path = $theme_dir . $relative_path;

		return file_exists( $path ) ? (string) filemtime( $path ) : _S_VERSION;
	};

	wp_enqueue_style( 'velstadt-style', get_stylesheet_uri(), array(), $asset_version( '/style.css' ) );
	wp_style_add_data( 'velstadt-style', 'rtl', 'replace' );

	wp_enqueue_style(
		'velstadt-swiper',
		get_template_directory_uri() . '/markup/libs/swiper/swiper.min.css',
		array(),
		$asset_version( '/markup/libs/swiper/swiper.min.css' )
	);
	wp_enqueue_style(
		'velstadt-layout',
		get_template_directory_uri() . '/markup/css/styles.css',
		array( 'velstadt-style', 'velstadt-swiper' ),
		$asset_version( '/markup/css/styles.css' )
	);

	wp_enqueue_script(
		'velstadt-swiper',
		get_template_directory_uri() . '/markup/libs/swiper/swiper.min.js',
		array(),
		$asset_version( '/markup/libs/swiper/swiper.min.js' ),
		true
	);
	wp_enqueue_script(
		'velstadt-scripts',
		get_template_directory_uri() . '/markup/js/scripts.js',
		array( 'velstadt-swiper' ),
		$asset_version( '/markup/js/scripts.js' ),
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_page_template( 'page-request-demo.php' ) ) {
		wp_enqueue_script( 'velstadt-request-demo', get_template_directory_uri() . '/markup/js/request-demo.js', array( 'contact-form-7' ), $asset_version( '/markup/js/request-demo.js' ), true );
	}
	if ( is_page_template( 'page-ransomware.php' ) ) {
		wp_enqueue_script( 'velstadt-ransomware', get_template_directory_uri() . '/markup/js/ransomware.js', array(), $asset_version( '/markup/js/ransomware.js' ), true );
	}
}
add_action( 'wp_enqueue_scripts', 'velstadt_scripts' );

/**
 * Keep Contact Form 7 from wrapping form markup in automatic paragraphs.
 *
 * Mail formatting is left unchanged; this only affects front-end forms.
 *
 * @param bool  $autop   Whether automatic paragraphs are enabled.
 * @param mixed $options Contact Form 7 context options.
 * @return bool
 */
function velstadt_disable_cf7_form_autop( $autop, $options ) {
	if ( is_array( $options ) && isset( $options['for'] ) && 'mail' === $options['for'] ) {
		return $autop;
	}

	return false;
}
add_filter( 'wpcf7_autop_or_not', 'velstadt_disable_cf7_form_autop', 10, 2 );

/** Require a work email for the demo form, as shown in its error state. */
function velstadt_validate_demo_work_email( $result, $tag ) {
	if ( 'demo-email' !== $tag->name ) {
		return $result;
	}

	$submission = WPCF7_Submission::get_instance();
	$email = $submission ? $submission->get_posted_data( $tag->name ) : '';
	if ( ! is_string( $email ) || ! is_email( $email ) ) {
		return $result;
	}

	$domain = strtolower( substr( strrchr( $email, '@' ), 1 ) );
	$personal_domains = array( 'gmail.com', 'googlemail.com', 'yahoo.com', 'yahoo.co.uk', 'hotmail.com', 'hotmail.co.uk', 'outlook.com', 'live.com', 'msn.com', 'icloud.com', 'me.com', 'aol.com', 'proton.me', 'protonmail.com', 'mail.com', 'gmx.com', 'gmx.de', 'ukr.net', 'i.ua', 'meta.ua' );
	$personal_domains = apply_filters( 'velstadt_demo_personal_email_domains', $personal_domains );
	if ( in_array( $domain, $personal_domains, true ) ) {
		$result->invalidate( $tag, __( "Personal email addresses aren't accepted. Please use your work email.", 'velstadt' ) );
	}

	return $result;
}
add_filter( 'wpcf7_validate_email*', 'velstadt_validate_demo_work_email', 20, 2 );

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
 * Editable header settings and helpers.
 */
require get_template_directory() . '/inc/header-settings.php';

/**
 * Editable footer settings and helpers.
 */
require get_template_directory() . '/inc/footer-settings.php';

/**
 * Front page fields and helpers.
 */
require get_template_directory() . '/inc/home-fields.php';

/**
 * Awards post type and taxonomy.
 */
require get_template_directory() . '/inc/awards.php';

/**
 * Blog archive helpers.
 */
require get_template_directory() . '/inc/blog.php';

/** Ransomware catalog queries. */
require get_template_directory() . '/inc/ransomware.php';

/**
 * Single post helpers and editorial blocks.
 */
require get_template_directory() . '/inc/post.php';

/**
 * Generic content page helpers.
 */
require get_template_directory() . '/inc/content-page.php';

/**
 * Services page fields and helpers.
 */
require get_template_directory() . '/inc/services-fields.php';

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


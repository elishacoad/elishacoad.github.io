<?php
/**
 * Action hooks.
 *
 * @since   1.0.0
 * @package Rolling
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'rolling_setup' ) ) {
	function rolling_setup() {

		/**
		 * Make theme available for translation.
		 * Translations can be filed in the /language/ directory.
		 *
		 * @since 1.0.0
		 */
		load_theme_textdomain( 'rolling', ROLLING_PATH . '/core/libraries/uipasta/language' );

		/**
		 * Add theme support.
		 *
		 * @since 1.0.0
		 */
		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		add_theme_support( 'custom-header' );
		add_theme_support( 'custom-background' );

		/**
		 * Register theme location.
		 *
		 * @since 1.0.0
		 */
		register_nav_menus(
			array(
				'primary-menu' => esc_html__( 'Primary Menu', 'rolling' ),
				'onepage-menu'  => esc_html__( 'OnePage Menu', 'rolling' ),
				'footer-menu'  => esc_html__( 'Footer Menu', 'rolling' ),
			)
		);

		// Tell TinyMCE editor to use a custom stylesheet.
		add_editor_style( get_template_directory_uri() . '/assets/css/editor-style.css' );
	}
}
add_action( 'after_setup_theme', 'rolling_setup' );

/**
 * Register widget area.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'rolling_register_sidebars' ) ) {
	function rolling_register_sidebars() {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Primary Sidebar', 'rolling' ),
				'id'            => 'primary-sidebar',
				'description'   => esc_html__( 'The primary sidebar, this sidebar display on all pages.', 'rolling' ),
				'before_widget' => '<aside id="%1$s" class="widget-box widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title fs__20 cp mg__0 mb__10">',
				'after_title'   => '</h4>',
			)
		);
	}
}
add_action( 'widgets_init', 'rolling_register_sidebars' );

/**
 * Add Menu Page Link.
 *
 * @return void
 * @since  1.0.0
 */
if ( ! function_exists( 'rolling_add_framework_menu' ) ) {
	function rolling_add_framework_menu() {
		$menu = 'add_menu_' . 'page';
		$menu(
			'jas_panel',
			esc_html__( 'UiPasta', 'rolling' ),
			'',
			'ui',
			NULL,
			ROLLING_URL . '/core/admin/assets/images/uipasta.png',
			99
		);
	}
}
add_action( 'admin_menu', 'rolling_add_framework_menu' );

/**
 * Enqueue scripts and styles.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'rolling_enqueue_scripts' ) ) {
	function rolling_enqueue_scripts() {

		// Google font
		wp_enqueue_style( 'font-google', rolling_google_font_url() );

		// Main scripts
		wp_enqueue_script( 'plugin-script', ROLLING_URL . '/assets/js/plugin.js', array(), '', true );

		// Masonry scripts
		wp_enqueue_script( 'masonry-script', ROLLING_URL . '/assets/js/masonry.pkgd.min.js', array(), '', true );

		// Main scripts
		wp_enqueue_script( 'rolling-script', ROLLING_URL . '/assets/js/script.js', array(), '', true );

		// Custom localize script
		wp_localize_script( 'rolling-script', 'JAS_Data_Js', rolling_custom_data_js() );
		
		// Font Awesome
		wp_enqueue_style( 'plugin', ROLLING_URL . '/assets/css/plugin.css' );
		
		// Gap Icons
		wp_enqueue_style( 'gap-icon', ROLLING_URL . '/assets/css/gap-icons.css' );

		// Main stylesheet
		wp_enqueue_style( 'rolling-style', get_stylesheet_uri() );

		// Inline stylesheet
		wp_add_inline_style( 'rolling-style', rolling_custom_css() );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		do_action( 'rolling_scripts');
	}
	add_action( 'wp_enqueue_scripts', 'rolling_enqueue_scripts' );
}

/**
 * Add meta data for social network
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'rolling_social_meta' ) ) {
	function rolling_social_meta() {
		$image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );
		$output  = '<meta property="og:site_name" content="' . get_bloginfo( 'name') . '"/>'. "\n";
		$output .= '<meta property="og:image" content="' . $image_src_array[ 0 ] . '"/>'. "\n";
		$output .= '<meta property="og:image:url" content="' . $image_src_array[ 0 ] . '"/>'. "\n";
		$output .= '<meta property="og:url" content="' . esc_url( get_permalink() ) . '"/>'. "\n";
		$output .= '<meta property="og:title" content="' . esc_attr( strip_tags( get_the_title() ) ) . '"/>'. "\n";
		$output .= '<meta property="og:description" content="' . esc_attr( strip_tags( get_the_excerpt() ) ) . '"/>'. "\n";
		$output .= '<meta property="og:type" content="article"/>'. "\n";
		echo balanceTags( $output );
	}
	add_action( 'wp_head', 'rolling_social_meta' );
}

/**
 * Add custom javascript code
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'rolling_custom_js' ) ) {
	function rolling_custom_js() {
		$data = cs_get_option( 'custom-js' );
		if ( ! empty( $data ) ) :
			echo '<scr' . 'ipt>' . $data . '</scr' . 'ipt>';
		endif;
	}
	add_action( 'wp_footer', 'rolling_custom_js' );
}

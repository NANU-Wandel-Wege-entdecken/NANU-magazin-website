<?php
/**
 * Attitude defining constants, adding files and WordPress core functionality.
 *
 * Defining some constants, loading all the required files and Adding some core functionality.
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menu() To add support for navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @package Theme Horse
 * @subpackage Attitude
 * @since Attitude 1.0
 */

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) :
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
endif;

if ( class_exists( 'Nanu\\Init' ) ) :
	Nanu\Init::register_services();
endif;


add_action( 'attitude_init', 'attitude_constants', 10 );
/**
 * This function defines the Attitude theme constants
 *
 * @since 1.0
 */
function attitude_constants() {

	/** Define Directory Location Constants */
	define( 'ATTITUDE_PARENT_DIR', get_stylesheet_directory() );
	define( 'ATTITUDE_IMAGES_DIR', ATTITUDE_PARENT_DIR . '/images' );
	define( 'ATTITUDE_LIBRARY_DIR', ATTITUDE_PARENT_DIR. '/library' );
	define( 'ATTITUDE_ADMIN_DIR', ATTITUDE_LIBRARY_DIR . '/admin' );
	define( 'ATTITUDE_ADMIN_IMAGES_DIR', ATTITUDE_ADMIN_DIR . '/images' );
	define( 'ATTITUDE_ADMIN_JS_DIR', ATTITUDE_ADMIN_DIR . '/js' );
	define( 'ATTITUDE_ADMIN_CSS_DIR', ATTITUDE_ADMIN_DIR . '/css' );
	define( 'ATTITUDE_JS_DIR', ATTITUDE_LIBRARY_DIR . '/js' );
	define( 'ATTITUDE_CSS_DIR', ATTITUDE_LIBRARY_DIR . '/css' );
	define( 'ATTITUDE_FUNCTIONS_DIR', ATTITUDE_LIBRARY_DIR . '/functions' );
	define( 'ATTITUDE_SHORTCODES_DIR', ATTITUDE_LIBRARY_DIR . '/shortcodes' );
	define( 'ATTITUDE_STRUCTURE_DIR', ATTITUDE_LIBRARY_DIR . '/structure' );
	define( 'ATTITUDE_LANGUAGES_DIR', ATTITUDE_LIBRARY_DIR . '/languages' );
	define( 'ATTITUDE_WIDGETS_DIR', ATTITUDE_LIBRARY_DIR . '/widgets' );

	/** Define URL Location Constants */
	define( 'ATTITUDE_PARENT_URL', get_stylesheet_directory_uri() );
	define( 'ATTITUDE_IMAGES_URL', ATTITUDE_PARENT_URL . '/images' );
	define( 'ATTITUDE_LIBRARY_URL', ATTITUDE_PARENT_URL . '/library' );
	define( 'ATTITUDE_ADMIN_URL', ATTITUDE_LIBRARY_URL . '/admin' );
	define( 'ATTITUDE_ADMIN_IMAGES_URL', ATTITUDE_ADMIN_URL . '/images' );
	define( 'ATTITUDE_ADMIN_JS_URL', ATTITUDE_ADMIN_URL . '/js' );
	define( 'ATTITUDE_ADMIN_CSS_URL', ATTITUDE_ADMIN_URL . '/css' );
	define( 'ATTITUDE_JS_URL', ATTITUDE_LIBRARY_URL . '/js' );
	define( 'ATTITUDE_CSS_URL', ATTITUDE_LIBRARY_URL . '/css' );
	define( 'ATTITUDE_FUNCTIONS_URL', ATTITUDE_LIBRARY_URL . '/functions' );
	define( 'ATTITUDE_SHORTCODES_URL', ATTITUDE_LIBRARY_URL . '/shortcodes' );
	define( 'ATTITUDE_STRUCTURE_URL', ATTITUDE_LIBRARY_URL . '/structure' );
	define( 'ATTITUDE_LANGUAGES_URL', ATTITUDE_LIBRARY_URL . '/languages' );
}

add_action( 'attitude_init', 'attitude_load_files', 15 );
/**
 * Loading the included files.
 *
 * @since 1.0
 */
function attitude_load_files() {
	/**
	 * attitude_add_files hook
	 *
	 * Adding other addtional files if needed.
	 */
	do_action( 'attitude_add_files' );

	/** Load functions */
	require_once( ATTITUDE_FUNCTIONS_DIR . '/functions.php' );

	require_once( ATTITUDE_ADMIN_DIR . '/attitude-themeoptions-defaults.php' );
	require_once( ATTITUDE_ADMIN_DIR . '/theme-options.php' );
	require_once( ATTITUDE_ADMIN_DIR . '/attitude-metaboxes.php' );
	require_once( ATTITUDE_ADMIN_DIR . '/attitude-show-post-id.php' );

	/** Load Shortcodes */
	require_once( ATTITUDE_SHORTCODES_DIR . '/attitude-shortcodes.php' );

	/** Load Structure */
	require_once( ATTITUDE_STRUCTURE_DIR . '/header-extensions.php' );
	require_once( ATTITUDE_STRUCTURE_DIR . '/content-extensions.php' );
	require_once( ATTITUDE_STRUCTURE_DIR . '/sidebar-extensions.php' );
	require_once( ATTITUDE_STRUCTURE_DIR . '/footer-extensions.php' );
	require_once( ATTITUDE_STRUCTURE_DIR . '/searchform-extensions.php' );

	/** Load Widgets and Widgetized Area */
	require_once( ATTITUDE_WIDGETS_DIR . '/attitude_widgets.php' );
}



/**
 * attitude_init hook
 *
 * Hooking some functions of functions.php file to this action hook.
 */
do_action( 'attitude_init' );


// Bilder standardmäßig mit der Mediendatei verlinken
update_option('image_default_link_type','file');

// Link von Bildern in Galerien auf Bild erzwingen
add_filter( 'shortcode_atts_gallery',
	function( $out ){
		$out['link'] = 'file';
		return $out;
	}
);

// Kommentare für Attachments sperren
function filter_media_comment_status( $open, $post_id ) {
	$post = get_post( $post_id );
	if( $post->post_type == 'attachment' ) {
		return false;
	}
	return $open;
}
add_filter( 'comments_open', 'filter_media_comment_status', 10 , 2 );

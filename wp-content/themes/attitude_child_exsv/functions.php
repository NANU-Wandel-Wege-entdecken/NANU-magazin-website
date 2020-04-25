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






 /**
 * Enqueue styles and scripts
 */
add_action('wp_enqueue_scripts', 'enqueue_scripts', 0);
function enqueue_scripts() {
	wp_register_style('attitude', get_stylesheet_directory_uri() .'/style.css', false, '1.3');
	wp_enqueue_style('attitude');

	wp_register_style('exsv_style-child', get_stylesheet_directory_uri() . '/style-child.css', [ 'attitude' ], '1.18');
	wp_enqueue_style( 'exsv_style-child' );

	wp_register_style('exsv_style', get_stylesheet_directory_uri() . '/css/exsv.css', [ 'exsv_style-child' ], '1.17');
	wp_enqueue_style( 'exsv_style' );

	wp_enqueue_script('steadyhq', '//steadyhq.com/widget_loader/f0259c6c-f500-4eb7-bb60-a8261f2b7ec2', ['jquery'], null, true);
}


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



function publish_later_on_feed($where) {
	global $wpdb;

	if ( is_feed() ) {
		// timestamp in WP-format
		$now = gmdate('Y-m-d H:i:s');

		// value for wait; + device
		$wait = '10'; // integer

		// http://dev.mysql.com/doc/refman/5.0/en/date-and-time-functions.html#function_timestampdiff
		$device = 'MINUTE'; //MINUTE, HOUR, DAY, WEEK, MONTH, YEAR

		// add SQL-sytax to default $where
		$where .= " AND TIMESTAMPDIFF($device, $wpdb->posts.post_date_gmt, '$now') > $wait ";
	}
	return $where;
}
add_filter('posts_where', 'publish_later_on_feed');

function feedFilter($query) {
	if ($query->is_feed) {
		add_filter('the_content','feedContentFilter');
	}
	return $query;
}
add_filter('pre_get_posts','feedFilter');
function feedContentFilter($content) {
	$content .= '<p><hr />Lies weitere Artikel über Wandel-Wege auf der Website des <a href="https://nanu-magazin.org/?utm_source=rss&utm_medium=rss-feed&utm_campaign=Hinweis_auf_Website">NANU Magazins</a>.<hr /></p>';

	return $content;
}

function rss_post_thumbnail($content) {
	global $post;
	if(has_post_thumbnail($post->ID)) {
		$content = get_the_post_thumbnail($post->ID) . $content;
	}
	return $content;
}
add_filter('the_excerpt_rss', 'rss_post_thumbnail');
add_filter('the_content_feed', 'rss_post_thumbnail');


// Nur Kommentare zu eigenen Artikeln anzeigen
function wps_get_comment_list_by_user($clauses) {
	if (is_admin()) {
		global $user_ID, $wpdb;
		$clauses['join'] = ", ".$wpdb->base_prefix."posts";
		$clauses['where'] .= " AND ".$wpdb->base_prefix."posts.post_author = ".$user_ID." AND ".$wpdb->base_prefix."comments.comment_post_ID = ".$wpdb->base_prefix."posts.ID";
	};
	return $clauses;
};

if(!current_user_can('edit_others_posts')) {
	add_filter('comments_clauses', 'wps_get_comment_list_by_user');
}

// Nur eigene Artikel anzeigen
function filter_posts_list( $query ) {

	if ( ! is_admin() ) {
		return $query;
	}
	//$pagenow holds the name of the current page being viewed
	global $pagenow;

	//$current_user uses the get_currentuserinfo() method to get the currently logged in user's data
	 global $current_user;

	//Shouldn't happen for the admin und nicht für Editor*innen - daher Prüfung nach capability Edit Others Posts, but for any role with the edit_posts capability and only on the posts list page, that is edit.php
	if(
		! current_user_can('edit_others_posts')
		&& current_user_can('edit_posts')
		&& ('edit.php' == $pagenow)
	) {
		//global $query's set() method for setting the author as the current user's id
		$query->set('author', $current_user->ID);
	}
}
add_action('pre_get_posts', 'filter_posts_list');

// Nachricht unter den Titel im Editor einfügen
add_action( 'edit_form_after_title', 'myprefix_edit_form_after_title' );

function myprefix_edit_form_after_title() {
	echo '<h2>Ein paar Tipps fürs Schreiben</h2><p>Bitte schau dir folgende Tipps und Anhaltspunkte an, damit dein Artikel möglichst flott für eine Veröffentlichung in Frage kommt: <a href="https://nanu-magazin.org/mitmachen/gastartikel-schreiben/das-format-von-experimentselbstversorgung-net/" target="_blank">So schreiben wir Artikel auf dieser Website!</a>';
}

// Email versenden, sobald ein Artikel auf Review geschickt wird
add_action('future_to_pending', 'send_emails_on_new_event');
add_action('new_to_pending', 'send_emails_on_new_event');
add_action('draft_to_pending', 'send_emails_on_new_event');
add_action('auto-draft_to_pending', 'send_emails_on_new_event');
function send_emails_on_new_event($post)
{
	$emails = "michael@nanu-magazin.org";
	$title = wp_strip_all_tags(get_the_title($post->ID));
	$url = get_permalink($post->ID);
	$message = "Bitte prüfen! Link zum Artikel: \n{$url}";

	wp_mail($emails, "Neuer Gastartikel: {$title}", $message);
}


// SEITEN VON DER WORDPRESS-SUCHE AUSSCHLIESSEN
function js_search_filter( $query ) {
	if ( $query->is_search ) {
		$query->set('post__not_in', array(
			111820,
			110339,
			111575,
			111564,
			111582,
			110372,
			110782,
			110353,
			111119,
			113183,
			114917,
			114916,
			114791,
			115259,
			115260,
			110259,
			3560
		) );
	}
		return $query;
}
add_action( 'pre_get_posts',
 'js_search_filter' );

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

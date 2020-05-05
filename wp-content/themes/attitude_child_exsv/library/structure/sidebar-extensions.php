<?php
/**
 * Shows the sidebar content.
 *
 * @package 		Theme Horse
 * @subpackage 	Attitude
 * @since 			Attitude 1.0
 * @license 		http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link 			http://themehorse.com/themes/attitude
 */

/****************************************************************************************/

add_action( 'attitude_right_sidebar', 'attitude_display_right_sidebar', 10 );
/**
 * Show widgets of right sidebar.
 *
 * Shows all the widgets that are dragged and dropped on the right Sidebar.
 */

function attitude_display_right_sidebar() {
	 
	wp_reset_query();
	// Calling the right sidebar.
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'attitude_right_sidebar' ) ):
	endif;
		// Ähnliche Artikel aufrufen, wenn es eine Beitrags-Seite ist
	wp_reset_query();
	if ( is_single() ) {
	related_posts() ?>
	<div class="yarpp-related">
		<menu>Wusstest Du, dass wir auch B&uuml;cher schreiben?</menu>
		<div class="yarpp-thumbnails-horizontal">
			<a class="yarpp-thumbnail" href="https://nanu-magazin.org/lisas-buecher-jetzt-bestellen/" title="Jetzt Lisas B&uuml;cher kennenlernen">
				<img width="300" height="200" src="https://nanu-magazin.org/wp-content/uploads/2014/04/brennnesselsuppe-veganregionalsaisonal-300x200.jpg" class="attachment-yarpp-thumbnail size-yarpp-thumbnail wp-post-image" alt="Blick ins Buch Vegan Regional Saisonal">
				<span class="yarpp-thumbnail-title">Blick ins Buch Vegan Regional Saisonal</span>
				<span class="yarpp-thumbnail-date">- Jetzt alle Bücher kennenlernen! -</span>
			</a>
		</div>
	</div>
	<?php }    
		// Calling the social sidebar if it exists.
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'social_sidebar' ) ):
	endif;
}

/****************************************************************************************/

add_action( 'attitude_contact_page_sidebar', 'attitude_display_contact_page_sidebar', 10 );
/**
 * Show widgets on Contact Page Template's sidebar.
 *
 * Shows all the widgets that are dragged and dropped on the Contact Page Sidebar.
 */
function attitude_display_contact_page_sidebar() {
	// Calling the conatact page sidebar if it exists.
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'attitude_contact_page_sidebar' ) ):
	endif;
		// Calling the social sidebar if it exists.
	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'social_sidebar' ) ):
	endif;
}

/****************************************************************************************/

add_action( 'attitude_footer_sidebar', 'attitude_display_footer_sidebar', 10 );
/**
 * Show widgets on Footer of the theme.
 *
 * Shows all the widgets that are dragged and dropped on the Footer Sidebar.
 */
function attitude_display_footer_sidebar() {
	if( is_active_sidebar( 'attitude_footer_sidebar' ) ) {
		?>
		<div class="widget-wrap">
			<div class="container">
				<div class="widget-area clearfix">
					
					<?php if ( is_front_page() ) { ?> 
						<div class="adfooter">
							<ins data-revive-zoneid="5" data-revive-target="_blank" data-revive-ct0="{clickurl_enc}" data-revive-block="1" data-revive-id="a476a6839abba5db5c2dc4f89714f5bc"></ins>
							<script async src="//img.digitalfellow.eu/www/delivery/asyncjs.php"></script>
						</div>
					<?php } if ( ! is_front_page() ) { ?>
						<div class="adfooter">
							<ins data-revive-zoneid="6" data-revive-target="_blank" data-revive-ct0="{clickurl_enc}" data-revive-block="1" data-revive-id="a476a6839abba5db5c2dc4f89714f5bc"></ins>
							<script async src="//img.digitalfellow.eu/www/delivery/asyncjs.php"></script>
						</div>                        
					<?php } ; ?>                    
					
				<?php
					// Calling the footer sidebar if it exists.
					if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'attitude_footer_sidebar' ) ):
					endif;
				?>
				</div><!-- .widget-area -->
			</div><!-- .container -->
		</div><!-- .widget-wrap -->
		<?php
	}
}

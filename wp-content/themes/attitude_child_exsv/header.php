<?php
/**
 * Displays the header section of the theme.
 *
 * @package Theme Horse
 * @subpackage Attitude
 * @since Attitude 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

	<?php
		/**
		 * attitude_title hook
		 *
		 * HOOKED_FUNCTION_NAME PRIORITY
		 *
		 * attitude_add_meta 5
		 * attitude_show_title 10
		 *
		 */
		do_action( 'attitude_title' );

		/**
		 * attitude_meta hook
		 */
		do_action( 'attitude_meta' );

		/**
		 * attitude_links hook
		 *
		 * HOOKED_FUNCTION_NAME PRIORITY
		 *
		 * attitude_add_links 10
		 * attitude_favicon 15
		 * attitude_webpageicon 20
		 *
		 */
		do_action( 'attitude_links' );
    ?>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-PPK5PL8');</script>
        <!-- End Google Tag Manager -->

     <?php
		/**
		 * This hook is important for wordpress plugins and other many things
		 */
		wp_head();

    ?>

</head>

<body <?php body_class(); ?>>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PPK5PL8" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="wptime-plugin-preloader"></div>
	<?php
		/**
		 * attitude_before hook
		 */
		do_action( 'attitude_before' );
	?>

	<div class="wrapper">
		<?php
			/**
			 * attitude_before_header hook
			 */
			do_action( 'attitude_before_header' );
		?>
		<header id="branding" >
			<?php
				/**
				 * attitude_header hook
				 *
				 * HOOKED_FUNCTION_NAME PRIORITY
				 *
				 * attitude_headerdetails 10
				 */
				do_action( 'attitude_header' );
			?>
		</header>
		<?php
			/**
			 * attitude_after_header hook
			 */
			do_action( 'attitude_after_header' );
		?>

		<?php
			/**
			 * attitude_before_main hook
			 */
			do_action( 'attitude_before_main' );
		?>
		<div id="main" class="container clearfix">

<?php

namespace Nanu\Setup;

/**
 * Enqueue.
 */
class Enqueue
{
	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function register()
	{
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	public function enqueue_scripts()
	{

		wp_register_style('attitude', get_stylesheet_directory_uri() .'/style.css', false, '1.4');
		wp_enqueue_style('attitude');

		wp_register_style('exsv_style-child', get_stylesheet_directory_uri() . '/style-child.css', [ 'attitude' ], '1.19');
		wp_enqueue_style( 'exsv_style-child' );

		wp_register_style('exsv_style', get_stylesheet_directory_uri() . '/css/exsv.css', [ 'exsv_style-child' ], '1.19');
		wp_enqueue_style( 'exsv_style' );

		wp_enqueue_script('steadyhq', '//steadyhq.com/widget_loader/f0259c6c-f500-4eb7-bb60-a8261f2b7ec2', ['jquery'], null, true);

		// Extra
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}

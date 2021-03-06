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

		wp_register_style('attitude', get_stylesheet_directory_uri() .'/style.css', false, '1.7');
		wp_enqueue_style('attitude');

		wp_register_style('exsv_style-child', get_stylesheet_directory_uri() . '/style-child.css', [ 'attitude' ], '1.24');
		wp_enqueue_style( 'exsv_style-child' );

		wp_register_style('exsv_style', get_stylesheet_directory_uri() . '/css/exsv.css', [ 'exsv_style-child' ], '1.25');
		wp_enqueue_style( 'exsv_style' );

		wp_register_style('jquerymodal_style', '//cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css', [ 'exsv_style-child' ], '0.9.1');
		wp_enqueue_style( 'jquerymodal_style' );

		wp_enqueue_script('steadyhq', '//steadyhq.com/widget_loader/f0259c6c-f500-4eb7-bb60-a8261f2b7ec2', ['jquery'], null, true);

		wp_enqueue_script('jquerymodal', '//cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js', ['jquery'], null, true);

		// Extra
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}

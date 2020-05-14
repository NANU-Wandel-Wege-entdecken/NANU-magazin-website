<?php
/**
 *
 * This theme uses PSR-4 and OOP logic instead of procedural coding
 * Every function, hook and action is properly divided and organized inside related folders and files
 * Use the file `config/custom/custom.php` to write your custom functions
 *
 * @package Nanu
 */

namespace Nanu;

final class Init
{
	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	public static function get_services()
	{
		return [
			// Core\Tags::class,
			// Core\Sidebar::class,
			Setup\Setup::class,
			Setup\Menus::class,
			Setup\CleanUp::class,
			Admin\CleanUp::class,
			Admin\EditFlow::class,
			Setup\Enqueue::class,
			Setup\Feed::class,
			Setup\Language::class,
			Setup\Search::class,
			Setup\Attachments::class,
			// Custom\Extras::class,
			// Api\Gutenberg::class,
			// Plugins\Plate::class,
			Plugins\PopularPosts::class,
			Structure\PostTypeAffiliateProduct::class,
			Structure\UserProfile::class,
			Structure\Subtitle::class,
			Structure\CategoryLeadAuthor::class
		];
	}

	/**
	 * Loop through the classes, initialize them, and call the register() method if it exists
	 * @return
	 */
	public static function register_services()
	{
		foreach ( self::get_services() as $class ) {
			$service = self::instantiate( $class );
			if ( method_exists( $service, 'register') ) {
				$service->register();
			}
		}
	}

	/**
	 * Initialize the class
	 * @param  class $class 		class from the services array
	 * @return class instance 		new instance of the class
	 */
	private static function instantiate( $class )
	{
		return new $class();
	}

}

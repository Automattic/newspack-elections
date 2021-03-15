<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack;

defined( 'ABSPATH' ) || exit;


/**
 * Main Govpack Class.
 */
class Govpack {

	/**
	 * Stores static instance of class.
	 *
	 * @access protected
	 * @var Govpack\Govpack The single instance of the class
	 */
	protected static $instance = null;

	/**
	 * Returns static instance of class.
	 *
	 * @return self
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Inits the class and registeres the hooks call
	 *
	 * @return self
	 */
	public function __construct() {
		
		add_action( 'after_setup_theme', [ __class__, 'hooks' ] );
	}

	/**
	 * WordPress Hooks
	 */
	public static function hooks() {
		
		\Newspack\Govpack\CPT\Profile::instance();
	}
}


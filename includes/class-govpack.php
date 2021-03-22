<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack;

defined( 'ABSPATH' ) || exit;

define( 'GOVPACK_VERSION', '0.0.1' );

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
		\Newspack\Govpack\Gutenberg\Block::instance();
		\Newspack\Govpack\Tax\City::hooks();
		\Newspack\Govpack\Tax\County::hooks();
		\Newspack\Govpack\Tax\Installation::hooks();
		\Newspack\Govpack\Tax\LegislativeBody::hooks();
		\Newspack\Govpack\Tax\OfficeHolderStatus::hooks();
		\Newspack\Govpack\Tax\Party::hooks();
		\Newspack\Govpack\Tax\State::hooks();
	}
}

add_action( 'after_setup_theme', [ '\Newspack\Govpack\Govpack', 'hooks' ] );
add_action( 'after_setup_theme', [ '\Newspack\Govpack\Hooks', 'setup_hooks' ] );
add_action( 'after_setup_theme', [ '\Newspack\Govpack\Hooks', 'set_image_sizes' ] );

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once __DIR__ . '/class-cli.php';
}

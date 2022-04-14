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
	 * Reference to REST API Prefix for consistency.
	 *
	 * @access public
	 * @var string REST API Prefix
	 */
	const REST_PREFIX = 'govpack/v1';

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
	 * Inits the class and registeres the hooks call.
	 */
	public function __construct() {
		add_action( 'after_setup_theme', [ __class__, 'hooks' ] );
		add_action( 'plugins_loaded', [ '\Newspack\Govpack\ActionScheduler\ActionScheduler', 'hooks' ], 0 );

	}

	/**
	 * WordPress Hooks
	 */
	public static function hooks() {

		// get capabilities setup first
		\Newspack\Govpack\Capabilities::hooks();

		// Functions well need.
		\Newspack\Govpack\CPT\AsTaxonomy::hooks();

		// Custom Post Types.
		\Newspack\Govpack\CPT\Profile::hooks();

		// Taxonomies.
		\Newspack\Govpack\Tax\LegislativeBody::hooks();
		\Newspack\Govpack\Tax\OfficeHolderStatus::hooks();
		\Newspack\Govpack\Tax\OfficeHolderTitle::hooks();
		\Newspack\Govpack\Tax\Party::hooks();
		\Newspack\Govpack\Tax\Profile::hooks();
		\Newspack\Govpack\Tax\State::hooks();

		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			\Newspack\Govpack\CLI::init();
		}

		\Newspack\Govpack\Importer\Importer::hooks();
		\Newspack\Govpack\Admin\Admin::hooks();
		\Newspack\Govpack\FrontEnd\FrontEnd::hooks();

		\Newspack\Govpack\Block\Profile::hooks();
		\Newspack\Govpack\Block\ProfileSelf::hooks();
	}
}

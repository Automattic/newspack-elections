<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack;

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
		add_action( 'plugins_loaded', [ '\Govpack\ActionScheduler\ActionScheduler', 'hooks' ], 0 );

	}

	/**
	 * WordPress Hooks
	 */
	public static function hooks() {


		// Functions well need.
		\Govpack\CPT\AsTaxonomy::hooks();

		// Custom Post Types.
		\Govpack\CPT\Profile::hooks();

		// get capabilities setup first.
		\Govpack\Capabilities::hooks();

		// Taxonomies.
		\Govpack\Tax\LegislativeBody::hooks();
		\Govpack\Tax\OfficeHolderStatus::hooks();
		\Govpack\Tax\OfficeHolderTitle::hooks();
		\Govpack\Tax\Party::hooks();
		\Govpack\Tax\Profile::hooks();
		\Govpack\Tax\State::hooks();

		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			\Govpack\CLI::init();
		}

		\Govpack\Importer\Importer::hooks();
		\Govpack\Admin\Admin::hooks();
		\Govpack\FrontEnd\FrontEnd::hooks();

		\Govpack\Block\Profile\Profile::hooks();
		\Govpack\Block\ProfileSelf\ProfileSelf::hooks();
	}
}

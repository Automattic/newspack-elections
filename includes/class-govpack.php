<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core;

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
		\add_action( 'after_setup_theme', [ __class__, 'hooks' ] );
		\add_action( 'plugins_loaded', [ '\Govpack\Core\ActionScheduler\ActionScheduler', 'hooks' ], 0 );       
	}

	/**
	 * Action called by the plugin activation hook.
	 * Causes rewrite rules to be regenerated so permalinks will work
	 */
	public static function activation() {
		\Govpack\Core\CPT\Profile::register_post_type();
		flush_rewrite_rules( false ); //phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.flush_rewrite_rules_flush_rewrite_rules
	}

	/**
	 * Registers Plugin Post Types
	 */
	public static function post_types() {
		// Custom Post Types.
		\Govpack\Core\CPT\Profile::hooks();
	}

	/**
	 * Registers Plugin Taxonomies
	 */
	public static function taxonomies() {
		// Custom Post Types.
		\Govpack\Core\Tax\LegislativeBody::hooks();
		\Govpack\Core\Tax\OfficeHolderStatus::hooks();
		\Govpack\Core\Tax\OfficeHolderTitle::hooks();
		\Govpack\Core\Tax\Party::hooks();
		\Govpack\Core\Tax\State::hooks();

	}
	/**
	 * WordPress Hooks
	 */
	public static function hooks() {

		// Custom Post Types & taxonomies.
		self::post_types();
		self::taxonomies();

		// get capabilities setup first.
		\Govpack\Core\Capabilities::hooks();

		if ( defined( 'WP_CLI' ) && \WP_CLI ) {
			\Govpack\Core\CLI::init();
		}

		\Govpack\Core\Importer\Importer::hooks();
		\Govpack\Core\Admin\Admin::hooks();
		\Govpack\Core\FrontEnd\FrontEnd::hooks();

		\Govpack\Blocks\Profile\Profile::hooks();
		\Govpack\Blocks\ProfileSelf\ProfileSelf::hooks();
	}
}

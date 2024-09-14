<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core;

defined( 'ABSPATH' ) || exit;

define( 'GOVPACK_VERSION', '1.2.0' );

/**
 * Main Govpack Class.
 */
class Govpack {

	use \Govpack\Core\Instance;

	/**
	 * Reference to REST API Prefix for consistency.
	 *
	 * @access public
	 * @var string REST API Prefix
	 */
	const REST_PREFIX = 'govpack/v1';
	private null|Dev_Helpers $dev;
	private FrontEnd\FrontEnd $front_end;
	private Admin\Admin $admin;
	private Blocks $blocks;
	private Icons $icons;

	/**
	 * Inits the class and registeres the hooks call.
	 */
	public function __construct() {
		
		$this->hooks();
		$this->require( 'includes/govpack-functions.php' );
		$this->require( 'includes/govpack-functions-template.php' );

		if ( class_exists( '\Govpack\Core\Dev_Helpers' ) ) {
			$this->dev = new \Govpack\Core\Dev_Helpers( $this );
			$this->dev->hooks();
		}
	}

	public function path( $path ) {
		return GOVPACK_PLUGIN_PATH . $path; 
	}

	/**
	 * Action called by the plugin activation hook.
	 * Causes rewrite rules to be regenerated so permalinks will work
	 */
	public static function activation() {
		\Govpack\Core\CPT\Profile::register_post_type();
		flush_rewrite_rules( false ); //phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.flush_rewrite_rules_flush_rewrite_rules
	}

	public function build_path( $path ) {
		return trailingslashit(
			trailingslashit( $this->path( 'build' ) ) . $path 
		);
	}

	public function require( $path ) {
		return require_once $this->path( $path ); //phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingVariable
	}

	public function url( $path ) {
		return trailingslashit( GOVPACK_PLUGIN_URL ) . $path;
	}

	public function hooks() {
		\add_action( 'after_setup_theme', [ $this, 'setup' ] );
		\add_action( 'plugins_loaded', [ '\Govpack\Core\ActionScheduler\ActionScheduler', 'hooks' ], 0 );
		\add_action( 'init', [ $this, 'register_blocks' ] );
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
	
	public function text_domain(){
		load_plugin_textdomain( 'newspack-elections', false, $this->path('languages') );
	}

	public function setup() {

		$this->text_domain();

		// Custom Post Types & taxonomies.
		self::post_types();
		self::taxonomies();

		// get capabilities setup first.
		\Govpack\Core\Capabilities::hooks();

		if ( defined( 'WP_CLI' ) && \WP_CLI ) {
			\Govpack\Core\CLI::init();
		}

		\Govpack\Core\Importer\Importer::hooks();
		\Govpack\Core\Widgets::hooks();

		if ( is_admin() ) {
			$this->admin();
		}
		
		if ( ! is_admin() ) {
			$this->front_end();
		}
	}

	public function admin() {
		if ( ! isset( $this->admin ) ) {
			$this->admin = new Admin\Admin( $this );
			$this->admin->hooks();
		}
	}

	public function front_end() {

		if ( ! isset( $this->front_end ) ) {
			$this->front_end = FrontEnd\FrontEnd::instance();
			$this->front_end->hooks();
			$this->front_end->template_loader();
		} 

		return $this->front_end;
	}

	public function blocks() {

		if ( ! isset( $this->blocks ) ) {
			$this->blocks = new Blocks();
			$this->blocks->hooks();
		}
		
		return $this->blocks;
	}

	public function icons() {

		if ( ! isset( $this->icons ) ) {
			$this->icons = new Icons();
		}
		
		return $this->icons;
	}

	public function register_blocks() {
		$this->blocks()->register( new \Govpack\Blocks\Profile\Profile() );
		$this->blocks()->register( new \Govpack\Blocks\ProfileSelf\ProfileSelf() );
	}
}

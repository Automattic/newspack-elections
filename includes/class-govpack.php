<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core;

defined( 'ABSPATH' ) || exit;

define( 'GOVPACK_VERSION', '1.1.0' );

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



	public $front_end;
	private Blocks $blocks;

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
		
		$this->hooks();
		require_once 'gp-functions.php';
	}


	public function hooks() {
		\add_action( 'after_setup_theme', [ $this, 'setup' ] );
		\add_action( 'plugins_loaded', [ '\Govpack\Core\ActionScheduler\ActionScheduler', 'hooks' ], 0 );
		\add_action( 'init', [ $this, 'register_blocks' ] );
	}

	public function setup(){
		// Functions well need.
		\Govpack\Core\CPT\AsTaxonomy::hooks();

		// Custom Post Types.
		\Govpack\Core\CPT\Profile::hooks();

		// get capabilities setup first.
		\Govpack\Core\Capabilities::hooks();


		// Taxonomies.
		\Govpack\Core\Tax\LegislativeBody::hooks();
		\Govpack\Core\Tax\OfficeHolderStatus::hooks();
		\Govpack\Core\Tax\OfficeHolderTitle::hooks();
		\Govpack\Core\Tax\Party::hooks();
		\Govpack\Core\Tax\Profile::hooks();
		\Govpack\Core\Tax\State::hooks();

		if ( defined( 'WP_CLI' ) && \WP_CLI ) {
			\Govpack\Core\CLI::init();
		}

		\Govpack\Core\Importer\Importer::hooks();
		\Govpack\Core\Widgets::hooks();

		if(is_admin()){
			\Govpack\Core\Admin\Admin::hooks();
		}
		
		if(!is_admin()){
			$this->front_end = FrontEnd\FrontEnd::instance();
			$this->front_end->hooks();
			$this->front_end->template_loader();
		}

		require_once ( GOVPACK_PLUGIN_PATH . "includes/govpack-functions.php");
	}

	public function blocks(){

		if(!isset($this->blocks)){
			$this->blocks = new Blocks();
			$this->blocks->hooks();
		}
		
		return $this->blocks;
	}

	public function register_blocks(){
		$this->blocks()->register(new \Govpack\Blocks\Profile\Profile());
		$this->blocks()->register(new \Govpack\Blocks\ProfileSelf\ProfileSelf());
	}
}

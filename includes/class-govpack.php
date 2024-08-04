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

	use \Govpack\Core\Instance;

	/**
	 * Reference to REST API Prefix for consistency.
	 *
	 * @access public
	 * @var string REST API Prefix
	 */
	const REST_PREFIX = 'govpack/v1';
	private $dev;
	private $front_end;
	private Admin\Admin $admin;
	private Blocks $blocks;
	private Icons $icons;

	/**
	 * Inits the class and registeres the hooks call.
	 */
	public function __construct() {
		
		$this->hooks();
		$this->require("includes/govpack-functions.php");
		$this->require("includes/govpack-functions-template.php");

		if(class_exists('\Govpack\Core\Dev_Helpers')){
			$this->dev = new \Govpack\Core\Dev_Helpers($this);
			$this->dev->hooks();
		}
	}

	public function path($path){
		return GOVPACK_PLUGIN_PATH . $path;
	}

	public function build_path($path){
		return trailingslashit(
			trailingslashit($this->path("build")) . $path
		);
	}

	public function require($path){
		require_once ($this->path($path));
	}

	public function url($path){
		return trailingslashit( GOVPACK_PLUGIN_URL ) . $path;
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
			$this->admin();
		}
		
		if(!is_admin()){
			$this->front_end();
		}
		
	}

	public function admin(){
		if(!isset($this->admin)){
			$this->admin = new Admin\Admin($this);
			$this->admin->hooks();
		}
	}

	public function front_end(){

		if(!isset($this->front_end)){
			$this->front_end = FrontEnd\FrontEnd::instance();
			$this->front_end->hooks();
			$this->front_end->template_loader();
		} 

		return $this->front_end;
	}

	public function blocks(){

		if(!isset($this->blocks)){
			$this->blocks = new Blocks();
			$this->blocks->hooks();
		}
		
		return $this->blocks;
	}

	public function icons(){

		if(!isset($this->icons)){
			$this->icons = new Icons();
		}
		
		return $this->icons;
	}

	public function register_blocks(){
		$this->blocks()->register(new \Govpack\Blocks\Profile\Profile());
		$this->blocks()->register(new \Govpack\Blocks\ProfileSelf\ProfileSelf());
	}

}

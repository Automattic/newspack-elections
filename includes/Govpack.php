<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack;

use Govpack\Abstracts\Plugin;
use Govpack\FrontEnd\FrontEnd;
use Govpack\Admin\Admin;
use Govpack\Admin\Export;

/**
 * Main Govpack Class.
 */
class Govpack extends Plugin {

	use \Govpack\Instance;

	/**
	 * Reference to REST API Prefix for consistency.
	 *
	 * @access public
	 * @var string REST API Prefix
	 */
	const REST_PREFIX = 'govpack/v1';
	private null|DevHelper $dev;
	private FrontEnd $front_end;
	private Admin $admin;
	private Fields $fields;
	private Blocks $blocks;
	private BlockEditor $block_editor;
	private Icons $icons;
	public Version $version;

	public string $text_domain;

	/**
	 * Inits the class and registeres the hooks call.
	 */
	public function __construct() {
	}

	public function init() {
		$this->hooks();
		$this->require( 'includes/govpack-functions.php' );
		$this->require( 'includes/govpack-functions-template.php' );

		$this->version = new Version( $this );

		$this->text_domain = 'newspack-elections';

		if ( class_exists( '\Govpack\DevHelper' ) ) {
			$this->dev = new \Govpack\DevHelper( $this );
			$this->dev->hooks();
		}
	}

	/**
	 * Action called by the plugin activation hook.
	 * Causes rewrite rules to be regenerated so permalinks will work
	 */
	public static function activation(): void {
		\Govpack\Profile\CPT::register_post_type();
		flush_rewrite_rules( false ); //phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.flush_rewrite_rules_flush_rewrite_rules

		// get capabilities setup first.
		\Govpack\Capabilities::instance()->add_capabilities();
	}

	public static function deactivation(): void {
		
		// remove capabilities from database.
		\Govpack\Capabilities::instance()->remove_capabilities();
	}

	public function hooks(): void {
		\add_action( 'after_setup_theme', [ $this, 'setup' ] );
		\add_action( 'plugins_loaded', [ '\Govpack\ActionScheduler\ActionScheduler', 'hooks' ], 0 );
		\add_action( 'init', [ $this, 'register_blocks' ] );
		\add_action( 'rest_api_init', [ $this, 'rest_api' ] );
	}


	/**
	 * Registers Plugin Post Types
	 */
	public static function post_types(): void {
		// Custom Post Types.
		\Govpack\Profile\CPT::init();
	}

	/**
	 * Registers Plugin Taxonomies
	 */
	public static function taxonomies(): void {
		// Custom Post Types.
		\Govpack\Tax\LegislativeBody::hooks();
		\Govpack\Tax\OfficeHolderStatus::hooks();
		\Govpack\Tax\OfficeHolderTitle::hooks();
		\Govpack\Tax\Party::hooks();
		\Govpack\Tax\State::hooks();
	}
	
	public function text_domain() {
		load_plugin_textdomain( 'newspack-elections', false, $this->path( 'languages' ) );
	}

	public function setup(): void {

		$this->text_domain();
		$this->fields();

			// Custom Post Types & taxonomies.
		self::post_types();
		self::taxonomies();

	
		if ( defined( 'WP_CLI' ) && \WP_CLI ) {
			\Govpack\CLI::init();
		}

	

		( new ProfileBindingSource() )->register();

		$importer = new \Govpack\Importer\Importer( $this );
		$importer->hooks();

		$exporter = new Export( $this );
		$exporter->hooks();

		\Govpack\Widgets::hooks();


		$this->block_editor()->block_categories()->add(
			[
				'newspack-elections'                    => __( 'Newspack Election', 'newspack-elections' ),
				'newspack-elections-profile-row'        => __( 'Newspack Election Profile Rows', 'newspack-elections' ),
				'newspack-elections-profile-row-type'   => __( 'Newspack Election Profile Row Types', 'newspack-elections' ),
				'newspack-elections-profile-row-fields' => __( 'Newspack Election Profile Rows', 'newspack-elections' ),
				'newspack-elections-profile-fields'     => __( 'Newspack Election Profile Fields', 'newspack-elections' ),
			]
		);

		$this->block_editor()
			->pattern_categories()
				->add( 'newspack-elections', 'Newspack Elections' );

		$this->block_editor()
			->patterns()
				->set_default_category( 'newspack-elections' )
				->set_pattern_directory( $this->path( 'block-patterns' ) )
				->register_patterns();
		
		$this->block_editor()
			->block_templates()
				->register_from_file(
					'single-govpack_profiles',
					'single/single-govpack_profiles.html',
					[
						'title'       => __( 'Single Profile', 'newspack-elections' ),
						'description' => __( 'Output a single Election Profile.', 'newspack-elections' ),
						'post_types'  => [ 'govpack_profiles' ],
					] 
				);
	

		if ( is_admin() ) {
			$this->admin();
		}
		
		if ( ! is_admin() ) {
			$this->front_end();
		}
	}

	public function admin(): Admin {
		if ( ! isset( $this->admin ) ) {
			$this->admin = new Admin( $this );
			$this->admin->hooks();
		}

		return $this->admin;
	}


	public function block_editor(): BlockEditor {

		if ( ! isset( $this->block_editor ) ) {
			$this->block_editor = new BlockEditor( $this );
			$this->block_editor->hooks();
		}

		return $this->block_editor;
	}

	public function front_end(): FrontEnd {

		if ( ! isset( $this->front_end ) ) {
			$this->front_end = new FrontEnd( $this );
			$this->front_end->hooks();
			$this->front_end->template_loader();
		} 

		return $this->front_end;
	}

	public function blocks(): Blocks {

		if ( ! isset( $this->blocks ) ) {
			$this->register_blocks_supports();
			$this->blocks = new Blocks( $this );
			$this->blocks->hooks();
		}
		
		return $this->blocks;
	}

	public function icons(): Icons {

		if ( ! isset( $this->icons ) ) {
			$this->icons = new Icons( $this );
		}
		
		return $this->icons;
	}

	public function fields(): Fields {

		if ( ! isset( $this->fields ) ) {
			
			$this->fields = new Fields( $this );
		}
		
		return $this->fields;
	}

	public function register_blocks_supports() {
		BlockSupports\FieldAware::register();
	}

	public function register_blocks() {
		
		$this->blocks()->register( new \Govpack\Blocks\LegacyProfile( $this ) );
		$this->blocks()->register( new \Govpack\Blocks\LegacyProfileSelf( $this ) );

		$this->blocks()->register( new \Govpack\Blocks\Profile( $this ) );
		
		$this->blocks()->register( new \Govpack\Blocks\ProfileRowGroup( $this ) );
		$this->blocks()->register( new \Govpack\Blocks\ProfileRow( $this ) );
		$this->blocks()->register( new \Govpack\Blocks\ProfileSeparator( $this ) );

		$this->blocks()->register( new \Govpack\Blocks\ProfileBio( $this ) );
		$this->blocks()->register( new \Govpack\Blocks\ProfileName( $this ) ); 
		$this->blocks()->register( new \Govpack\Blocks\ProfileReadMore( $this ) ); 
		
		$this->blocks()->register( new \Govpack\Blocks\ProfileFieldText( $this ) );
		$this->blocks()->register( new \Govpack\Blocks\ProfileFieldLink( $this ) );
		$this->blocks()->register( new \Govpack\Blocks\ProfileFieldTerm( $this ) );
		$this->blocks()->register( new \Govpack\Blocks\ProfileFieldDate( $this ) );

		$this->blocks()->register( new \Govpack\Blocks\ProfileSocialLinks( $this ) ); 
		$this->blocks()->register( new \Govpack\Blocks\ProfileSocialLink( $this ) ); 
	}

	public function rest_api() {
		$field_types_controller = new \Govpack\Rest\FieldTypesRestController();
		$field_types_controller->register_routes();

		$fields_controller = new \Govpack\Rest\ProfileFieldsRestController();
		$fields_controller->register_routes();
	}
}

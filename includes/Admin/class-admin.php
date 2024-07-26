<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core\Admin;

use Govpack\Core\Capabilities;
use Govpack\Core\CPT\Profile;


use Exception;

/**
 * GovPack Admin Hooks
 */
class Admin {

	use \Govpack\Core\Instance;

	private $plugin;

	public function __construct($plugin){
		$this->plugin = $plugin;
	}
	/**
	 * Register Hooks for usage in wp-admin.
	 */
	public function hooks() {
		\add_action( 'admin_menu', [ '\Govpack\Core\Admin\Menu', 'add_taxonomy_submenus' ], 10, 1 );
		\add_action( 'admin_menu', [ $this, 'create_menus' ], 1, 1 );
		\add_action( 'admin_enqueue_scripts', [ __class__, 'register_assets' ], 100, 1 );
		\add_action( 'admin_enqueue_scripts', [ __class__, 'load_assets' ], 101, 1 );
		\add_action( 'block_categories_all', [ __class__, 'block_categories' ], 10, 2 );                
		\add_action( 'enqueue_block_editor_assets', [ __class__, 'enqueue_block_editor_assets' ] );
		\add_action( 'current_screen', [ __class__, 'conditional_hooks' ] );
		\add_action( 'after_setup_theme', [ '\Govpack\Core\Admin\Export', 'hooks' ], 11, 1 );
	}

	/**
	 * Register Block Assets.
	 */
	public static function enqueue_block_editor_assets() {

		
	}

	/**
	 * Callback that adds a Category to the Block Editor for Govpack
	 * 
	 * @param array $categories The existing Block Categories.
	 */
	public static function block_categories( $categories ) {
		return array_merge(
			$categories,
			[
				[
					'slug'  => 'govpack-blocks',
					'title' => \__( 'Govpack Blocks', 'govpack' ),
				],
			]
		);
	}
	
	/**
	 * Utility Function that redirects to Profiles archive.
	 */
	public static function redirect_to_profiles(){
		wp_redirect(admin_url( 'edit.php?post_type=' . Profile::CPT_SLUG ), 302);
	}

	/**
	 * Used to check if we're loaing the main "Govpack" page, redirect to the profile stable is we are.
	 */
	public static function conditional_hooks(){
		$screen = get_current_screen();
		

		if ( ! $screen ) {
			return;
		}

		switch ( $screen->base ) {
			case "toplevel_page_govpack":
				self::redirect_to_profiles();
				break;
			case "options-permalink";
				Permalink_Settings::hooks();
				break;
		}

		
		
	}

	public function get_menu_svg(){
		return '<svg width="153" height="213" viewBox="0 0 153 213" xmlns="http://www.w3.org/2000/svg">
	<path fill="rgba(240, 246, 252, 0.6)" clip-rule="evenodd" d="M68.6875 148.556C18.0258 148.556 0.4375 110.963 0.4375 76.2125C0.4375 26.4625 37.5625 0.400024 76.8125 0.400024C90.6717 0.400024 107.693 3.21878 116.562 10.5563V4.55628H152.563V156.556C152.563 166 139.438 212.713 76.5625 212.713C11.4332 212.713 4.5625 163.963 4.5625 160.556H48.5625C48.5625 165.9 59.6875 174.338 77.4375 174.338C98.1875 174.338 110.562 158.088 110.562 146.556V130.556C110.562 130.556 96.38 148.556 68.6875 148.556ZM82.4425 54.9375L63.255 24.6875L60.4425 62.9375L24.4425 72.9375L58.4425 86.9375V124.938C62.4884 120.213 83.6925 95.5 83.6925 95.5L118.442 108.938C118.442 108.938 103.546 86.0825 98.4425 78.9375V74.9375C98.0675 74.9375 120.442 46.9375 120.442 46.9375L82.4425 54.9375Z"/>
</svg>';
	}

	public function create_menu_svg(){
		return sprintf("data:image/svg+xml;base64,%s", base64_encode($this->get_menu_svg()));
	}
	/**
	 * Creates the Govpack Menu in the Dashboard Navigation
	 */
	public function create_menus() {

	
		$menu = new Menu();

		$menu->set_page_title( 'GovPack' )
			->set_menu_title( 'GovPack' )
			->set_menu_slug( 'govpack' )
			->set_icon($this->create_menu_svg())
			->set_callback(
				function() {
					// no call back as this should be redirected.
				}
			);

		$item = new Menu_Item();
		$menu->add_item(
			$item->set_page_title( 'Import' )
				->set_menu_title( 'Import' )
				->set_menu_slug( 'govpack_import' )
				->set_capability( Capabilities::CAN_IMPORT )
				->set_callback( [ '\Govpack\Core\Admin\Pages\Import', 'view' ] ) 
		);

		$item = new Menu_Item();
		$menu->add_item(
			$item->set_page_title( 'Export' )
				->set_menu_title( 'Export' )
				->set_menu_slug( 'govpack_export' )
				->set_capability( Capabilities::CAN_EXPORT )
				->set_callback( [ '\Govpack\Core\Admin\Pages\Export', 'view' ] ) 
		);

		$menu->create();
	}

	/**
	 * Register Govpack JS/CSS Assets for wp-admin 
	 */
	public static function register_assets() {

		

		$file = GOVPACK_PLUGIN_BUILD_PATH . 'admin.asset.php';

		if ( file_exists( $file ) ) {
			$asset_data = require_once $file; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingVariable
		}

		wp_register_style(
			'govpack-admin-style',
			GOVPACK_PLUGIN_BUILD_URL . 'admin.css',
			$asset_data['dependencies'] ?? '',
			$asset_data['version'] ?? '',
			"all"
		);

		wp_register_script(
			'govpack-admin-script',
			GOVPACK_PLUGIN_BUILD_URL . 'admin.js',
			$asset_data['dependencies'] ?? '',
			$asset_data['version'] ?? '',
			true
		);


		$file = GOVPACK_PLUGIN_BUILD_PATH . 'editor.asset.php';

		if ( file_exists( $file ) ) {
			$asset_data = require_once $file; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingVariable
		}

		wp_register_script(
			'govpack-editor',
			GOVPACK_PLUGIN_BUILD_URL . 'editor.js',
			$asset_data['dependencies'] ?? [],
			$asset_data['version'] ?? '',
			true
		);
		wp_register_style(
			'govpack-editor-style',
			GOVPACK_PLUGIN_BUILD_URL . 'editor.css',
			$asset_data['version'] ?? '',
			true
		);
	}

	/**
	 * Conditionally Enqueue JS/CSS Assets depending on wp_screen
	 */
	public static function load_assets() {
		\wp_enqueue_style( 'govpack-admin-style' );
		
		$screen = get_current_screen();

		if ( true === $screen->is_block_editor() && 'govpack_profiles' === $screen->post_type ) {
			
			\wp_enqueue_script( 'govpack-editor' );
			\wp_enqueue_style( 'govpack-editor-style' );
		}
	}
}


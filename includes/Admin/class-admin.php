<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core\Admin;

use Govpack\Core\Capabilities;
use Govpack\Core\CPT;


use Exception;

/**
 * GovPack Admin Hooks
 */
class Admin {

	/**
	 * Register Hooks for usage in wp-admin.
	 */
	public static function hooks() {
		\add_action( 'admin_menu', [ '\Govpack\Core\Admin\Menu', 'add_taxonomy_submenus' ], 10, 1 );
		\add_action( 'admin_menu', [ __class__, 'create_menus' ], 1, 1 );
		\add_action( 'admin_enqueue_scripts', [ __class__, 'register_assets' ], 100, 1 );
		\add_action( 'admin_enqueue_scripts', [ __class__, 'load_assets' ], 101, 1 );
		\add_action( 'block_categories_all', [ __class__, 'block_categories' ], 10, 2 );                
		\add_action( 'enqueue_block_editor_assets', [ __class__, 'enqueue_block_editor_assets' ] );

		\add_action( 'after_setup_theme', [ '\Govpack\Core\Admin\Export', 'hooks' ], 11, 1 );
	}


	public static function enqueue_block_editor_assets() {

		$screen = get_current_screen();

		wp_enqueue_script(
			'unregister-profile-self-block',
			plugin_dir_url( GOVPACK_PLUGIN_FILE ) . 'govpack/dist/profile_self_unregister_block.js',
			[ 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ]
		);

		wp_localize_script( 'unregister-profile-self-block', 'unregister_profile_self_block_data', [ 'current_post_type' => $screen->post_type ] );
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
	 * Creates the Govpack Menu in the Dashboard Navigation
	 */
	public static function create_menus() {

		

		$menu = new Menu();

		$menu->set_page_title( 'GovPack' )
			->set_menu_title( 'GovPack' )
			->set_menu_slug( 'govpack' )
			->set_callback(
				function() {
				
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

		$file = GOVPACK_PLUGIN_FILE . 'dist/admin.asset.php';

		if ( file_exists( $file ) ) {
			$asset_data = require_once $file; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingVariable
		}

		wp_register_style(
			'govpack-admin-style',
			GOVPACK_PLUGIN_ASSETS_URL . 'admin.css',
			$asset_data['dependencies'] ?? '',
			$asset_data['version'] ?? '',
			true
		);

		wp_register_script(
			'govpack-admin-script',
			GOVPACK_PLUGIN_ASSETS_URL . 'admin.js',
			$asset_data['dependencies'] ?? '',
			$asset_data['version'] ?? '',
			true
		);


		$file = GOVPACK_PLUGIN_FILE . 'dist/editor.asset.php';

		if ( file_exists( $file ) ) {
			$asset_data = require_once $file; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingVariable
		}

		wp_register_script(
			'govpack-editor',
			GOVPACK_PLUGIN_ASSETS_URL . 'editor.js',
			$asset_data['dependencies'] ?? [],
			$asset_data['version'] ?? '',
			true
		);
		wp_register_style(
			'govpack-editor-style',
			GOVPACK_PLUGIN_ASSETS_URL . 'editor.css',
			$asset_data['version'] ?? '',
			true
		);
	}

	/**
	 * Conditionally Enqueue JS/CSS Assets depending on wp_screen
	 */
	public static function load_assets() {
		
		$screen = get_current_screen();
		if ( 'edit-govpack_profiles' === $screen->id ) {
			\wp_enqueue_style( 'govpack-admin-style' );
		}

		if ( true === $screen->is_block_editor() && 'govpack_profiles' === $screen->post_type ) {
			\wp_enqueue_script( 'govpack-editor' );
			\wp_enqueue_style( 'govpack-editor-style' );
		}
	}
}


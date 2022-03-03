<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack;

defined( 'ABSPATH' ) || exit;

/**
 * Abstract class for registering and handling of blocks.
 */
abstract class Block {

	/**
	 * WordPress Hooks
	 */
	public static function hooks() {
		add_action( 'init', [ __CLASS__, 'register_script' ] );
		add_action( 'init', [ get_called_class(), 'register_block' ] );
	}

	/**
	 * Registers the common script for the blocks.
	 *
	 * @return void
	 */
	public static function register_script() {
		$file = GOVPACK_PLUGIN_FILE . 'dist/editor.asset.php';

		if ( file_exists( $file ) ) {
			$asset_data = require_once $file; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingVariable
		}

        /*
		wp_register_script(
			'govpack-editor',
			plugin_dir_url( GOVPACK_PLUGIN_FILE ) . 'govpack/dist/editor.js',
			$asset_data['dependencies'] ?? [],
			$asset_data['version'] ?? '',
			true
		);

        wp_register_style(
			'govpack-editor-style',
			plugin_dir_url( GOVPACK_PLUGIN_FILE ) . 'govpack/dist/editor.css',
			[],
			$asset_data['version'],
			"all"
		);
        
        */

        $file = GOVPACK_PLUGIN_FILE . 'dist/importer.asset.php';
        if ( file_exists( $file ) ) {
			$asset_data = require_once $file; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingVariable
		}

		wp_register_script(
			'govpack-importer',
			plugin_dir_url( GOVPACK_PLUGIN_FILE ) . 'govpack/dist/importer.js',
			$asset_data['dependencies'] ?? [],
			$asset_data['version'] ?? '',
			true
		);
	}

}

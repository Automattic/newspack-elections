<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\Block;

defined( 'ABSPATH' ) || exit;

/**
 * Register and handle the block.
 */
class Issue {

	/**
	 * WordPress Hooks
	 */
	public static function hooks() {
		add_action( 'init', [ __CLASS__, 'register' ] );
	}

	/**
	 * Registers the block and associated script
	 *
	 * @return void
	 */
	public static function register() {

		$file = GOVPACK_PLUGIN_FILE . 'dist/editor.asset.php';

		if ( file_exists( $file ) ) {
			$asset_data = require_once $file; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingVariable
		}

		wp_register_script(
			'govpack-editor',
			plugin_dir_url( GOVPACK_PLUGIN_FILE ) . 'govpack/dist/editor.js',
			$asset_data['dependencies'] ?? [],
			$asset_data['version'] ?? '',
			true
		);

		register_block_type(
			'govpack/issue',
			[
				'apiVersion'      => 2,
				'editor_script'   => 'govpack-editor',
				'render_callback' => [ '\Newspack\Govpack\CPT\Issue', 'shortcode_handler' ],
				'attributes'      => [
					'id'        => [
						'type'    => 'number',
						'default' => 0,
					],
					'className' => [
						'type' => 'string',
					],
					'format'    => [
						'type'    => 'string',
						'default' => \Newspack\Govpack\CPT\Issue::$default_issue_format,
					],
				],
			]
		);
	}

}

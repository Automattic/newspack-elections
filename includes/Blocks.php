<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack;

class Blocks {

	use PluginAware;

	private array $blocks = [];

	public function __construct( Govpack $plugin ) {
		$this->plugin( $plugin );
	}

	public function hooks(): void {
		add_action( 'init', [ $this, 'provide_register_blocks_hook' ], 99 );
		add_action( 'gp_register_blocks', [ $this, 'register_blocks' ] );
		add_action( 'enqueue_block_assets', [ $this, 'enqueue_block_assets' ] );
	}

	/**
	 * Register Block Assets.
	 */
	public function enqueue_block_assets(): void {
		

		$this->register_script( 'npe-editor', 'npe-editor' );
		wp_enqueue_script( 'npe-editor' );

		$this->register_script( 'npe-blocks', 'npe-blocks' );
		wp_enqueue_script( 'npe-blocks' );

		$this->register_style( 'npe-blocks-editor-style', 'npe-blocks' );
		wp_enqueue_style( 'npe-blocks-editor-style' );

		$this->register_style( 'npe-blocks-shared-styles', 'profile-shared-styles' );
	}

	public function register_style( $handle, $asset_name ) {

		wp_enqueue_style(
			$handle,
			$this->plugin->build_url( $asset_name . '.css' ),
			[],
			1
		);

		wp_style_add_data( $handle, 'path', $this->plugin->build_path( $asset_name . '.css' ) );
	}   

	public function register_script( $handle, $asset_name ) {
		$file = $this->plugin->build_path( $asset_name . '.asset.php' );
	

		if ( file_exists( $file ) ) {
			$asset_data = require $file; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingVariable
		}

		wp_register_script(
			$handle,
			$this->plugin->build_url( $asset_name . '.js' ),
			$asset_data['dependencies'] ?? '',
			$asset_data['version'] ?? '',
			true
		);
	}

	public function provide_register_blocks_hook(): void {
		do_action( 'gp_register_blocks' );
	}

	public function is_late_block_registration(): bool {
		// did_action returns the number of times ran, anything more than 0 should be true
		return ( did_action( 'gp_register_blocks' ) > 0 );
	}

	public function register( Abstracts\Block $block ): void {
		$this->blocks[ $block->block_name ] = $block;

		if ( $this->is_late_block_registration() ) {
			$this->handle_block_registration( $block );
		}
	}

	public function register_blocks(): void {
		foreach ( $this->blocks as $name => $block ) {
			$this->handle_block_registration( $block );
		}
	}

	public static function filter_server_side_block_meta_data( $settings, $metadata ) {
		unset( $settings['editor_script_handles'] );
		return $settings;
	}

	public function handle_block_registration( Abstracts\Block $block ): void {

		add_filter( 'block_type_metadata_settings', [ __CLASS__, 'filter_server_side_block_meta_data' ], 10, 2 );

		$block->hooks();
		$block->register();
		
		remove_filter( 'block_type_metadata_settings', [ __CLASS__, 'filter_server_side_block_meta_data' ], 10, 2 );
	}
}

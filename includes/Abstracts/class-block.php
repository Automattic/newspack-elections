<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core\Abstracts;

defined( 'ABSPATH' ) || exit;

/**
 * Abstract class for registering and handling of blocks.
 */
abstract class Block {

	protected \WP_Block_Type $block_type;

	public $block_name;

	/**
	 * WordPress Hooks
	 */
	public function hooks() {
		
		add_action( 'init', [ $this, 'register_script' ], 11 );
		add_action( 'wp_print_styles', [ $this, 'remove_view_styles' ], 10 );
		add_filter( 'allowed_block_types_all', [ $this, 'handle_disable_block' ], 99, 2 );
	}

	abstract public function disable_block( $allowed_blocks, $editor_context );

	abstract public function block_build_path(): string;

	/**
	 * Registers the block.
	 *
	 * @return void
	 */
	public function register() {

		$this->block_type = register_block_type(
			$this->block_build_path() . '/block.json',
			[
				'render_callback' => [ $this, 'render' ],
			]
		);
	}

	public function needs_view_assets_enqueued(): bool {
		return wp_is_block_theme();
	}

	public function remove_view_styles() {   

		if ( ! isset( $this->block_type ) ) {
			return;
		}

		if ( ! $this->needs_view_assets_enqueued() ) {
			foreach ( $this->block_type->style_handles as $handle ) {
				wp_dequeue_style( $handle );
			}
		}
	}

	public function handle_disable_block( $allowed_blocks, $editor_context ) {

		if ( ! $this->disable_block( $allowed_blocks, $editor_context ) ) {
			return $allowed_blocks;
		}

		if ( $allowed_blocks === true ) {
			$allowed_blocks = \WP_Block_Type_Registry::get_instance()->get_all_registered();
		}

		unset( $allowed_blocks[ $this->block_name ] );

		return array_keys( $allowed_blocks );
	}

	public function enqueue_view_assets() {

		if ( ! $this->needs_view_assets_enqueued() ) {
			return;
		}

		foreach ( $this->block_type->style_handles as $handle ) {
			if ( ! wp_style_is( $handle, 'enqueued' ) ) {
				wp_enqueue_style( $handle );
			}
		}
	}


	/**
	 * Registers the common script for the blocks.
	 *
	 * @return void
	 */
	public function register_script() {
	}


	/**
	 * Get the WP_Block Object.
	 *
	 * @param string $block_name Name of the block to get.
	 * @return \WP_Block
	 */
	public function get_block( $block_name ) {
		$block_registry = \WP_Block_Type_Registry::get_instance();
		$block          = $block_registry->get_registered( $block_name );
		return $block;
	}

	/**
	 * Get the WP_Block Object attributes.
	 *
	 * @param string $block_name Name of the block whos attributes to get.
	 * @return array
	 */
	public function get_block_attributes( $block_name ) {
	
		$block = $this->get_block( $block_name );
		return $block->attributes;
	}

	/**
	 * Get the WP_Block Object attributes as an array and attach the defaukt values to them.
	 *
	 * @param string $block_name Name of the block whos attributes to get.
	 * @return array
	 */
	public function get_block_attributes_with_default_values( $block_name ) {
	
		$block = self::get_block( $block_name );
	
		$block_attributes = array_merge(
			...array_map(
				function ( $key, $value ) {
					return [ $key => $value['default'] ?? false ];
				},
				array_keys( $block->attributes ),
				$block->attributes
			)
		);

		if ( ! isset( $block_attributes['className'] ) ) {
			$block_attributes['className'] = wp_get_block_default_classname( $block_name );
		}
		return $block_attributes;
	}
	
	/**
	 * Get the Block attributes and merge them to the defaults.
	 *
	 * @param string $block_name Name of the block whos attributes to get.
	 * @param array  $attributes Array of attributes from the blocks instance.
	 * @return array
	 */
	public function merge_attributes_with_block_defaults( $block_name, $attributes ) {
		$block_attributes = self::get_block_attributes_with_default_values( $block_name );
		return array_merge( $block_attributes, $attributes );
	}
}

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

	/**
	 * WordPress Hooks
	 */
	public function hooks() {
		
		add_action( 'init', [ $this, 'register_script' ], 11 );
		add_action( 'init', [ $this, 'register_block' ], 11 );
		add_action( 'init', [ $this, 'enqueue_front_end_assets' ], 11 );
	}

	/**
	 * Registers the common script for the blocks.
	 *
	 * @return void
	 */
	public abstract function register_script();

	/**
	 * Enqueue Front End Assets.
	 *
	 * @return void
	 */
	public abstract function enqueue_front_end_assets();

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
				function( $key, $value ) {
					return [ $key => $value['default'] ?? false ];
				},
				array_keys( $block->attributes ),
				$block->attributes
			)
		);

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

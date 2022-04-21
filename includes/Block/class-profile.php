<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Block;

defined( 'ABSPATH' ) || exit;

/**
 * Register and handle the block.
 */
class Profile extends \Govpack\Block {

	/**
	 * Registers the block.
	 *
	 * @return void
	 */
	public static function register_block() {

		\register_block_type(
			GOVPACK_PLUGIN_FILE . 'assets/js/src/editor/blocks/profile/block.json',
			[
				'render_callback' => [ '\Govpack\CPT\Profile', 'shortcode_handler' ],
			]
		);
	}

}

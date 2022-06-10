<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Block\ProfileSelf;

defined( 'ABSPATH' ) || exit;

/**
 * Register and handle the block.
 */
class ProfileSelf extends \Govpack\Abstracts\Block {

	/**
	 * Registers the block.
	 *
	 * @return void
	 */
	public static function register_block() {

		\register_block_type(
			GOVPACK_PLUGIN_FILE . 'assets/js/src/editor/blocks/profile-self/block.json',
			[
				'render_callback' => [ '\Govpack\CPT\Profile', 'shortcode_handler_self' ],
			]
		);
	}

}

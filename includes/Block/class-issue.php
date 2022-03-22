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
class Issue extends \Newspack\Govpack\Block {

	/**
	 * Registers the block.
	 *
	 * @return void
	 */
	public static function register_block() {

		/*
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
				],
			]
		);

		*/
	}

}

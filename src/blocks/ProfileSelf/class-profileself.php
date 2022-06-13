<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Blocks\ProfileSelf;

defined( 'ABSPATH' ) || exit;

/**
 * Register and handle the block.
 */
class ProfileSelf extends \Govpack\Blocks\Profile\Profile {

		/**
	 * Registers the block.
	 *
	 * @return void
	 */
	public static function register_block() {


		\register_block_type(
			__DIR__ . '/block.json',
			[
				'render_callback' => [ __class__, 'render' ],
			]
		);
	}

	public static function render( $attributes, $content = null ) {



		$attributes['profileId'] = get_queried_object_id();
		return self::load_block( 'govpack/profile-self', $attributes, $content, 'profile-self' );
	}

	
 
}	

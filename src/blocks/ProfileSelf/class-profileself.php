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

	/*
	public static function enqueue_front_end_assets( ) {

		add_action("enqueue_block_assets", [__class__, "enqueue_front_end_style"]);

	}
	
	public static function enqueue_front_end_style(){
		wp_register_style(
			"govpack-profile-self-style",
			GOVPACK_PLUGIN_ASSETS_URL . "profile_self_block.css",
			[],
			1.00,
			"screen"
		);
		wp_enqueue_style("govpack-profile-self-style");
	}
	*/
}	

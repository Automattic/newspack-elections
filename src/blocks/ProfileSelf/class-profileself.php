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

	public function block_build_path(){
		return trailingslashit(GOVPACK_PLUGIN_BUILD_PATH . 'blocks/ProfileSelf');
	}

		/**
		 * Registers the block.
		 *
		 * @return void
		 */
	public function register_block() {


		\register_block_type(
			$this->block_build_path() . '/block.json',
			[
				'render_callback' => [ __class__, 'render' ],
			]
		);
	}

	/**
	 * Renders the block.
	 *
	 * @param array  $attributes Attribues from the block.
	 * @param string $content contentf rom the block.
	 * @return string
	 */
	public function render( $attributes, $content = null ) {

		$attributes['profileId'] = get_queried_object_id();
		return self::load_block( 'govpack/profile-self', $attributes, $content, 'profile-self' );
	}

	public function disable_block( $allowed_blocks, $editor_context ){

		if($editor_context->post->post_type !== "govpack_profile"){
			return $allowed_blocks;
		}
		
		unset($allowed_blocks["govpack/profile-self"]);

		return $allowed_blocks;
	}

}   

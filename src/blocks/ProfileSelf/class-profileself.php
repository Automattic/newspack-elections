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

	public $block_name = 'govpack/profile-self';
	public $template   = 'profile-self';

	public function block_build_path(): string {
		return trailingslashit( GOVPACK_PLUGIN_BUILD_PATH . 'blocks/ProfileSelf' );
	}

	/**
	 * Renders the block.
	 *
	 * @param array  $attributes Attribues from the block.
	 * @param string $content contentf rom the block.
	 * @return string
	 */
	public function render( $attributes, $content = null, $block = null ) {

		$attributes['profileId'] = get_queried_object_id();

		
		return $this->handle_render( $attributes, $content, $block );
	}

	public function disable_block( $allowed_blocks, $editor_context ) {
		return false;
	}
}   

<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Blocks;

defined( 'ABSPATH' ) || exit;

/**
 * Register and handle the block.
 */
class LegacyProfileSelf extends \Govpack\Blocks\LegacyProfile {

	public string $block_name = 'govpack/profile-self';
	public $template          = 'profile-self';


	public function block_build_path(): string {
		return $this->plugin->build_path( 'blocks/LegacyProfileSelf' );
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

	/**
	 * Enqueues this block's styles plus the Profile block's, which the single profile markup also uses.
	 *
	 * Runs on every theme type on purpose: classic themes dequeue these handles in the head
	 * (see remove_view_styles()), and this render-time enqueue restores them.
	 *
	 * @return void
	 */
	public function enqueue_view_assets(): void {
		parent::enqueue_view_assets();

		$profile_block = \WP_Block_Type_Registry::get_instance()->get_registered( 'govpack/profile' );

		if ( ! $profile_block ) {
			return;
		}

		foreach ( $profile_block->style_handles as $handle ) {
			wp_enqueue_style( $handle );
		}
	}

	public function disable_block( $allowed_blocks, $editor_context ): bool {
		return false;
	}
}   

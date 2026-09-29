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

	/**
	 * Block name.
	 *
	 * @var string
	 */
	public string $block_name = 'govpack/profile-self';

	/**
	 * Template part used to render the block.
	 *
	 * @var string
	 */
	public $template = 'profile-self';

	/**
	 * Path to the block's build directory.
	 *
	 * @return string
	 */
	public function block_build_path(): string {
		return $this->plugin->build_path( 'blocks/LegacyProfileSelf' );
	}

	/**
	 * Renders the block.
	 *
	 * @param array    $attributes Attribues from the block.
	 * @param string   $content contentf rom the block.
	 * @param WP_Block $block The block being rendered.
	 * @return string
	 */
	public function render( $attributes, $content = null, $block = null ) {

		$attributes['profileId'] = get_queried_object_id();

		
		return $this->handle_render( $attributes, $content, $block );
	}

	/**
	 * Enqueues this block's styles plus the Profile block's, which the single profile markup also uses.
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

	/**
	 * Keeps the block available in the editor.
	 *
	 * @param bool|array               $allowed_blocks Allowed block types.
	 * @param \WP_Block_Editor_Context $editor_context Current editor context.
	 * @return bool
	 */
	public function disable_block( $allowed_blocks, $editor_context ): bool {
		return false;
	}
}   

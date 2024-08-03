<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Blocks\Profile;

use WP_Block;

defined( 'ABSPATH' ) || exit;

/**
 * Register and handle the block.
 */
class Profile extends \Govpack\Core\Abstracts\Block {

	public $block_name = "govpack/profile";
	public $template = "profile";


	public function disable_block( $allowed_blocks, $editor_context ){
		return false;
	}


	public function block_build_path() : string {
		return trailingslashit(GOVPACK_PLUGIN_BUILD_PATH . 'blocks/Profile');
	}
	
	

	/**
	 * Shortcode handler for [govpack].
	 *
	 * @param array  $attributes    Array of shortcode attributes.
	 * @param string $content Post content.
	 * @param WP_Block $block Reference to the block being rendered .
	 *
	 * @return string HTML for the block.
	 */
	public function render( array $attributes, ?string $content = null, ?WP_Block $block = null ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable

		if ( ! $attributes['profileId'] ) {
			return;
		}

		if ( \is_admin() ) {
			return false;
		}


		return $this->handle_render( $attributes, $content, $block );
	}

	/**
	 * Loads a block from display on the frontend/via render.
	 *
	 * @param array  $attributes array of block attributes.
	 * @param string $content Any HTML or content redurned form the block.
	 * @param WP_Block $template The filename of the template-part to use.
	 */
	public function handle_render(array $attributes, string $content, WP_Block $block ) {

		
		
		$profile = \Govpack\Core\CPT\Profile::get_data( $attributes['profileId'] );
	
		if ( ! $profile ) {
			return;
		}

		$this->enqueue_view_assets();

	
		return gp_template_loader()->render_block(
			$this->template(),
			self::merge_attributes_with_block_defaults( $this->block_name, $attributes ), 
			$content, 
			$block, 
			[
				"profile_block" => $this,
				"profile_data" => $profile
			] 
		);

	}

	public function template() : string {
		return sprintf("blocks/%s", $this->template);
	}

}

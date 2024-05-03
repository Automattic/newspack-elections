<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Blocks\Profile;

use WP_Block_Type;

defined( 'ABSPATH' ) || exit;

/**
 * Register and handle the block.
 */
class Profile extends \Govpack\Core\Abstracts\Block {

	public $block_name = "profile";


	public function register_script(){
	}

	public function disable_block( $allowed_blocks, $editor_context ){
		return false;
	}


	public function block_build_path(){
		return trailingslashit(GOVPACK_PLUGIN_BUILD_PATH . 'blocks/Profile');
	}
	/**
	 * Registers the block.
	 *
	 * @return void
	 */
	public function register() {

		$this->block = register_block_type(
			$this->block_build_path() . '/block.json',
			[
				'render_callback' => [ $this, 'render' ],
			]
		);

	}

	

	/**
	 * Shortcode handler for [govpack].
	 *
	 * @param array  $attributes    Array of shortcode attributes.
	 * @param string $content Post content.
	 *
	 * @return string HTML for recipe shortcode.
	 */
	public function render( $attributes, $content = null ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable

		if ( ! $attributes['profileId'] ) {
			return;
		}

		return self::load_block( 'govpack/profile', $attributes, $content, 'profile' );
	}

	/**
	 * Loads a block from display on the frontend/via render.
	 *
	 * @param string $block_name the name(or slug) of the block being output.
	 * @param array  $attributes array of block attributes.
	 * @param string $content Any HTML or content redurned form the block.
	 * @param string $template The filename of teh template-part to use.
	 */
	public  function load_block( $block_name, $attributes, $content, $template ) {

		if ( \is_admin() ) {
			return false;
		}

		$profile_data = \Govpack\Core\CPT\Profile::get_data( $attributes['profileId'] );
	
		if ( ! $profile_data ) {
			return;
		}       

		
		$this->enqueue_view_assets();
		$attributes = self::merge_attributes_with_block_defaults( $block_name, $attributes );
		$template_name = "blocks/" . $template;
		return gp_template_loader()->render_block($template_name, null, $attributes, $content, null, ["profile_data" => $profile_data] );

	}

}

<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Blocks;

use WP_Block;

defined( 'ABSPATH' ) || exit;

/**
 * Register and handle the block.
 */
class ProfileName extends \Govpack\Blocks\ProfileFieldText {

	public string $block_name = 'npe/profile-name';
	public $field_type        = 'block';
	

	public function block_build_path(): string {
		return $this->plugin->build_path( 'blocks/ProfileName' );
	}

	/**
	 * Loads a block from display on the frontend/via render.
	 *
	 * @param array  $attributes array of block attributes.
	 * @param string $content Any HTML or content redurned form the block.
	 * @param WP_Block $template The filename of the template-part to use.
	 */
	public function handle_render( array $attributes, string $content, WP_Block $block ) {
		
		$tag_name = $this->get_wrapper_tag();
		
		$block_html = sprintf(
			'<%s %s>%s</%s>', 
			$tag_name,
			get_block_wrapper_attributes(),
			$this->output(),
			$tag_name
		);

		echo wp_kses_post( $block_html );
	}

	public function output(): string {

		// The name is text on both paths; escape it here so the anchor below
		// is assembled from escaped operands rather than relying on kses.
		$name = esc_html( parent::output() );

		if ( ! $this->attribute( 'isLink' ) ) {
			return $name;
		}

		// Great an array of html attributes for the link
		$link_attrs = [
			'target' => $this->attribute( 'linkTarget' ),
			'href'   => esc_url( $this->get_profile()->permalink() ),
		];

		if ( $this->attribute( 'rel' ) ) {
			$link_attrs['rel'] = $this->attribute( 'rel' );
		}

		return sprintf( '<a %s>%s</a>', self::array_to_html_attributes( $link_attrs ), $name );
	}

	

	public function get_wrapper_tag(): string {
		$level = $this->attribute( 'level' );

		if ( $level === 0 ) {
			return 'p';
		}

		return sprintf( 'h%d', $level );
	}

	public function variations(): array {
		return [];
	}
}

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
class ProfileReadMore extends \Govpack\Blocks\ProfileFieldText {

	public string $block_name = 'npe/profile-read-more';
	public $field_type        = 'block';
	

	public function block_build_path(): string {
		return $this->plugin->build_path( 'blocks/ProfileReadMore' );
	}

	public function show_block(): bool {
		return true;
	}
	/**
	 * Loads a block from display on the frontend/via render.
	 *
	 * @param array  $attributes array of block attributes.
	 * @param string $content Any HTML or content redurned form the block.
	 * @param WP_Block $template The filename of the template-part to use.
	 */
	public function handle_render( array $attributes, string $content, WP_Block $block ) {
		
		$tag_name = 'div';
		
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
		
		// Great an array of html attributes for the link
		$link_attrs = [
			'target' => $this->attribute( 'linkTarget' ),
			'href'   => esc_url( $this->get_profile()->permalink() ),
		];

		if ( $this->attribute( 'rel' ) ) {
			$link_attrs['rel'] = $this->attribute( 'rel' );
		}

		$link_text = esc_html( $this->attribute( 'linkText' ) ?? '' );
		$prefix    = $this->attribute( 'prefixWithName' ) ? esc_html( $this->get_profile()->value( 'name' ) ) : '';
		$suffix    = $this->attribute( 'suffixWithName' ) ? esc_html( $this->get_profile()->value( 'name' ) ) : '';
		$link_text = trim( sprintf( '%s %s %s', $prefix, $link_text, $suffix ) );
		

		return sprintf( '<a %s>%s</a>', self::array_to_html_attributes( $link_attrs ), $link_text );
	}

	


	public function variations(): array {
		return [];
	}
}

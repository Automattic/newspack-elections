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
class Profile extends \Govpack\Blocks\LegacyProfile {

	public string $block_name = 'npe/profile';
	public $template          = 'profile';

	private $show         = null;
	private $profile      = null;
	public $attributes = [];
	protected $plugin;

	public function __construct( $plugin ) {

		$this->plugin = $plugin;
		//add_filter( 'render_block_context', [$this, 'modify_context'], 10, 3);
		//add_filter( 'render_block_data', [$this, 'modify_block_data'], 10, 3);
		add_filter( 'pre_render_block', [ $this, 'pre_render_block' ], 10, 3 );
	}

	public function pre_render_block( $pre_render, $parsed_block, $parent_block ) {
		global $post;

		if ( is_null( $pre_render ) && ( isset( $parsed_block['attrs']['postId'] ) ) ) {
			$new_post = get_post( $parsed_block['attrs']['postId'] );
			if ( ! is_null( $new_post ) ) {
				$post = $new_post;
			}
		}

		return $pre_render;
	}

	public function modify_block_data( $parsed_block, $source_block, $parent_block ) {

		if ( $parsed_block['blockName'] !== $this->block_name ) {
			return $parsed_block;
		}

		if ( ! isset( $parsed_block['attrs'] ) || empty( $parsed_block['attrs'] ) ) {
			return $parsed_block;
		}

		if ( ! isset( $parsed_block['attrs']['profileId'] ) || empty( $parsed_block['attrs']['profileId'] ) ) {
			return $parsed_block;
		}

		if ( isset( $parsed_block['attrs']['postId'] ) ) {
			return $parsed_block;
		}

		$parsed_block['attrs']['postId'] = $parsed_block['attrs']['profileId'];


		return $parsed_block;
	}

	public function modify_context( $context, $parsed_block, $parent_block ) {

		if ( $parsed_block['blockName'] !== $this->block_name ) {
			return $context;
		}

		return $context;
	}

	public function disable_block( $allowed_blocks, $editor_context ): bool {
		return false;
	}

	public function block_build_path(): string {
		return $this->plugin->build_path( 'blocks/Profile' );
	}

	public function filter_kses_for_svg($tags, $context){
		if($context !== "post"){
			return $tags;
		}

		$tags = \array_merge($tags, [
			'svg'      => [
				'xmlns'   => [],
				'width'   => [],
				'height'  => [],
				'viewbox' => [], //lowercase not camelcase!
			],
			'path'     => [
				'd' => [],
			],
			'g'        => [
				'path' => [],
			],
			'defs'     => [],
			'clippath' => []]
		);

		return $tags;
	}
	private function allow_svg_in_wp_kses(){
		add_filter( 'wp_kses_allowed_html', [$this, 'filter_kses_for_svg'], 10, 2 );
	}

	private function restore_original_wp_kses(){
		remove_filter( 'wp_kses_allowed_html', [$this, 'filter_kses_for_svg'], 10, 2 );
	}
	/**
	 * Block render handler for .
	 *
	 * @param array  $attributes    Array of shortcode attributes.
	 * @param string $content Post content.
	 * @param WP_Block $block Reference to the block being rendered .
	 *
	 * @return string HTML for the block.
	 */
	public function render( array $attributes, ?string $content = null, ?WP_Block $block = null ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable

		global $post;
		if ( \is_admin() ) {
			return false;
		}

		if (isset($attributes['postId']) && ($attributes['postId'] ) ) {
			$this->profile = \Govpack\Profile\Profile::get( $attributes["postId"] );
		} else if($post->post_type = "govpack_profiles") {
			$this->profile = \Govpack\Profile\Profile::get( $post->ID );
		}

		if ( ! $this->profile ) {
			return;
		}

		$this->allow_svg_in_wp_kses();

		$this->attributes = self::merge_attributes_with_block_defaults( $this->block_name, $attributes );
		$this->enqueue_view_assets();

		ob_start();
		$this->handle_render( $attributes, $content, $block );
		wp_reset_postdata();
		$this->restore_original_wp_kses();
		return \ob_get_clean();
	}


	/**
	 * Loads a block from display on the frontend/via render.
	 *
	 * @param array  $attributes array of block attributes.
	 * @param string $content Any HTML or content redurned form the block.
	 * @param WP_Block $template The filename of the template-part to use.
	 */
	public function handle_render( array $attributes, string $content, WP_Block $block ) {

		$tag_name = $this->attributes['tagName'] ?? 'div';

		$block_html = sprintf(
			'<%s %s>%s</%s>',
			$tag_name,
			get_block_wrapper_attributes(
				$this->get_new_block_wrapper_attributes()
			),
			//sprintf('<div class="profile-inner">%s</div>', $content),
			$content,
			$tag_name
		);

		echo  wp_kses_post($block_html);
	}



	public function template(): string {
		return sprintf( 'blocks/%s', $this->template );
	}

	public function get_new_block_wrapper_attributes(): array {
		$new_attrs = [];
		$styles    = [];
		$classes   = [];


		if ( isset( $this->attributes['align'] ) && $this->attributes['customWidth'] ) {

			$styles['max-width'] = $this->attributes['customWidth'];
		}

		if ( ! empty( $styles ) ) {
			$new_attrs['style'] = trim(
				implode(
					' ',
					array_map(
						function ( $rule, $value ) {
							return sprintf( '%s: %s;', $rule, $value );
						},
						array_keys( $styles ),
						array_values( $styles )
					)
				)
			);
		}

		$classes = apply_filters( 'newspack_elections_profile_block_classes', $this->get_wrapper_classes() );

		if ( ! empty( $classes ) ) {
			$new_attrs['class'] = trim( implode( ' ', $classes ) );
		}

		return $new_attrs;
	}

	public function get_wrapper_classes(): array {

		$classes   = [];
		$classes[] = sprintf( 'profile-%s', $this->attributes['postId'] );

		if(isset($this->attributes['verticalAlignment']) && ($this->attributes['verticalAlignment'])){
			$classes[] = sprintf(  "is-vertically-aligned-%s",  $this->attributes['verticalAlignment'] );
		}

		return $classes;
	}
}

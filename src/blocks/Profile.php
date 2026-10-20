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

	/**
	 * Posts that were global before each profile block swapped itself in, most recent last.
	 *
	 * @var array<int, \WP_Post|null>
	 */
	private $previous_posts = [];

	public function __construct( $plugin ) {

		$this->plugin = $plugin;
		//add_filter( 'render_block_context', [$this, 'modify_context'], 10, 3);
		//add_filter( 'render_block_data', [$this, 'modify_block_data'], 10, 3);
		add_filter( 'render_block_data', [ $this, 'swap_global_post' ], 10, 1 );
		add_filter( 'render_block_' . $this->block_name, [ $this, 'restore_global_post' ], 10, 1 );
	}

	/**
	 * Make the profile the global post while this block renders.
	 *
	 * Hooked to render_block_data rather than pre_render_block because core only applies it once the block is
	 * certain to render, so every save here is matched by the restore in restore_global_post(). The current post is
	 * saved even when there is no profile to swap in, so each block's restore takes back only its own entry.
	 *
	 * @param array $parsed_block The block being rendered.
	 * @return array
	 */
	public function swap_global_post( $parsed_block ) {
		global $post;

		if ( $this->block_name !== $parsed_block['blockName'] ) {
			return $parsed_block;
		}

		$this->previous_posts[] = $post;

		$new_post = isset( $parsed_block['attrs']['postId'] ) ? get_post( $parsed_block['attrs']['postId'] ) : null;
		if ( ! is_null( $new_post ) ) {
			$post = $new_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		}

		return $parsed_block;
	}

	/**
	 * Put back the post that was global before this profile block rendered.
	 *
	 * This runs after WP_Block::render() restores the post it saved before the render callback, which is already the
	 * profile, so restoring here is what stops the profile leaking into anything rendered after the block content.
	 *
	 * @param string $block_content The rendered block.
	 * @return string
	 */
	public function restore_global_post( $block_content ) {
		global $post;

		if ( ! empty( $this->previous_posts ) ) {
			$post = array_pop( $this->previous_posts ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		}

		return $block_content;
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
		} else if( $post instanceof \WP_Post && $post->post_type === "govpack_profiles" ) {
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

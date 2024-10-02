<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core;

/**
 *
 */
class Block_Patterns {
	/**
	 * Initialize hooks.
	 */
	public static function init() {
		add_action( 'admin_init', [ __CLASS__, 'register_block_patterns' ] );
	}

	/**
	 * Get block patterns.
	 *
	 * Each pattern content should be a PHP file in the block-patterns directory
	 * named after the pattern slug.
	 *
	 * @return array
	 */
	public static function get_block_patterns() {
		return [
			'home-pre-results-ap'    => __( 'Homepage Pre-Results Module — AP', 'newspack-elections' ),
			'home-results-ap'        => __( 'Homepage Results Module — AP', 'newspack-elections' ),
			'live-results-post-ap'   => __( 'Live Election Results Post — AP', 'newspack-elections' ),
			'home-pre-results-ddhq'  => __( 'Homepage Pre-Results Module — DDHQ', 'newspack-elections' ),
			'home-results-ddhq'      => __( 'Homepage Results Module — DDHQ', 'newspack-elections' ),
			'live-results-post-ddhq' => __( 'Live Election Results Post — DDHQ', 'newspack-elections' ),
		];
	}

	/**
	 * Register block patterns.
	 */
	public static function register_block_patterns() {
		\register_block_pattern_category( 'newspack-elections', [ 'label' => __( 'Newspack Elections', 'newspack-elections' ) ] );
		$patterns = self::get_block_patterns();
		foreach ( $patterns as $slug => $title ) {
			$path = plugin_dir_path( __DIR__ ) . 'src/block-patterns/' . $slug . '.php';
			if ( ! file_exists( $path ) ) {
				continue;
			}
			ob_start();
			require $path;
			$content = ob_get_clean();
			if ( empty( $content ) ) {
				continue;
			}
			\register_block_pattern(
				'newspack-elections/' . $slug,
				[
					'categories'  => [ 'newspack-elections' ],
					'title'       => $title,
					'description' => _x( 'Help format and provide context to AP and DDHQ elections embeds.', 'Block pattern description', 'newspack-elections' ),
					'content'     => $content,
				]
			);
		}
	}
}
Block_Patterns::init();
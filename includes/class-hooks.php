<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack;

/**
 * WordPress filters and actions.
 */
class Hooks {
	/**
	 * Set up actions and filters.
	 */
	public static function setup_hooks() {
		// Enqueue CSS and JS.
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'wp_enqueue_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ __CLASS__, 'admin_enqueue_scripts' ] );
		add_filter( 'single_template', [ __CLASS__, 'single_template' ] );
	}

	/**
	 * Enqueue frontend scripts and styles.
	 */
	public static function wp_enqueue_scripts() {
		$type = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? 'src' : 'min';

		wp_enqueue_script( 'main', plugins_url( "assets/js/main.{$type}.js", __DIR__ ), [], GOVPACK_VERSION, true );
		wp_enqueue_style( 'main', plugins_url( "assets/css/main.{$type}.css", __DIR__ ), [], GOVPACK_VERSION );
	}

	/**
	 * Enqueue backend scripts and styles.
	 *
	 * @param string $hook The current admin page.
	 */
	public static function admin_enqueue_scripts( $hook ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		$type = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? 'src' : 'min';

		wp_enqueue_style( 'admin', plugins_url( "assets/css/admin.{$type}.css", __DIR__ ), [], GOVPACK_VERSION );
		wp_enqueue_script( 'admin', plugins_url( "assets/js/admin.{$type}.js", __DIR__ ), [ 'jquery', 'underscore', 'wp-util' ], GOVPACK_VERSION, false );
	}

	/**
	 * Add custom image sizes for this theme.
	 */
	public static function set_image_sizes() {
		add_image_size( 'govpack-square', 140, 140, true );
	}

	/**
	 * Set template for profile page.
	 *
	 * @param string $template The current template path.
	 */
	public static function single_template( $template ) {
		global $post;

		if ( \Newspack\Govpack\CPT\Profile::CPT_SLUG === $post->post_type && locate_template( [ 'single-' . \Newspack\Govpack\CPT\Profile::CPT_SLUG . '.php' ] ) !== $template ) {
			return plugin_dir_path( __DIR__ ) . 'template-parts/single-' . \Newspack\Govpack\CPT\Profile::CPT_SLUG . '.php';
		}

		return $template;
	}
}

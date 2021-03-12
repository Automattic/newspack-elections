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
	}

	/**
	 * Enqueue frontend scripts and styles.
	 */
	public static function wp_enqueue_scripts() {
		$type = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? 'src' : 'min';

		wp_enqueue_script( 'main', plugins_url( "assets/js/main.{$type}.js", __DIR__ ), [], GOVPACK_VERSION, true );
		wp_enqueue_style( 'main', plugins_url( "assets/css/govpack.{$type}.css", __DIR__ ), [], GOVPACK_VERSION );
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
		add_image_size( 'govpack-square', 200, 200, true );
	}
}

add_action( 'after_setup_theme', [ '\Newspack\Govpack\Hooks', 'setup_hooks' ] );
add_action( 'after_setup_theme', [ '\Newspack\Govpack\Hooks', 'set_image_sizes' ] );

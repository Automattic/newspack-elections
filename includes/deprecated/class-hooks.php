<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack;

/**
 * WordPress filters and actions.
 */
class Hooks {
	/**
	 * Set up actions and filters.
	 */
	public static function setup_hooks() {


		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'wp_enqueue_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ __CLASS__, 'admin_enqueue_scripts' ] );
		add_filter( 'single_template', [ __CLASS__, 'single_template' ] );
		add_filter( 'wpseo_accessible_post_types', [ __CLASS__, 'wpseo_accessible_post_types' ] );
		add_action( 'init', [ __CLASS__, 'register_sidebars' ] );
		add_action( 'admin_notices', [ __CLASS__, 'admin_notices' ] );

	 

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

		$slugs = [
			\Govpack\Core\CPT\Profile::CPT_SLUG,
		];

		if ( in_array( $post->post_type, $slugs, true ) && locate_template( [ 'single-govpack.php' ] ) !== $template ) {
			return plugin_dir_path( __DIR__ ) . 'template-parts/single-govpack.php';
		}

		return $template;
	}

	/**
	 * Disable the Yoast SEO metabox on Govpack Profiles and Issues.
	 *
	 * @param array $post_types Post types registered with Yoast SEO.
	 */
	public static function wpseo_accessible_post_types( $post_types ) {
		unset( $post_types[ \Govpack\Core\CPT\Profile::CPT_SLUG ] );
		return $post_types;
	}

	/**
	 * Register Sidebars
	 */
	public static function register_sidebars() {
		$sidebars = [
			\Govpack\Core\CPT\Profile::CPT_SLUG => 'Govpack Profile',
		];

		foreach ( $sidebars as $slug => $name ) {
			register_sidebar(
				[
					'name'          => $name,
					'id'            => $slug,
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h2 class="widget-title">',
					'after_title'   => '</h2>',
				]
			);
		}
	}


}

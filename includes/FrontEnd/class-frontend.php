<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core\FrontEnd;

use Exception;
use Govpack\Core\TemplateLoader;

/**
 * GovPack FrontEnd Hooks
 */
class FrontEnd {

	/**
	 * Stores static instance of class.
	 *
	 * @access protected
	 * @var Govpack\Govpack The single instance of the class
	 */
	protected static $instance = null;

	/**
	 * Returns static instance of class.
	 *
	 * @return self
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Stores  instance of TemplateLoader.
	 *
	 * @access protected
	 * @var Govpack\TemplateLoader The single instance of the class
	 */

	private TemplateLoader $template_loader;

	/**
	 * Adds Hooks Specifically for the Frontend display
	 */
	public function hooks() {
		add_filter( 'newspack_can_show_post_thumbnail', [ __CLASS__, 'newspack_can_show_post_thumbnail' ], 10, 1 );
		add_action( 'enqueue_block_assets', [ __CLASS__, 'enqueue_front_end_style' ] );

		add_action( 'govpack_before_main_content', [ $this, 'output_wrapper_start' ] );
		add_action( 'govpack_after_main_content', [ $this, 'output_wrapper_end' ] );
		add_action( 'govpack_sidebar', [ $this, 'output_sidebar' ] );
	}

	public function output_sidebar() {
		return gp_get_template_part( 'global/sidebar' );
	}

	public function output_wrapper_start() {
		return gp_get_template_part( 'global/wrapper-start' );
	}

	public function output_wrapper_end() {
		return gp_get_template_part( 'global/wrapper-end' );
	}

	public function template_loader() {

		if ( ! isset( $this->template_loader ) ) {
			$this->template_loader = new TemplateLoader();
			$this->template_loader->hooks();
		}

		return $this->template_loader;
	}

	

	/**
	 * Enqueue Front End Style
	 */
	public static function enqueue_front_end_style() {

		wp_register_style(
			'govpack-block-styles',
			GOVPACK_PLUGIN_BUILD_URL . 'frontend.css',
			[],
			1.00,
			'screen'
		);
		wp_enqueue_style( 'govpack-block-styles' );
	}


	/**
	 * Filter newspack Templates to show thumbnails
	 * 
	 * @param boolean $use_post_thumbnail Value to filter.
	 */
	public static function newspack_can_show_post_thumbnail( $use_post_thumbnail ) {
		global $post;

		if ( 'govpack_profiles' === $post->post_type ) {
			return false;
		}
	
		return $use_post_thumbnail;
	}

	/**
	 * If a profile is loaded with no content present then load the profile block instead
	 * 
	 * @param string $the_content profile Content to filter.
	 */
	public static function maybe_inject_profile_block( $the_content ) {
		
		if ( '' !== $the_content ) {
			return $the_content;
		}
	
		return \Govpack\Core\CPT\Profile::default_profile_content();
	}
}

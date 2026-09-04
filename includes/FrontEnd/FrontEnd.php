<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\FrontEnd;

use Exception;
use Govpack\TemplateLoader;
use Govpack\PluginAware;
use Govpack\Abstracts\Plugin;
/**
 * GovPack FrontEnd Hooks
 */
class FrontEnd {

	use PluginAware;

	/**
	 * Stores static instance of class.
	 *
	 * @access protected
	 * @var self The single instance of the class
	 */
	protected static object|null $instance = null;

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
	 * @var \Govpack\TemplateLoader The single instance of the class
	 */

	private TemplateLoader $template_loader;


	public function __construct(Plugin $plugin)
	{
		$this->plugin($plugin);
	}

	/**
	 * Adds Hooks Specifically for the Frontend display
	 */
	public function hooks(): void {
		add_filter( 'newspack_can_show_post_thumbnail', [ __CLASS__, 'newspack_can_show_post_thumbnail' ], 10, 1 );
		add_filter( 'body_class', [ __CLASS__, 'body_class' ] );
		add_filter( 'newspack_listings_hide_author', [ __CLASS__, 'hide_author' ] );
		add_filter( 'newspack_listings_hide_publish_date', [ __CLASS__, 'hide_publish_date' ] );
		add_action( 'enqueue_block_assets', [ $this, 'enqueue_front_end_style' ], 10, 0 );

		add_action( 'govpack_before_main_content', [ $this, 'output_wrapper_start' ] );
		add_action( 'govpack_after_main_content', [ $this, 'output_wrapper_end' ] );
		add_action( 'govpack_sidebar', [ $this, 'output_sidebar' ] );
	}

	public function output_sidebar(): string {
		return gp_get_template_part( 'global/sidebar' );
	}

	public function output_wrapper_start(): string {
		return gp_get_template_part( 'global/wrapper-start' );
	}

	public function output_wrapper_end(): string {
		return gp_get_template_part( 'global/wrapper-end' );
	}

	public function template_loader(): TemplateLoader {

		if ( ! isset( $this->template_loader ) ) {
			$this->template_loader = new TemplateLoader($this->plugin);
			$this->template_loader->hooks();
		}

		return $this->template_loader;
	}

	

	/**
	 * Enqueue Front End Style
	 */
	public function enqueue_front_end_style(): void {

		wp_register_style(
			'govpack-block-styles',
			$this->plugin->build_url('frontend.css'),
			[],
			'1.00',
			'screen'
		);
		wp_enqueue_style( 'govpack-block-styles' );
	}


	/**
	 * Alias the page-template body class to the one Newspack's themes style.
	 *
	 * Their CSS keys on `post-template-*`; WordPress emits
	 * `govpack_profiles-template-*`. Newspack Listings aliases the same.
	 *
	 * @param string[] $classes Body classes.
	 * @return string[]
	 */
	public static function body_class( array $classes ): array {

		if ( ! is_singular( \Govpack\Profile\CPT::CPT_SLUG ) ) {
			return $classes;
		}

		$template = get_page_template_slug();

		if ( 'single-feature.php' === $template ) {
			$classes[] = 'post-template-single-feature';
		} elseif ( 'single-wide.php' === $template ) {
			$classes[] = 'post-template-single-wide';
		}

		return $classes;
	}

	/**
	 * Hide the publish date on a profile.
	 *
	 * The date records when the profile was entered, not anything about its
	 * subject.
	 *
	 * @param bool $hide Whether the date is hidden.
	 * @return bool
	 */
	public static function hide_publish_date( $hide ): bool {

		if ( \Govpack\Profile\CPT::CPT_SLUG === get_post_type() ) {
			return true;
		}

		return (bool) $hide;
	}

	/**
	 * Hide the byline and author bio on a profile.
	 *
	 * A profile's author is whoever entered the record, not its subject.
	 *
	 * @param bool $hide Whether the author is hidden.
	 * @return bool
	 */
	public static function hide_author( $hide ): bool {

		if ( \Govpack\Profile\CPT::CPT_SLUG === get_post_type() ) {
			return true;
		}

		return (bool) $hide;
	}

	/**
	 * Filter newspack Templates to show thumbnails
	 * 
	 * @param boolean $use_post_thumbnail Value to filter.
	 */
	public static function newspack_can_show_post_thumbnail( $use_post_thumbnail ): bool {
		/** @var \WP_Post */
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
	public static function maybe_inject_profile_block( string $the_content ): string {
		
		if ( '' !== $the_content ) {
			return $the_content;
		}
	
		return \Govpack\Profile\CPT::default_profile_content();
	}
}

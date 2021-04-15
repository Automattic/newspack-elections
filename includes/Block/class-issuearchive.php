<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\Block;

defined( 'ABSPATH' ) || exit;

/**
 * Register and handle the block.
 */
class IssueArchive {

	/**
	 * Stores static instance of class.
	 *
	 * @access protected
	 * @var Newspack\Govpack\Block\Issue_Archive The single instance of the class
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
	 * Inits the class and registers the register call
	 *
	 * @return self
	 */
	public function __construct() {
		add_action( 'init', [ __CLASS__, 'register' ] );
	}

	/**
	 * Registers the block and associated script
	 *
	 * @return void
	 */
	public static function register() {

		$file = GOVPACK_PLUGIN_FILE . 'dist/editor.asset.php';

		if ( file_exists( $file ) ) {
			$asset_data = require_once $file; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingVariable
		}

		wp_register_script(
			'govpack-editor',
			plugin_dir_url( GOVPACK_PLUGIN_FILE ) . 'govpack/dist/editor.js',
			$asset_data['dependencies'] ?? [],
			$asset_data['version'] ?? '',
			true
		);

		register_block_type(
			'govpack/issue-archive',
			[
				'apiVersion'      => 2,
				'editor_script'   => 'govpack-editor',
				'render_callback' => [ __CLASS__, 'shortcode_handler' ],
				'attributes'      => [
					'id'        => [
						'type'    => 'number',
						'default' => 0,
					],
					'issue'     => [
						'type'    => 'array',
						'default' => [],
					],
					'className' => [
						'type' => 'string',
					],
				],
			]
		);
	}

	/**
	 * Shortcode handler for [govpack].
	 *
	 * @param array  $atts    Array of shortcode attributes.
	 * @param string $content Post content.
	 *
	 * @return string HTML for recipe shortcode.
	 */
	public static function shortcode_handler( $atts, $content = null ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		if ( ! isset( $atts['id'] ) ) {
			return;
		}

		$issue_data = \Newspack\Govpack\CPT\Issue::get_data( $atts['id'] );

		if ( ! $issue_data ) {
			return;
		}

		$atts = shortcode_atts(
			[
				'issue'     => $atts['issue'],
				'className' => '',
			],
			$atts
		);

		ob_start();
		require_once GOVPACK_PLUGIN_FILE . 'template-parts/archive-govpack_issues.php'; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant
		$html = ob_get_clean();

		return $html;
	}

	/**
	 * Fetch stories related to an issue.
	 *
	 * @param integer $issue_id Issue id.
	 * @param array   $issue_term Issue term.
	 *
	 * @return WP_Query
	 */
	public static function get_stories( $issue_id, $issue_term ) {
		$args = [
			'post__not_in' => [ $issue_id ], // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn
			'tax_query'    => [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				[
					'taxonomy' => \Newspack\Govpack\Tax\Issue::TAX_SLUG,
					'field'    => 'id',
					'terms'    => $issue_term,
				],
			],
		];

		return \Newspack\Govpack\Helpers::get_cached_query( $args, 'posts_govpack_issues_' . $issue_id );
	}

}

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
class IssueArchive extends \Newspack\Govpack\Block {

	/**
	 * Registers the block.
	 *
	 * @return void
	 */
	public static function register_block() {
		register_block_type(
			'govpack/issue-archive',
			[
				'apiVersion'      => 2,
				'editor_script'   => 'govpack-editor',
				'render_callback' => [ __CLASS__, 'shortcode_handler' ],
				'attributes'      => [
					'id'    => [
						'type'    => 'number',
						'default' => 0,
					],
					'issue' => [
						'type'    => 'array',
						'default' => [],
					],
				],
				'supports'        => [
					'customClassName' => false,
				],
			],
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

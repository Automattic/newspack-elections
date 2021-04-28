<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\CPT;

use \Newspack\Govpack\Helpers;

/**
 * Register and handle the "Issue" Custom Post Type
 */
class Issue {

	/**
	 * Post Type slug. Used when registering and referencing
	 */
	const CPT_SLUG = 'govpack_issues';

	/**
	 * Shortcode.
	 */
	const SHORTCODE = 'govpack_issue';

	/**
	 * WordPress Hooks
	 */
	public static function hooks() {
		add_action( 'init', [ __CLASS__, 'register_post_type' ] );
		add_filter( 'manage_' . self::CPT_SLUG . '_posts_columns', [ __CLASS__, 'manage_columns' ] );
		add_shortcode( self::SHORTCODE, [ __CLASS__, 'shortcode_handler' ] );
		add_filter( 'body_class', [ __CLASS__, 'filter_body_class' ] );
	}

	/**
	 * Register the Issues post type
	 *
	 * @return object|WP_Error
	 */
	public static function register_post_type() {
		return register_post_type( // phpcs:ignore WordPress.NamingConventions.ValidPostTypeSlug.NotStringLiteral
			self::CPT_SLUG,
			[
				'labels'       => [
					'name'               => _x( 'Issues', 'post type general name', 'govpack' ),
					'singular_name'      => _x( 'Issue', 'post type singular name', 'govpack' ),
					'menu_name'          => _x( 'Issues', 'admin menu', 'govpack' ),
					'name_admin_bar'     => _x( 'Issue', 'add new on admin bar', 'govpack' ),
					'add_new'            => _x( 'Add New', 'popup', 'govpack' ),
					'add_new_item'       => __( 'Add New Issue', 'govpack' ),
					'new_item'           => __( 'New Issue', 'govpack' ),
					'edit_item'          => __( 'Edit Issue', 'govpack' ),
					'view_item'          => __( 'View Issue', 'govpack' ),
					'all_items'          => __( 'Issues', 'govpack' ),
					'search_items'       => __( 'Search Issues', 'govpack' ),
					'not_found'          => __( 'No issues found.', 'govpack' ),
					'not_found_in_trash' => __( 'No issues found in Trash.', 'govpack' ),
				],
				'has_archive'  => false,
				'public'       => true,
				'show_in_rest' => true,
				'show_ui'      => true,
				'supports'     => [ 'editor', 'revisions', 'thumbnail', 'title' ],
				'as_taxonomy'  => \Newspack\Govpack\Tax\Issue::TAX_SLUG,
				'menu_icon'    => 'dashicons-groups',
				'rewrite'      => [
					'slug'       => apply_filters( 'govpack_issue_filter_slug', 'issue' ),
					'with_front' => 'false',
				],
			]
		);
	}

	/**
	 * Adds the post_type to array of supported post types.
	 *
	 * @param array $post_types   Array of post types.
	 *
	 * @return array
	 */
	public static function add_post_type( $post_types ) {
		$post_types[] = static::CPT_SLUG;

		return $post_types;
	}

	/**
	 * Remove tags column from issue admin screen.
	 *
	 * @param string[] $columns The column header labels keyed by column ID.
	 * @return array
	 */
	public static function manage_columns( $columns ) {
		unset( $columns['tags'] );
		return $columns;
	}

	/**
	 * Fetch issue data into an array. Used for shortcode and block.
	 *
	 * @param int $issue_id    Array of shortcode attributes.
	 *
	 * @return array Issue data
	 */
	public static function get_data( $issue_id ) {
		$issue_id = absint( $issue_id );
		if ( ! $issue_id ) {
			return;
		}

		$issue_raw_data = get_post( $issue_id );
		if ( ! $issue_raw_data ) {
			return;
		}

		$issue_data = [
			'id'      => $issue_id,
			'title'   => $issue_raw_data->post_title ?? '',
			'content' => $issue_raw_data->post_content ?? '',
		];

		return $issue_data;
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

		$issue_data = self::get_data( $atts['id'] );
		if ( ! $issue_data ) {
			return;
		}

		$atts = shortcode_atts(
			[
				'className' => '',
			],
			$atts
		);

		ob_start();
		require_once GOVPACK_PLUGIN_FILE . 'template-parts/issue.php'; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant
		$html = ob_get_clean();

		return $html;
	}

	/**
	 * Add body classes depending on layout.
	 *
	 * @param array $classes CSS classes.
	 *
	 * @return array
	 */
	public static function filter_body_class( $classes ) {
		if ( is_singular( self::CPT_SLUG ) ) {
			$classes[] = 'archive';
			$classes[] = 'feature-latest';

			$key = array_search( 'single', $classes, true );
			if ( false !== $key ) {
				unset( $classes[ $key ] );
			}
		}

		return $classes;
	}

	/**
	 * Fetch stories related to an issue.
	 *
	 * @param integer $issue_id Issue id.
	 *
	 * @return WP_Query
	 */
	public static function get_stories( $issue_id ) {
		$term_id = get_post_meta( $issue_id, 'term_id', true );
		$args    = [
			'tax_query' => [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				[
					'taxonomy' => \Newspack\Govpack\Tax\Issue::TAX_SLUG,
					'field'    => 'id',
					'terms'    => $term_id,
				],
			],
		];

		return \Newspack\Govpack\Helpers::get_cached_query( $args, 'posts_govpack_issues_' . $term_id );
	}

}

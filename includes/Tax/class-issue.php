<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\Tax;

/**
 * Register and handle the "Issue" Taxonomy.
 */
class Issue extends \Newspack\Govpack\Taxonomy {

	/**
	 * Taxonomy slug. Used when registering and referencing
	 */
	const TAX_SLUG = 'govpack_issue_tax';

	/**
	 * URL slug.
	 */
	const SLUG = 'issue';

	/**
	 * Register this taxonomy for issues.
	 */
	public static function register_taxonomy() {
		register_taxonomy(
			self::TAX_SLUG,
			self::filtered_post_types(),
			[
				'labels'            => [
					'name'                       => _x( 'Issues', 'Taxonomy General Name', 'govpack' ),
					'singular_name'              => _x( 'Issue', 'Taxonomy Singular Name', 'govpack' ),
					'menu_name'                  => __( 'Issues', 'govpack' ),
					'all_items'                  => __( 'All Issues', 'govpack' ),
					'parent_item'                => __( 'Parent Issue', 'govpack' ),
					'parent_item_colon'          => __( 'Parent Issue:', 'govpack' ),
					'new_item_name'              => __( 'New Issue Name', 'govpack' ),
					'add_new_item'               => __( 'Add New Issue', 'govpack' ),
					'edit_item'                  => __( 'Edit Issue', 'govpack' ),
					'update_item'                => __( 'Update Issue', 'govpack' ),
					'view_item'                  => __( 'View Issue', 'govpack' ),
					'separate_items_with_commas' => __( 'Separate issues with commas', 'govpack' ),
					'add_or_remove_items'        => __( 'Add or remove issues', 'govpack' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'govpack' ),
					'popular_items'              => __( 'Popular Issues', 'govpack' ),
					'search_items'               => __( 'Search Issues', 'govpack' ),
					'not_found'                  => __( 'Not Found', 'govpack' ),
					'no_terms'                   => __( 'No issues', 'govpack' ),
					'items_list'                 => __( 'Issues list', 'govpack' ),
					'items_list_navigation'      => __( 'Issues list navigation', 'govpack' ),
				],
				'public'            => true,
				'hierarchical'      => false,
				'rewrite'           => [
					'slug'         => self::SLUG,
					'with_front'   => false,
					'hierarchical' => false,
				],
				'meta_box_cb'       => false,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'show_in_menu'      => false,
			]
		);
	}

	/**
	 * Get all post types and filter out ones that are not used for posts.
	 */
	private static function filtered_post_types() {
		$post_types = array_keys( get_post_types() );

		$exclude = [
			'attachment',
			'custom_css',
			'customize_changeset',
			'nav_menu_item',
			'revision',
		];

		$exclude_external = apply_filters( 'govpack_exclude_post_types', [] );

		if ( is_array( $exclude_external ) ) {
			$exclude = array_merge( $exclude, $exclude_external );
		}

		return array_filter(
			$post_types,
			function( $post_type ) use ( $exclude ) {
				return ! in_array( $post_type, $exclude, true );
			}
		);
	}
}

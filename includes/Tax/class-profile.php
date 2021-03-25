<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\Tax;

/**
 * Register and handle the "Profile" Taxonomy.
 */
class Profile extends \Newspack\Govpack\Taxonomy {

	/**
	 * Post Type slug. Used when registering and referencing
	 */
	const TAX_SLUG = 'govpack_profile_tax';

	/**
	 * URL slug.
	 */
	const SLUG = 'profile';

	/**
	 * Register this taxonomy for profiles.
	 */
	public static function register_taxonomy() {
		register_taxonomy(
			self::TAX_SLUG,
			self::filtered_post_types(),
			[
				'labels'            => [
					'name'                       => _x( 'Profiles', 'Taxonomy General Name', 'govpack' ),
					'singular_name'              => _x( 'Profile', 'Taxonomy Singular Name', 'govpack' ),
					'menu_name'                  => __( 'Profiles', 'govpack' ),
					'all_items'                  => __( 'All Profiles', 'govpack' ),
					'parent_item'                => __( 'Parent Profile', 'govpack' ),
					'parent_item_colon'          => __( 'Parent Profile:', 'govpack' ),
					'new_item_name'              => __( 'New Profile Name', 'govpack' ),
					'add_new_item'               => __( 'Add New Profile', 'govpack' ),
					'edit_item'                  => __( 'Edit Profile', 'govpack' ),
					'update_item'                => __( 'Update Profile', 'govpack' ),
					'view_item'                  => __( 'View Profile', 'govpack' ),
					'separate_items_with_commas' => __( 'Separate profiles with commas', 'govpack' ),
					'add_or_remove_items'        => __( 'Add or remove profiles', 'govpack' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'govpack' ),
					'popular_items'              => __( 'Popular Profiles', 'govpack' ),
					'search_items'               => __( 'Search Profiles', 'govpack' ),
					'not_found'                  => __( 'Not Found', 'govpack' ),
					'no_terms'                   => __( 'No profiles', 'govpack' ),
					'items_list'                 => __( 'Profiles list', 'govpack' ),
					'items_list_navigation'      => __( 'Profiles list navigation', 'govpack' ),
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
				'show_in_menu'      => true,
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

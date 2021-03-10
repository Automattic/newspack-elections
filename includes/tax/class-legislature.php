<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack;

/**
 * Register and handle the "Profile" Custom Post Type
 */
class Legislature extends Taxonomy {

	/**
	 * Post Type slug. Used when registering and referencing
	 */
	const TAX_SLUG = 'govpack_legislature';

	/**
	 * Register this taxonomy for profiles.
	 */
	public static function register_taxonomy() {
		register_taxonomy(
			self::TAX_SLUG,
			self::get_taxonomy_post_types(),
			[
				'labels'            => [
					'name'                       => _x( 'Legislatures', 'Taxonomy General Name', 'govpack' ),
					'singular_name'              => _x( 'Legislature', 'Taxonomy Singular Name', 'govpack' ),
					'menu_name'                  => __( 'Legislatures', 'govpack' ),
					'all_items'                  => __( 'All Legislatures', 'govpack' ),
					'parent_item'                => __( 'Parent Legislature', 'govpack' ),
					'parent_item_colon'          => __( 'Parent Legislature:', 'govpack' ),
					'new_item_name'              => __( 'New Legislature Name', 'govpack' ),
					'add_new_item'               => __( 'Add New Legislature', 'govpack' ),
					'edit_item'                  => __( 'Edit Legislature', 'govpack' ),
					'update_item'                => __( 'Update Legislature', 'govpack' ),
					'view_item'                  => __( 'View Legislature', 'govpack' ),
					'separate_items_with_commas' => __( 'Separate districts with commas', 'govpack' ),
					'add_or_remove_items'        => __( 'Add or remove districts', 'govpack' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'govpack' ),
					'popular_items'              => __( 'Popular Legislatures', 'govpack' ),
					'search_items'               => __( 'Search Legislatures', 'govpack' ),
					'not_found'                  => __( 'Not Found', 'govpack' ),
					'no_terms'                   => __( 'No districts', 'govpack' ),
					'items_list'                 => __( 'Legislatures list', 'govpack' ),
					'items_list_navigation'      => __( 'Legislatures list navigation', 'govpack' ),
				],
				'public'            => true,
				'hierarchical'      => false,
				'rewrite'           => [
					'slug'         => 'legislature',
					'with_front'   => false,
					'hierarchical' => false,
				],
				'show_admin_column' => true,
				'show_in_rest'      => true,
			]
		);
	}

}

add_action( 'after_setup_theme', [ '\Newspack\Govpack\Legislature', 'hooks' ] );

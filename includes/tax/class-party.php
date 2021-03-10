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
class Party extends Taxonomy {

	/**
	 * Post Type slug. Used when registering and referencing
	 */
	const TAX_SLUG = 'govpack_party';

	/**
	 * Register this taxonomy for profiles.
	 */
	public static function register_taxonomy() {
		register_taxonomy(
			self::TAX_SLUG,
			self::get_taxonomy_post_types(),
			[
				'labels'            => [
					'name'                       => _x( 'Parties', 'Taxonomy General Name', 'govpack' ),
					'singular_name'              => _x( 'Party', 'Taxonomy Singular Name', 'govpack' ),
					'menu_name'                  => __( 'Parties', 'govpack' ),
					'all_items'                  => __( 'All Parties', 'govpack' ),
					'parent_item'                => __( 'Parent Party', 'govpack' ),
					'parent_item_colon'          => __( 'Parent Party:', 'govpack' ),
					'new_item_name'              => __( 'New Party Name', 'govpack' ),
					'add_new_item'               => __( 'Add New Party', 'govpack' ),
					'edit_item'                  => __( 'Edit Party', 'govpack' ),
					'update_item'                => __( 'Update Party', 'govpack' ),
					'view_item'                  => __( 'View Party', 'govpack' ),
					'separate_items_with_commas' => __( 'Separate districts with commas', 'govpack' ),
					'add_or_remove_items'        => __( 'Add or remove districts', 'govpack' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'govpack' ),
					'popular_items'              => __( 'Popular Parties', 'govpack' ),
					'search_items'               => __( 'Search Parties', 'govpack' ),
					'not_found'                  => __( 'Not Found', 'govpack' ),
					'no_terms'                   => __( 'No districts', 'govpack' ),
					'items_list'                 => __( 'Parties list', 'govpack' ),
					'items_list_navigation'      => __( 'Parties list navigation', 'govpack' ),
				],
				'public'            => true,
				'hierarchical'      => false,
				'rewrite'           => [
					'slug'         => 'party',
					'with_front'   => false,
					'hierarchical' => false,
				],
				'show_admin_column' => true,
				'show_in_rest'      => true,
			]
		);
	}

}

add_action( 'after_setup_theme', [ '\Newspack\Govpack\Party', 'hooks' ] );

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
class City extends Taxonomy {

	/**
	 * Post Type slug. Used when registering and referencing
	 */
	const TAX_SLUG = 'govpack_city';

	/**
	 * Register this taxonomy for profiles.
	 */
	public static function register_taxonomy() {
		register_taxonomy(
			self::TAX_SLUG,
			self::get_taxonomy_post_types(),
			[
				'labels'            => [
					'name'                       => _x( 'Cities', 'Taxonomy General Name', 'govpack' ),
					'singular_name'              => _x( 'City', 'Taxonomy Singular Name', 'govpack' ),
					'menu_name'                  => __( 'Cities', 'govpack' ),
					'all_items'                  => __( 'All Cities', 'govpack' ),
					'parent_item'                => __( 'Parent City', 'govpack' ),
					'parent_item_colon'          => __( 'Parent City:', 'govpack' ),
					'new_item_name'              => __( 'New City Name', 'govpack' ),
					'add_new_item'               => __( 'Add New City', 'govpack' ),
					'edit_item'                  => __( 'Edit City', 'govpack' ),
					'update_item'                => __( 'Update City', 'govpack' ),
					'view_item'                  => __( 'View City', 'govpack' ),
					'separate_items_with_commas' => __( 'Separate districts with commas', 'govpack' ),
					'add_or_remove_items'        => __( 'Add or remove districts', 'govpack' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'govpack' ),
					'popular_items'              => __( 'Popular Cities', 'govpack' ),
					'search_items'               => __( 'Search Cities', 'govpack' ),
					'not_found'                  => __( 'Not Found', 'govpack' ),
					'no_terms'                   => __( 'No districts', 'govpack' ),
					'items_list'                 => __( 'Cities list', 'govpack' ),
					'items_list_navigation'      => __( 'Cities list navigation', 'govpack' ),
				],
				'public'            => true,
				'hierarchical'      => false,
				'rewrite'           => [
					'slug'         => 'city',
					'with_front'   => false,
					'hierarchical' => false,
				],
				'show_admin_column' => true,
				'show_in_rest'      => true,
			]
		);
	}

}

add_action( 'after_setup_theme', [ '\Newspack\Govpack\City', 'hooks' ] );

<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\Tax;

/**
 * Register and handle the "City" Taxonomy.
 */
class City extends \Newspack\Govpack\Taxonomy {

	/**
	 * Post Type slug. Used when registering and referencing
	 */
	const TAX_SLUG = 'govpack_city';

	/**
	 * URL slug. Also used for fixtures.
	 */
	const SLUG = 'city';

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
					'separate_items_with_commas' => __( 'Separate cities with commas', 'govpack' ),
					'add_or_remove_items'        => __( 'Add or remove cities', 'govpack' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'govpack' ),
					'popular_items'              => __( 'Popular Cities', 'govpack' ),
					'search_items'               => __( 'Search Cities', 'govpack' ),
					'not_found'                  => __( 'Not Found', 'govpack' ),
					'no_terms'                   => __( 'No cities', 'govpack' ),
					'items_list'                 => __( 'Cities list', 'govpack' ),
					'items_list_navigation'      => __( 'Cities list navigation', 'govpack' ),
				],
				'public'            => true,
				'hierarchical'      => false,
				'rewrite'           => [
					'slug'         => self::SLUG,
					'with_front'   => false,
					'hierarchical' => false,
				],
				'meta_box_cb'       => false,
				'show_admin_column' => false,
				'show_in_rest'      => true,
				'show_ui'      		=> false,
			]
		);
	}
}

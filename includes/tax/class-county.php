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
class County extends Taxonomy {

	/**
	 * Post Type slug. Used when registering and referencing
	 */
	const TAX_SLUG = 'govpack_county';

	/**
	 * Register this taxonomy for profiles.
	 */
	public static function register_taxonomy() {
		register_taxonomy(
			self::TAX_SLUG,
			self::get_taxonomy_post_types(),
			[
				'labels'            => [
					'name'                       => _x( 'Counties', 'Taxonomy General Name', 'govpack' ),
					'singular_name'              => _x( 'County', 'Taxonomy Singular Name', 'govpack' ),
					'menu_name'                  => __( 'Counties', 'govpack' ),
					'all_items'                  => __( 'All Counties', 'govpack' ),
					'parent_item'                => __( 'Parent County', 'govpack' ),
					'parent_item_colon'          => __( 'Parent County:', 'govpack' ),
					'new_item_name'              => __( 'New County Name', 'govpack' ),
					'add_new_item'               => __( 'Add New County', 'govpack' ),
					'edit_item'                  => __( 'Edit County', 'govpack' ),
					'update_item'                => __( 'Update County', 'govpack' ),
					'view_item'                  => __( 'View County', 'govpack' ),
					'separate_items_with_commas' => __( 'Separate districts with commas', 'govpack' ),
					'add_or_remove_items'        => __( 'Add or remove districts', 'govpack' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'govpack' ),
					'popular_items'              => __( 'Popular Counties', 'govpack' ),
					'search_items'               => __( 'Search Counties', 'govpack' ),
					'not_found'                  => __( 'Not Found', 'govpack' ),
					'no_terms'                   => __( 'No districts', 'govpack' ),
					'items_list'                 => __( 'Counties list', 'govpack' ),
					'items_list_navigation'      => __( 'Counties list navigation', 'govpack' ),
				],
				'public'            => true,
				'hierarchical'      => false,
				'rewrite'           => [
					'slug'         => 'county',
					'with_front'   => false,
					'hierarchical' => false,
				],
				'show_admin_column' => true,
				'show_in_rest'      => true,
			]
		);
	}

}

add_action( 'after_setup_theme', [ '\Newspack\Govpack\County', 'hooks' ] );

<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Newspack\Govpack\Tax;

/**
 * Register and handle the "OfficeHolder_Status" Taxonomy.
 */
class OfficeHolderTitle extends \Newspack\Govpack\Taxonomy {

	/**
	 * Post Type slug. Used when registering and referencing
	 */
	const TAX_SLUG = 'govpack_officeholder_title';

	/**
	 * URL slug. Also used for fixtures.
	 */
	const SLUG = 'officeholder_title';

	/**
	 * Register this taxonomy for profiles.
	 */
	public static function register_taxonomy() {
		register_taxonomy(
			self::TAX_SLUG,
			self::get_taxonomy_post_types(),
			[
				'labels'            => [
					'name'                       => _x( 'Officerholder Titles', 'Taxonomy General Name', 'govpack' ),
					'singular_name'              => _x( 'Officerholder Title', 'Taxonomy Singular Name', 'govpack' ),
					'menu_name'                  => __( 'Officerholder Titles', 'govpack' ),
					'all_items'                  => __( 'All Officerholder Titles', 'govpack' ),
					'parent_item'                => __( 'Parent Officerholder Title', 'govpack' ),
					'parent_item_colon'          => __( 'Parent Officerholder Title:', 'govpack' ),
					'new_item_name'              => __( 'New Officerholder Title Name', 'govpack' ),
					'add_new_item'               => __( 'Add New Officerholder Title', 'govpack' ),
					'edit_item'                  => __( 'Edit Officerholder Title', 'govpack' ),
					'update_item'                => __( 'Update Officerholder Title', 'govpack' ),
					'view_item'                  => __( 'View Officerholder Title', 'govpack' ),
					'separate_items_with_commas' => __( 'Separate officeholder Titles with commas', 'govpack' ),
					'add_or_remove_items'        => __( 'Add or remove officeholder Titles', 'govpack' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'govpack' ),
					'popular_items'              => __( 'Popular Officerholder Titles', 'govpack' ),
					'search_items'               => __( 'Search Officerholder Titles', 'govpack' ),
					'not_found'                  => __( 'Not Found', 'govpack' ),
					'no_terms'                   => __( 'No officeholder Titles', 'govpack' ),
					'items_list'                 => __( 'Officerholder Titles list', 'govpack' ),
					'items_list_navigation'      => __( 'Officerholder Titles list navigation', 'govpack' ),
				],
				'public'            => true,
				'hierarchical'      => true,
				'rewrite'           => [
					'slug'         => self::SLUG,
					'with_front'   => false,
					'hierarchical' => false,
				],
				'meta_box_cb'       => false,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'show_ui'           => true,
			]
		);
	}
}

<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core\Tax;

/**
 * Register and handle the "OfficeHolder_Status" Taxonomy.
 */
class OfficeHolderTitle extends \Govpack\Core\Abstracts\Taxonomy {

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
					'name'                       => _x( 'Titles', 'Taxonomy General Name', 'govpack' ),
					'singular_name'              => _x( 'Title', 'Taxonomy Singular Name', 'govpack' ),
					'menu_name'                  => __( 'Titles', 'govpack' ),
					'all_items'                  => __( 'All Titles', 'govpack' ),
					'parent_item'                => __( 'Parent Title', 'govpack' ),
					'parent_item_colon'          => __( 'Parent Title:', 'govpack' ),
					'new_item_name'              => __( 'New Title Name', 'govpack' ),
					'add_new_item'               => __( 'Add New Title', 'govpack' ),
					'edit_item'                  => __( 'Edit Title', 'govpack' ),
					'update_item'                => __( 'Update Title', 'govpack' ),
					'view_item'                  => __( 'View Title', 'govpack' ),
					'separate_items_with_commas' => __( 'Separate officeholder Titles with commas', 'govpack' ),
					'add_or_remove_items'        => __( 'Add or remove officeholder Titles', 'govpack' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'govpack' ),
					'popular_items'              => __( 'Popular Titles', 'govpack' ),
					'search_items'               => __( 'Search Titles', 'govpack' ),
					'not_found'                  => __( 'Not Found', 'govpack' ),
					'no_terms'                   => __( 'No officeholder Titles', 'govpack' ),
					'items_list'                 => __( 'Titles list', 'govpack' ),
					'items_list_navigation'      => __( 'Titles list navigation', 'govpack' ),
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

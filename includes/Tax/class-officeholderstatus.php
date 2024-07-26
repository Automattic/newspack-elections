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
class OfficeHolderStatus extends \Govpack\Core\Abstracts\Taxonomy {

	/**
	 * Post Type slug. Used when registering and referencing
	 */
	const TAX_SLUG = 'govpack_officeholder_status';

	/**
	 * URL slug. Also used for fixtures.
	 */
	const SLUG = 'officeholder_status';

	/**
	 * Register this taxonomy for profiles.
	 */
	public static function register_taxonomy() {

	  
		register_taxonomy(
			self::TAX_SLUG,
			self::get_taxonomy_post_types(),
			[
				'labels'            => [
					'name'                       => _x( 'Statuses', 'Taxonomy General Name', 'govpack' ),
					'singular_name'              => _x( 'Status', 'Taxonomy Singular Name', 'govpack' ),
					'menu_name'                  => __( 'Statuses', 'govpack' ),
					'all_items'                  => __( 'All Statuses', 'govpack' ),
					'parent_item'                => __( 'Parent Status', 'govpack' ),
					'parent_item_colon'          => __( 'Parent Status:', 'govpack' ),
					'new_item_name'              => __( 'New Status Name', 'govpack' ),
					'add_new_item'               => __( 'Add New Status', 'govpack' ),
					'edit_item'                  => __( 'Edit Status', 'govpack' ),
					'update_item'                => __( 'Update Status', 'govpack' ),
					'view_item'                  => __( 'View Status', 'govpack' ),
					'separate_items_with_commas' => __( 'Separate statuses with commas', 'govpack' ),
					'add_or_remove_items'        => __( 'Add or remove statuses', 'govpack' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'govpack' ),
					'popular_items'              => __( 'Popular Statuses', 'govpack' ),
					'search_items'               => __( 'Search Statuses', 'govpack' ),
					'not_found'                  => __( 'Not Found', 'govpack' ),
					'no_terms'                   => __( 'No statuses', 'govpack' ),
					'items_list'                 => __( 'Statuses list', 'govpack' ),
					'items_list_navigation'      => __( 'Statuses list navigation', 'govpack' ),
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
				'show_in_nav_menus'  => false
			]
		);
	}
}

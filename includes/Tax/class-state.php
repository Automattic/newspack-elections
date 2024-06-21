<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core\Tax;

/**
 * Register and handle the "State" Taxonomy.
 */
class State extends \Govpack\Core\Abstracts\Taxonomy {

	/**
	 * Post Type slug. Used when registering and referencing
	 */
	const TAX_SLUG = 'govpack_state';

	/**
	 * URL slug. Also used for fixtures.
	 */
	const SLUG = 'state';

	/**
	 * Register this taxonomy for profiles.
	 */
	public static function register_taxonomy() {
		register_taxonomy(
			self::TAX_SLUG,
			self::get_taxonomy_post_types(),
			[
				'labels'             => [
					'name'                       => _x( 'States', 'Taxonomy General Name', 'govpack' ),
					'singular_name'              => _x( 'State', 'Taxonomy Singular Name', 'govpack' ),
					'menu_name'                  => __( 'States', 'govpack' ),
					'all_items'                  => __( 'All States', 'govpack' ),
					'parent_item'                => __( 'Parent State', 'govpack' ),
					'parent_item_colon'          => __( 'Parent State:', 'govpack' ),
					'new_item_name'              => __( 'New State Name', 'govpack' ),
					'add_new_item'               => __( 'Add New State', 'govpack' ),
					'edit_item'                  => __( 'Edit State', 'govpack' ),
					'update_item'                => __( 'Update State', 'govpack' ),
					'view_item'                  => __( 'View State', 'govpack' ),
					'separate_items_with_commas' => __( 'Separate states with commas', 'govpack' ),
					'add_or_remove_items'        => __( 'Add or remove states', 'govpack' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'govpack' ),
					'popular_items'              => __( 'Popular States', 'govpack' ),
					'search_items'               => __( 'Search States', 'govpack' ),
					'not_found'                  => __( 'Not Found', 'govpack' ),
					'no_terms'                   => __( 'No states', 'govpack' ),
					'items_list'                 => __( 'States list', 'govpack' ),
					'items_list_navigation'      => __( 'States list navigation', 'govpack' ),
				],
				'public'             => true,
				'hierarchical'       => true,
				'rewrite'            => [
					'slug'         => self::SLUG,
					'with_front'   => false,
					'hierarchical' => false,
				],
				'meta_box_cb'        => false,
				'show_admin_column'  => true,
				'show_in_rest'       => true,
				'show_ui'            => true,
				'show_in_nav_menus'  => false,
				'show_in_which_menu' => 'govpack',
			]
		);
	}

}

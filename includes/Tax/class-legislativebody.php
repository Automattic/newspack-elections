<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core\Tax;

/**
 * Register and handle the "Legislative_Body" Taxonomy.
 */
class LegislativeBody extends \Govpack\Core\Abstracts\Taxonomy {

	/**
	 * Post Type slug. Used when registering and referencing
	 */
	const TAX_SLUG = 'govpack_legislative_body';

	/**
	 * URL slug. Also used for fixtures.
	 */
	const SLUG = 'legislative_body';

	/**
	 * Register this taxonomy for profiles.
	 */
	public static function register_taxonomy() {
		register_taxonomy(
			self::TAX_SLUG,
			self::get_taxonomy_post_types(),
			[
				'labels'             => [
					'name'                       => _x( 'Offices', 'Taxonomy General Name', 'govpack' ),
					'singular_name'              => _x( 'Office', 'Taxonomy Singular Name', 'govpack' ),
					'menu_name'                  => __( 'Offices', 'govpack' ),
					'all_items'                  => __( 'All Offices', 'govpack' ),
					'parent_item'                => __( 'Parent Office', 'govpack' ),
					'parent_item_colon'          => __( 'Parent Office:', 'govpack' ),
					'new_item_name'              => __( 'New Office Name', 'govpack' ),
					'add_new_item'               => __( 'Add New Office', 'govpack' ),
					'edit_item'                  => __( 'Edit Office', 'govpack' ),
					'update_item'                => __( 'Update Office', 'govpack' ),
					'view_item'                  => __( 'View Office', 'govpack' ),
					'separate_items_with_commas' => __( 'Separate Offices with commas', 'govpack' ),
					'add_or_remove_items'        => __( 'Add or remove Offices', 'govpack' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'govpack' ),
					'popular_items'              => __( 'Popular Offices', 'govpack' ),
					'search_items'               => __( 'Search Offices', 'govpack' ),
					'not_found'                  => __( 'Not Found', 'govpack' ),
					'no_terms'                   => __( 'No Offices', 'govpack' ),
					'items_list'                 => __( 'Offices list', 'govpack' ),
					'items_list_navigation'      => __( 'Offices list navigation', 'govpack' ),
				],
				'public'             => true,
				'hierarchical'       => true,
				'rewrite'            => [
					'slug'         => self::SLUG,
					'with_front'   => false,
					'hierarchical' => true,
				],
				'meta_box_cb'        => false,
				'show_admin_column'  => true,
				'show_in_rest'       => true,
				'show_ui'            => true,
				'show_in_which_menu' => 'govpack',
				'show_in_nav_menus'  => false,
			]
		);
	}
}

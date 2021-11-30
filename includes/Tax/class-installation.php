<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\Tax;

/**
 * Register and handle the "Installation" Taxonomy.
 */
class Installation extends \Newspack\Govpack\Taxonomy {

	/**
	 * Post Type slug. Used when registering and referencing
	 */
	const TAX_SLUG = 'govpack_installation';

	/**
	 * URL slug. Also used for fixtures.
	 */
	const SLUG = 'installation';

	/**
	 * Register this taxonomy for profiles.
	 */
	public static function register_taxonomy() {
		register_taxonomy(
			self::TAX_SLUG,
			self::get_taxonomy_post_types(),
			[
				'labels'            => [
					'name'                       => _x( 'Installations', 'Taxonomy General Name', 'govpack' ),
					'singular_name'              => _x( 'Installation', 'Taxonomy Singular Name', 'govpack' ),
					'menu_name'                  => __( 'Installations', 'govpack' ),
					'all_items'                  => __( 'All Installations', 'govpack' ),
					'parent_item'                => __( 'Parent Installation', 'govpack' ),
					'parent_item_colon'          => __( 'Parent Installation:', 'govpack' ),
					'new_item_name'              => __( 'New Installation Name', 'govpack' ),
					'add_new_item'               => __( 'Add New Installation', 'govpack' ),
					'edit_item'                  => __( 'Edit Installation', 'govpack' ),
					'update_item'                => __( 'Update Installation', 'govpack' ),
					'view_item'                  => __( 'View Installation', 'govpack' ),
					'separate_items_with_commas' => __( 'Separate Installations with commas', 'govpack' ),
					'add_or_remove_items'        => __( 'Add or remove Installations', 'govpack' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'govpack' ),
					'popular_items'              => __( 'Popular Installations', 'govpack' ),
					'search_items'               => __( 'Search Installations', 'govpack' ),
					'not_found'                  => __( 'Not Found', 'govpack' ),
					'no_terms'                   => __( 'No Installations', 'govpack' ),
					'items_list'                 => __( 'Installations list', 'govpack' ),
					'items_list_navigation'      => __( 'Installations list navigation', 'govpack' ),
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

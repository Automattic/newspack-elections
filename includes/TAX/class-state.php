<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\Tax;

/**
 * Register and handle the "State" Taxonomy.
 */
class State extends \Newspack\Govpack\Taxonomy {

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
				'labels'            => [
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
					'separate_items_with_commas' => __( 'Separate districts with commas', 'govpack' ),
					'add_or_remove_items'        => __( 'Add or remove districts', 'govpack' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'govpack' ),
					'popular_items'              => __( 'Popular States', 'govpack' ),
					'search_items'               => __( 'Search States', 'govpack' ),
					'not_found'                  => __( 'Not Found', 'govpack' ),
					'no_terms'                   => __( 'No districts', 'govpack' ),
					'items_list'                 => __( 'States list', 'govpack' ),
					'items_list_navigation'      => __( 'States list navigation', 'govpack' ),
				],
				'public'            => true,
				'hierarchical'      => false,
				'rewrite'           => [
					'slug'         => self::SLUG,
					'with_front'   => false,
					'hierarchical' => false,
				],
				'show_admin_column' => true,
				'show_in_rest'      => true,
			]
		);
	}

}

add_action( 'after_setup_theme', [ '\Newspack\Govpack\State', 'hooks' ] );

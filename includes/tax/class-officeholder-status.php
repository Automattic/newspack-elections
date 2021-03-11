<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack;

/**
 * Register and handle the "OfficeHolder_Status" Taxonomy.
 */
class OfficeHolder_Status extends Taxonomy {

	/**
	 * Post Type slug. Used when registering and referencing
	 */
	const TAX_SLUG = 'govpack_officeholder';

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
					'name'                       => _x( 'Officerholder Statuses', 'Taxonomy General Name', 'govpack' ),
					'singular_name'              => _x( 'Officerholder Status', 'Taxonomy Singular Name', 'govpack' ),
					'menu_name'                  => __( 'Officerholder Statuses', 'govpack' ),
					'all_items'                  => __( 'All Officerholder Statuses', 'govpack' ),
					'parent_item'                => __( 'Parent Officerholder Status', 'govpack' ),
					'parent_item_colon'          => __( 'Parent Officerholder Status:', 'govpack' ),
					'new_item_name'              => __( 'New Officerholder Status Name', 'govpack' ),
					'add_new_item'               => __( 'Add New Officerholder Status', 'govpack' ),
					'edit_item'                  => __( 'Edit Officerholder Status', 'govpack' ),
					'update_item'                => __( 'Update Officerholder Status', 'govpack' ),
					'view_item'                  => __( 'View Officerholder Status', 'govpack' ),
					'separate_items_with_commas' => __( 'Separate officeholder statuses with commas', 'govpack' ),
					'add_or_remove_items'        => __( 'Add or remove officeholder statuses', 'govpack' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'govpack' ),
					'popular_items'              => __( 'Popular Officerholder Statuses', 'govpack' ),
					'search_items'               => __( 'Search Officerholder Statuses', 'govpack' ),
					'not_found'                  => __( 'Not Found', 'govpack' ),
					'no_terms'                   => __( 'No officeholder statuses', 'govpack' ),
					'items_list'                 => __( 'Officerholder Statuses list', 'govpack' ),
					'items_list_navigation'      => __( 'Officerholder Statuses list navigation', 'govpack' ),
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
			]
		);
	}
}

add_action( 'after_setup_theme', [ '\Newspack\Govpack\OfficeHolder_Status', 'hooks' ] );

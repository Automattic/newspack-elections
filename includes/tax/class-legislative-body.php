<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack;

/**
 * Register and handle the "Legislative_Body" Taxonomy.
 */
class Legislative_Body extends Taxonomy {

	/**
	 * Post Type slug. Used when registering and referencing
	 */
	const TAX_SLUG = 'govpack_legislature';

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
				'labels'            => [
					'name'                       => _x( 'Legislative Bodies', 'Taxonomy General Name', 'govpack' ),
					'singular_name'              => _x( 'Legislative Body', 'Taxonomy Singular Name', 'govpack' ),
					'menu_name'                  => __( 'Legislative Bodies', 'govpack' ),
					'all_items'                  => __( 'All Legislative Bodies', 'govpack' ),
					'parent_item'                => __( 'Parent Legislative Body', 'govpack' ),
					'parent_item_colon'          => __( 'Parent Legislative Body:', 'govpack' ),
					'new_item_name'              => __( 'New Legislative Body Name', 'govpack' ),
					'add_new_item'               => __( 'Add New Legislative Body', 'govpack' ),
					'edit_item'                  => __( 'Edit Legislative Body', 'govpack' ),
					'update_item'                => __( 'Update Legislative Body', 'govpack' ),
					'view_item'                  => __( 'View Legislative Body', 'govpack' ),
					'separate_items_with_commas' => __( 'Separate districts with commas', 'govpack' ),
					'add_or_remove_items'        => __( 'Add or remove districts', 'govpack' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'govpack' ),
					'popular_items'              => __( 'Popular Legislative Bodies', 'govpack' ),
					'search_items'               => __( 'Search Legislative Bodies', 'govpack' ),
					'not_found'                  => __( 'Not Found', 'govpack' ),
					'no_terms'                   => __( 'No districts', 'govpack' ),
					'items_list'                 => __( 'Legislative Bodies list', 'govpack' ),
					'items_list_navigation'      => __( 'Legislative Bodies list navigation', 'govpack' ),
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

add_action( 'after_setup_theme', [ '\Newspack\Govpack\Legislative_Body', 'hooks' ] );

<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\Tax;

/**
 * Register and handle the "Legislative_Body" Taxonomy.
 */
class LegislativeBody extends \Newspack\Govpack\Taxonomy {

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
					'separate_items_with_commas' => __( 'Separate legislative bodies with commas', 'govpack' ),
					'add_or_remove_items'        => __( 'Add or remove legislative bodies', 'govpack' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'govpack' ),
					'popular_items'              => __( 'Popular Legislative Bodies', 'govpack' ),
					'search_items'               => __( 'Search Legislative Bodies', 'govpack' ),
					'not_found'                  => __( 'Not Found', 'govpack' ),
					'no_terms'                   => __( 'No legislative bodies', 'govpack' ),
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
				'meta_box_cb'       => false,
				'show_admin_column' => true,
				'show_in_rest'      => true,
			]
		);
	}
}

add_action( 'after_setup_theme', [ '\Newspack\Govpack\Legislative_Body', 'hooks' ] );

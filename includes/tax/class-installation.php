<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack;

/**
 * Register and handle the "Installation" Taxonomy.
 */
class Installation extends Taxonomy {

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
					'name'                       => _x( 'installations', 'Taxonomy General Name', 'govpack' ),
					'singular_name'              => _x( 'installation', 'Taxonomy Singular Name', 'govpack' ),
					'menu_name'                  => __( 'installations', 'govpack' ),
					'all_items'                  => __( 'All installations', 'govpack' ),
					'parent_item'                => __( 'Parent installation', 'govpack' ),
					'parent_item_colon'          => __( 'Parent installation:', 'govpack' ),
					'new_item_name'              => __( 'New installation Name', 'govpack' ),
					'add_new_item'               => __( 'Add New installation', 'govpack' ),
					'edit_item'                  => __( 'Edit installation', 'govpack' ),
					'update_item'                => __( 'Update installation', 'govpack' ),
					'view_item'                  => __( 'View installation', 'govpack' ),
					'separate_items_with_commas' => __( 'Separate installations with commas', 'govpack' ),
					'add_or_remove_items'        => __( 'Add or remove installations', 'govpack' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'govpack' ),
					'popular_items'              => __( 'Popular installations', 'govpack' ),
					'search_items'               => __( 'Search installations', 'govpack' ),
					'not_found'                  => __( 'Not Found', 'govpack' ),
					'no_terms'                   => __( 'No installations', 'govpack' ),
					'items_list'                 => __( 'installations list', 'govpack' ),
					'items_list_navigation'      => __( 'installations list navigation', 'govpack' ),
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

add_action( 'after_setup_theme', [ '\Newspack\Govpack\installation', 'hooks' ] );

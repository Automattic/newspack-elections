<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\Tax;

/**
 * Register and handle the "Profile" Taxonomy.
 */
class Profile extends \Newspack\Govpack\Taxonomy {

	/**
	 * Post Type slug. Used when registering and referencing
	 */
	const TAX_SLUG = 'govpack_profile';

	/**
	 * URL slug. Also used for fixtures.
	 */
	const SLUG = 'profile';

	/**
	 * Register this taxonomy for profiles.
	 */
	public static function register_taxonomy() {
		register_taxonomy(
			self::TAX_SLUG,
			array_keys( get_post_types() ),
			[
				'labels'            => [
					'name'                       => _x( 'Profiles', 'Taxonomy General Name', 'govpack' ),
					'singular_name'              => _x( 'Profile', 'Taxonomy Singular Name', 'govpack' ),
					'menu_name'                  => __( 'Profiles', 'govpack' ),
					'all_items'                  => __( 'All Profiles', 'govpack' ),
					'parent_item'                => __( 'Parent Profile', 'govpack' ),
					'parent_item_colon'          => __( 'Parent Profile:', 'govpack' ),
					'new_item_name'              => __( 'New Profile Name', 'govpack' ),
					'add_new_item'               => __( 'Add New Profile', 'govpack' ),
					'edit_item'                  => __( 'Edit Profile', 'govpack' ),
					'update_item'                => __( 'Update Profile', 'govpack' ),
					'view_item'                  => __( 'View Profile', 'govpack' ),
					'separate_items_with_commas' => __( 'Separate profiles with commas', 'govpack' ),
					'add_or_remove_items'        => __( 'Add or remove profiles', 'govpack' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'govpack' ),
					'popular_items'              => __( 'Popular Profiles', 'govpack' ),
					'search_items'               => __( 'Search Profiles', 'govpack' ),
					'not_found'                  => __( 'Not Found', 'govpack' ),
					'no_terms'                   => __( 'No profiles', 'govpack' ),
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
				'show_admin_column' => false,
				'show_in_rest'      => true,
				'show_in_menu'      => false,
			]
		);
	}
}

add_action( 'after_setup_theme', [ '\Newspack\Govpack\Taxonomy\Profile', 'hooks' ] );

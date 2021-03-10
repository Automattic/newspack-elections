<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack;

/**
 * Register and handle the "Profile" Custom Post Type
 */
abstract class Taxonomy {
	/**
	 * WordPress Hooks
	 */
	public static function hooks() {
		add_action( 'init', [ get_called_class(), 'register_taxonomy' ] );
	}

	/**
	 * Get taxonomy post types
	 *
	 * @return array
	 */
	protected static function get_taxonomy_post_types() {
		return [ Profile::CPT_SLUG ];
	}
}

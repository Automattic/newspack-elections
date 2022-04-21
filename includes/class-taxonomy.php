<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Newspack\Govpack;

use Newspack\Govpack\CPT\Profile;

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

	/**
	 * Seed taxonomies with default data.
	 */
	public static function seed() {
		$file_path = GOVPACK_PLUGIN_FILE . 'assets/json/' . static::SLUG . '.json';

		if ( ! file_exists( $file_path ) || 0 !== validate_file( $file_path ) ) {
			return;
		}

		$json = file_get_contents( $file_path ); // phpcs:ignore WordPressVIPMinimum.Performance.FetchingRemoteData.FileGetContentsUnknown
		$data = json_decode( $json );

		if ( json_last_error() !== JSON_ERROR_NONE ) {
			return;
		}

		$count = 0;
		foreach ( $data as $item ) {
			$term_exists_result = term_exists( $item, static::TAX_SLUG ); // phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.term_exists_term_exists

			if ( is_array( $term_exists_result ) ) {
				continue;
			}

			$result = wp_insert_term( $item, static::TAX_SLUG );

			if ( ! is_wp_error( $result ) ) {
				$count++;
			}
		}

		return $count;
	}
}

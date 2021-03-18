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
class Helpers {

	const CACHE_GROUP = 'govpack';

	const TWITTER_BASE_URL  = 'https://twitter.com/';
	const FACEBOOK_BASE_URL = 'https://www.facebook.com/';

	/**
	 * Fetch taxonomy data and cache it in memory.
	 *
	 * @param string $slug  Name of the JSON file.
	 * @return array
	 */
	public static function get_cached_taxonomy( $slug ) {
		$cache_key = 'govpack_tax_' . $slug;

		$items = wp_cache_get( $cache_key );

		if ( false === $items ) {
			$term_list = get_terms(
				[
					'taxonomy'   => $slug,
					'hide_empty' => false,
				] 
			);
			if ( is_wp_error( $term_list ) ) {
				WP_CLI::error( "No items found in taxonomy: $slug." );
			}

			$items = array_reduce(
				$term_list,
				function( $carry, $item ) {
					$carry[ $item->name ] = $item->term_taxonomy_id;
					return $carry;
				},
				[]
			);
		}

		return $items;
	}

	/**
	 * Read JSON file and cache it in memory.
	 *
	 * @param string $slug  Name of the JSON file.
	 * @return array
	 */
	public static function get_cached_list( $slug ) {
		$cache_key = 'govpack_' . $slug;

		$items = wp_cache_get( $cache_key );
		if ( false === $items ) {
			$data  = file_get_contents( GOVPACK_PLUGIN_FILE . "assets/json/$slug.json" );
			$items = json_decode( $data, true );

			if ( json_last_error() === JSON_ERROR_NONE && $items ) {
				wp_cache_set( $cache_key, $items, self::CACHE_GROUP, 3600 );
			}
		}

		return $items;
	}

	/**
	 * List honorific name prefixes.
	 *
	 * @return array
	 */
	public static function prefixes() {
		return self::get_cached_list( 'prefix' );
	}

	/**
	 * List US states and territories.
	 *
	 * @return array
	 */
	public static function states() {
		return self::get_cached_list( 'state' );
	}

	/**
	 * List officerholder titles.
	 *
	 * @return array
	 */
	public static function titles() {
		return self::get_cached_list( 'title' );
	}
}

/**
 * Log data to file.
 *
 * @param string $data Data to log.
 */
function gp_log( $data ) {
	if ( defined( 'WP_ENVIRONMENT_TYPE' ) && 'production' === 'WP_ENVIRONMENT_TYPE' ) {
		return;
	}

	if ( ! is_string( $data ) ) {
		$data = var_export( $data, true ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_var_export
	}

	file_put_contents( ABSPATH . WP_DEBUG_LOG, $data . "\n", FILE_APPEND ); // phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.file_ops_file_put_contents
}

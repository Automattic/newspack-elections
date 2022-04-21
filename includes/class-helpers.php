<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Newspack\Govpack;

/**
 * Register and handle the "Profile" Custom Post Type
 */
class Helpers {

	const CACHE_GROUP = 'govpack';

	const TWITTER_BASE_URL   = 'https://twitter.com/';
	const FACEBOOK_BASE_URL  = 'https://www.facebook.com/';
	const INSTAGRAM_BASE_URL = 'https://www.instagram.com/';

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
				return $term_list;
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

	/**
	 * Upload an image and attach it to a post.
	 *
	 * @param string  $url        URL to the image.
	 * @param integer $post_id    Post ID to attach to.
	 * @param string  $description  Description of the image.
	 * @return int|WP_Error|false
	 */
	public static function upload_image( $url, $post_id, $description ) {
		// In Virginia, many of the images are of the form
		// http://memdata.virginiageneralassembly.gov/images/display_image/H0321
		//
		// If the image doesn't have a file extension, media_sideload_image() will fail
		// with this error: Invalid image URL.
		//
		// Using the `image_sideload_extensions` filter to allow empty extensions
		// won't work, as that will result in another error:
		// Sorry, this file type is not permitted for security reasons
		//
		// Workaround is to download it locally and use media_handle_sideload().

		if ( ! $url ) {
			return;
		}

		// This is the easy case, where we have an known extension.
		// WordPress can do the work for us.
		if ( in_array( pathinfo( $url, PATHINFO_EXTENSION ), [ 'jpg', 'jpeg', 'jpe', 'png', 'gif' ], true ) ) {
			return media_sideload_image( $url, $post_id, $description, 'id' );
		}

		$file_array = [
			'name'     => wp_basename( $url ),
			'tmp_name' => download_url( $url ),
		];

		// If error storing temporarily, return the error.
		if ( is_wp_error( $file_array['tmp_name'] ) ) {
			return $file_array['tmp_name'];
		}

		$mime_type = mime_content_type( $file_array['tmp_name'] );
		if ( ! $mime_type ) {
			return new \WP_Error( 'upload', "Cannot determine MIME type for [$url]" );
		}

		if ( 'image/jpeg' === $mime_type ) {
			$file_array['name'] .= '.jpg';
		} elseif ( in_array( $mime_type, [ 'image/png', 'image/x-ms-bmp' ], true ) ) {
			if ( 'image/png' === $mime_type ) {
				$image_data = imagecreatefrompng( $file_array['tmp_name'] );
			} elseif ( 'image/x-ms-bmp' === $mime_type ) {
				$image_data = imagecreatefrombmp( $file_array['tmp_name'] );
			}

			if ( ! $image_data ) {
				return new \WP_Error( 'upload', "Cannot create image of [$mime_type] from [$url]" );
			}

			if ( ! imagejpeg( $image_data, $file_array['tmp_name'] . '.jpg' ) ) {
				return new \WP_Error( 'upload', "Cannot convert [$url] to JPEG" );
			}
			$file_array['name'] .= '.jpg';
		} else {
			return new \WP_Error( 'upload', "Cannot determine file extension for [$url] with MIME type [$mime_type]" );
		}

		return media_handle_sideload( $file_array, $post_id, $description );
	}

	/**
	 * Log data to file.
	 *
	 * @param string $data Data to log.
	 */
	public static function log( $data ) {
		if ( defined( 'WP_ENVIRONMENT_TYPE' ) && 'production' === 'WP_ENVIRONMENT_TYPE' ) {
			return;
		}

		if ( ! is_string( $data ) ) {
			$data = var_export( $data, true ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_var_export
		}

		file_put_contents( WP_DEBUG_LOG, $data . "\n", FILE_APPEND ); // phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.file_ops_file_put_contents
	}

	/**
	 * Retrieves the cached post query, if available, else performs and caches the query
	 * Save the cache for around 1 hour as the default behavior
	 *
	 * @param array  $query_args      Arguments to WP_Query.
	 * @param string $cache_name      Object cache key.
	 * @param string $cache_group     Object cache group.
	 * @param int    $cache_duration  Cache duration.
	 * @return \WP_Query
	 */
	public static function get_cached_query( $query_args, $cache_name, $cache_group = '', $cache_duration = 3600 ) {
		$cached_posts = wp_cache_get( $cache_name );

		if ( false === $cached_posts ) {
			$cached_posts = new \WP_Query( $query_args );

			wp_cache_set( $cache_name, $cached_posts, $cache_group, $cache_duration ); // phpcs:ignore WordPressVIPMinimum.Performance.LowExpiryCacheTime.CacheTimeUndetermined
		}

		return $cached_posts;
	}
}

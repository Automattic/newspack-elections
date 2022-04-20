<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\FrontEnd;

use Exception;

/**
 * GovPack FrontEnd Hooks
 */
class FrontEnd {

	/**
	 * Adds Hooks Specifically for the Frontend display
	 */
	public static function hooks() {
		add_filter( 'newspack_can_show_post_thumbnail', [ __class__, 'newspack_can_show_post_thumbnail' ], 10, 1 );
		add_filter( 'the_content', [ __class__, 'maybe_inject_profile_block' ], 7, 1 );
	}

	/**
	 * Filter newspack Templates to show thumbnails
	 * 
	 * @param boolean $use_post_thumbnail Value to filter.
	 */
	public static function newspack_can_show_post_thumbnail( $use_post_thumbnail ) {
		global $post;

		if ( 'govpack_profiles' === $post->post_type ) {
			return false;
		}
	
		return $use_post_thumbnail;
	}

	/**
	 * If a profile is loaded with no content present then load the profile block instead
	 * 
	 * @param string $the_content profile Content to filter.
	 */
	public static function maybe_inject_profile_block( $the_content ) {
		
		if ( '' !== $the_content ) {
			return $the_content;
		}
	
		return \Newspack\Govpack\CPT\Profile::default_profile_content();
	}
}


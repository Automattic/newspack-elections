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

		add_filter(
			'newspack_can_show_post_thumbnail',
			function( $use_post_thumbnail ) {
				global $post;

				if ( 'govpack_profiles' === $post->post_type ) {
					return false;
				}
			
				return $use_post_thumbnail;
			
			},
			10,
			1 
		);
	}
}


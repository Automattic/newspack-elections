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

	public static function hooks() {

		add_filter(
			'newspack_can_show_post_thumbnail',
			function( $use_post_thumbnail ) {
				global $post;

				if ( $post->post_type === 'govpack_profiles' ) {
					return false;
				}
			
				return $use_post_thumbnail;
			
			},
			10,
			1 
		);
	}
}


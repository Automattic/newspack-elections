<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core;

defined( 'ABSPATH' ) || exit;


/**
 * Govpack Capabilities Class.
 */
class Capabilities {


	const CAN_IMPORT = 'govpack_import';
	/**
	 * Set up actions and filters.
	 */
	public static function hooks() {
		add_action( 'init', [ __CLASS__, 'add_capabilities' ] );
		add_action( 'init', [ __CLASS__, 'test_capabilities' ] );
	}

	/**
	 * Adds Capabilities To the Admin Users for Govpack
	 */
	public static function add_capabilities() {
		$admin = get_role( 'administrator' );
		$admin->add_cap( self::CAN_IMPORT, true );
	}

	/**
	 * Test for if capabilites are working
	 */
	public static function test_capabilities() {
		current_user_can( self::CAN_IMPORT );
	}

	/**
	 * Compile capabilities for a posttype
	 * 
	 * @param string $singular singular name for the post type, used to create capabilities.
	 * @param string $plural plural name for the post type, used to create capabilities. If unset/null the will default to the singular with an 's' postfixed.
	 */
	public static function compile_post_type_capabilities( $singular = 'post', $plural = null ) {

		// no plural? use signular with an s.
		if ( ! $plural ) {
			$plural = $plural . 's';
		}

		return [
			'edit_post'              => "edit_$singular",
			'read_post'              => "read_$singular",
			'delete_post'            => "delete_$singular",
			'edit_posts'             => "edit_$plural",
			'edit_others_posts'      => "edit_others_$plural",
			'publish_posts'          => "publish_$plural",
			'read_private_posts'     => "read_private_$plural",
			'read'                   => 'read',
			'delete_posts'           => "delete_$plural",
			'delete_private_posts'   => "delete_private_$plural",
			'delete_published_posts' => "delete_published_$plural",
			'delete_others_posts'    => "delete_others_$plural",
			'edit_private_posts'     => "edit_private_$plural",
			'edit_published_posts'   => "edit_published_$plural",
			'create_posts'           => "edit_$plural",
		];
	}

}

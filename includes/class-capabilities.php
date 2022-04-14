<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack;

defined( 'ABSPATH' ) || exit;


/**
 * Govpack Capabilities Class.
 */
class Capabilities {


	const CAN_IMPORT = "govpack_import";
	/**
	* Set up actions and filters.
	*/
	public static function hooks() {
		add_action( 'init', [ __CLASS__, 'add_capabilities' ] );
		add_action( 'init', [ __CLASS__, 'test_capabilities' ] );
	}

	public static function add_capabilities() {
		$admin = get_role( 'administrator' );
		$admin->add_cap( self::CAN_IMPORT, true );
	}

	public static function test_capabilities() {
		current_user_can( self::CAN_IMPORT );
	}

}
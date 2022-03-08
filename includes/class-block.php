<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack;

defined( 'ABSPATH' ) || exit;

/**
 * Abstract class for registering and handling of blocks.
 */
abstract class Block {

	/**
	 * WordPress Hooks
	 */
	public static function hooks() {
		add_action( 'init', [ __CLASS__, 'register_script' ] );
		add_action( 'init', [ get_called_class(), 'register_block' ] );
	}

	/**
	 * Registers the common script for the blocks.
	 *
	 * @return void
	 */
	
	public static function register_script() {}

}

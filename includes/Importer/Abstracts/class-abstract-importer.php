<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\Importer\Abstracts;

use Exception;

/**
 * Register and handle the "USIO" Importer
 */
abstract class Abstract_Importer {

		/**
		 * How Does the importer work?
		 * 1. Upload the file to the server
		 * 2. Check the file is a valid wxr
		 * 3. Split the file up into actions in action scheduler
		 * 4. request to see how many actions to do
		 * 5. action scheduker runs
		 */
	public static function make() {
		return new static();
	}

	/**
	 * Main Import Process Runner
	 *
	 * @param string $file  Name of the JSON file.
	 */
	public static function import( $file ) {

		define( 'IMPORT_NOT_RUNNING', 0 );
		define( 'IMPORT_RUNNING', 1 );
		define( 'IMPORT_DONE', 2 );

		$test_key                  = 'govpack_import_processing';
		$import_processing_running = get_option( $test_key, IMPORT_NOT_RUNNING );

		if ( IMPORT_RUNNING === $import_processing_running ) {
			return [ 'status' => 'running' ];
		}

		if ( IMPORT_DONE === $import_processing_running ) {
			return [ 'status' => 'done' ];
		}

		update_option( $test_key, IMPORT_RUNNING );

		$file   = self::check_file( $file );
		$reader = self::create_reader( $file );
		self::process( $reader );

		update_option( $test_key, IMPORT_DONE );

		return [ 'status' => 'running' ];
	}

	/**
	 * Checks the file exists in the Govpack uploads folder
	 *
	 * @param string $file  Name of the JSON file.
	 * @throws \Exception File Not Found.
	 */
	public static function check_file( $file ) {

		if ( file_exists( $file ) ) {
			return $file;
		}

		$path = wp_get_upload_dir();
		$path = $path['basedir'] . '/govpack/' . $file;

		if ( file_exists( $path ) ) {
			return $path;
		}

		throw new \Exception( 'File Not Found' );
	} 

	/**
	 * Creates and returns the XML reader for the Import File
	 *
	 * @param string $file  path of the JSON file.
	 * @throws Exception Could Not Open File to Parse.
	 */
	abstract public static function create_reader( $file );

	/**
	 * Process Loop over WML file
	 * calls  read_x functions for elements it finds
	 *
	 * @param XMLReader $reader  path of the JSON file.
	 */
	abstract public static function process( $reader );

}

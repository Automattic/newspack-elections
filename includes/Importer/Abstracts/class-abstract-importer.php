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

    const IMPORT_NOT_RUNNING = 0;
    const IMPORT_RUNNING = 1;
    const IMPORT_DONE = 2;
    const IMPORT_TEST_KEY = "govpack_import_processing";

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

    public static function cancel(){
        delete_option(self::IMPORT_TEST_KEY);
    }

    	
    /**
	 * Checks if an import is already running
	 *
	 */
	public static function status( ) {



		
		$import_processing_running = get_option(self::IMPORT_TEST_KEY, self::IMPORT_NOT_RUNNING);

		if($import_processing_running == self::IMPORT_RUNNING){
			return ["status" => "running"];
		}

		if($import_processing_running == self::IMPORT_DONE){
			return ["status" => "done"];
		}

        return ["status" => "not_running"];

    }

	/**
	 * Main Import Process Runner
	 *
	 * @param string $file  Name of the JSON file.
	 */
	public static function import( $file ) {


		$import_processing_running = get_option(self::IMPORT_TEST_KEY, self::IMPORT_NOT_RUNNING);

		if($import_processing_running == self::IMPORT_RUNNING){
			return ["status" => "running"];
		}

		if($import_processing_running == self::IMPORT_DONE){
			return ["status" => "done"];
		}

		update_option(self::IMPORT_TEST_KEY, self::IMPORT_RUNNING);

		$file   = self::check_file( $file );
		$reader = self::create_reader( $file );
		self::process( $reader );

		update_option(self::IMPORT_TEST_KEY, self::IMPORT_DONE);

		return ["status" => "running"];
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

    static function create_reader($file){}
    static function process($file){}

}
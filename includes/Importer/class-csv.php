<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Importer;

use Exception;
use League\Csv\Reader;

/**
 * Register and handle the "USIO" Importer
 */
class CSV extends \Govpack\Importer\Abstracts\Abstract_Importer {


	/**
	 * Creates and returns the XML reader for the Import File
	 *
	 * @param string $file  path of the JSON file.
	 * @throws Exception Could Not Open File to Parse.
	 */
	public static function create_reader( $file ) {

		try {
			$reader = Reader::createFromPath( $file );
			$reader->setHeaderOffset( 0 );
		} catch ( Exception $e ) {
			throw new Exception( 'Could Not Open File to Parse' );
		}

		return $reader;
	}


	/**
	 * Process Loop over WML file
	 * calls  read_x functions for elements it finds
	 *
	 * @param XMLReader $reader  path of the JSON file.
	 * @param Array     $extra  Extra params used for the import.
	 */
	public static function process( $reader, $extra ) {

		update_option( 'govpack_import_group', self::import_group() );


		foreach ( $reader->getRecords() as $offset => $record ) {


			if ( \is_array( $extra ) ) {
				$record = array_merge( $record, $extra );
			} 
			
			as_enqueue_async_action( 'govpack_import_csv_profile', [ 'data' => $record ], self::import_group() );

			$limit++;
		}

		as_enqueue_async_action( 'govpack_import_cleanup', [], self::import_group() );

	}

}

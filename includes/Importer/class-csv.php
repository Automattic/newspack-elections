<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core\Importer;

use Exception;
use Govpack\Vendor\League\Csv\Reader;

/**
 * Register and handle the "USIO" Importer
 */
class CSV extends \Govpack\Core\Importer\Abstracts\Abstract_Importer {


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

		if ( in_array( '', $reader->getHeader(), true ) ) {
			throw new Exception( 'Each column in your CSV needs to have a heading, there is at least 1 un-named column' );
		}

		// Normalise the column names in the CSV to all be lowercase, dont actually pass this back to the CSV reader, just pass it to the validation.
		$header = array_map(
			function ( $col ) {
				return strtolower( $col );
			},
			$reader->getHeader()
		);

		
		self::has_required_columns( $header );
		
		return $reader;
	}

	/**
	 * Checks that the CSV has the minimum required columns
	 *
	 * @param array $header array containeing the CSV colum headers.
	 * @throws Exception Exception around the CSV missing a required column.
	 */
	public static function has_required_columns( $header ) {

		$required = apply_filters(
			'govpack_importer_required_columns',
			[
				'name',
				'status',
			]
		);

		$missing = [];

		foreach ( $required as $column ) {
			if ( ! in_array( $column, $header, true ) ) {
				$missing[] = $column;
			}
		}

		if ( count( $missing ) > 0 ) {
			$missing_fields = join( '", "', $missing );
			throw new Exception( 'Your CSV is missing the some required fields ["' . $missing_fields . '"]' ); //phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped
		}

		return true;
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

		$use_action_scheduler = true;

		foreach ( $reader->getRecords() as $offset => $record ) {


			if ( \is_array( $extra ) ) {
				$record = array_merge( $record, $extra );
			} 
			
			if ( $use_action_scheduler ) {
				as_enqueue_async_action( 'govpack_import_csv_profile', [ 'data' => $record ], self::import_group() );
			} else {
				Actions::make_profile_from_csv( $record );
			}
		}

		if ( $use_action_scheduler ) {
			as_enqueue_async_action( 'govpack_import_cleanup', [], self::import_group() );
		}
	}
}

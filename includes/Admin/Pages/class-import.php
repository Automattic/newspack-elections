<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Newspack\Govpack\Admin\Pages;

/**
 * GovPack Class to Handle Import
 */
class Import {


	/**
	 * Handle View for the Import Form
	 */
	public static function view() {

		\Newspack\Govpack\Importer\Importer::check_for_stuck_import();

		wp_enqueue_script( 'govpack-importer' );
		wp_enqueue_style( 'wp-components' );
		
		

		include __DIR__ . './../Views/import.php';
	}


}

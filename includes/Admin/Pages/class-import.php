<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core\Admin\Pages;

/**
 * GovPack Class to Handle Import
 */
class Import {


	/**
	 * Handle View for the Import Form
	 */
	public static function view() {

		\Govpack\Core\Importer\Importer::check_for_stuck_import();

		wp_enqueue_script( 'govpack-importer' );
		wp_enqueue_style( 'wp-components' );
		
		wp_script_add_data( 'govpack-importer', 'profiles_url', 'aksgdkasjdh' );
		

		include __DIR__ . './../Views/import.php';
	}


}

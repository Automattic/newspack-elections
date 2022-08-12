<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core\Admin\Pages;

use \Govpack\Core\CPT\Profile;

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
		
		wp_add_inline_script(
			'govpack-importer',
			'var govpack_importer_options = ' . 
			wp_json_encode( [ 'profiles_path' => admin_url( 'edit.php?post_type=' . Profile::CPT_SLUG ) ] ),
			'before' 
		);
		

		include __DIR__ . './../Views/import.php';
	}


}

<?php
/**
 * Govpack
 *
 * @package Newspack
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

		wp_enqueue_script( 'govpack-importer' );
		wp_enqueue_style( 'wp-components' );
		
		$context = [
			'stage' => 'upload',
		];


		if ( isset( $_POST ) && 
			( ( ! empty( $_POST ) && \check_admin_referer( 'import-upload' ) ) ) &&
			( isset( $_FILES ) && isset( $_FILES['import'] ) )
		) {
			try {
				// Ignore the PHPCS warning as we pass to the WordPress File Upload Functions and they handle the santisation.
				$file                 = self::handle_upload( $_FILES['import'] ); //phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
				$context['stage']     = 'process';
				$context['file_name'] = $file;
			} catch ( \Exception $e ) {
				$context['error'] = $e->getMessage();
			}       
		}

		include __DIR__ . './../Views/import.php';
	}

	/**
	 * Handle Upload for the Import File
	 * 
	 * @param array $file File arry from $_FILES Global to be uploaded.
	 */
	public static function handle_upload( $file ) {
		self::create_upload_directory( 'govpack' );
		$file = wp_handle_upload(
			$file,
			[
				'test_form' => true,
				'action'    => 'save',
			],
			current_time( 'mysql' )
		);
		
		return $file;
	}

	/**
	 * Check the uplaods will work and create a govpack specific directory
	 * 
	 * @param string $slug path of the uploads older to create.
	 */
	public static function create_upload_directory( $slug ) {
		$upload_dir = self::get_upload_path( $slug );
		if ( ! is_dir( $upload_dir ) ) {
			wp_mkdir_p( $upload_dir );
		}
	}

	/**
	 * Get the path we want to use as uploads for GovPack
	 * 
	 * @param string $slug path of the uploads older to create.
	 */
	public static function get_upload_path( $slug ) {
		$upload     = wp_upload_dir();
		$upload_dir = $upload['basedir'];
		$upload_dir = $upload_dir . '/' . $slug;
		return $upload_dir;
	} 
}

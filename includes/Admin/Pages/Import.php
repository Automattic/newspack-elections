<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\Admin\Pages;

class Import {
	function __construct() {
		
	}

	static function view() {

		$context = [
			'stage' => 'upload',
		];

		if ( isset( $_POST ) && ( ! empty( $_POST ) ) ) {
			try {
				$file                 = self::handleUpload( $_FILES['import'] );
				$context['stage']     = 'process';
				$context['file_name'] = $file;
			} catch ( \Exception $e ) {
				$context['error'] = $e->getMessage();
			}       
		}

		extract( $context );
		include __DIR__ . './../Views/import.php';
	}

	static function handleUpload( $file ) {
		self::createUploadDirectory( 'govpack' );
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

	static function createUploadDirectory( $slug ) {
		$upload     = wp_upload_dir();
		$upload_dir = $upload['basedir'];
		$upload_dir = $upload_dir . '/' . $slug;
		if ( ! is_dir( $upload_dir ) ) {
			mkdir( $upload_dir, 0700 );
		}
	}
}

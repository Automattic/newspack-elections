<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core\Admin;

use Exception;
use Govpack\Core\Govpack;
use Govpack\Core\Capabilities;
use Govpack\Core\CPT\Profile;
use Govpack\League\Csv\Writer;

/**
 * GovPack Export
 */
class Export {

	/**
	 * Adds Hooks used for exporting  
	 */
	public static function hooks() {
		\add_action( 'rest_api_init', [ __class__, 'register_rest_endpoints' ] );
		\add_action( 'admin_enqueue_scripts', [ __class__, 'register_scripts' ] );
	}


	/**
	 * Adds ASSETS used for importing  
	 */
	public static function register_scripts() {

		

		$file = GOVPACK_PLUGIN_FILE . 'dist/exporter.asset.php';
		if ( file_exists( $file ) ) {
			$asset_data = require_once $file; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingVariable
		}
		
		$script_handle = 'govpack-exporter';

		

		wp_register_script(
			$script_handle,
			plugin_dir_url( GOVPACK_PLUGIN_FILE ) . 'govpack/dist/exporter.js',
			$asset_data['dependencies'] ?? [],
			$asset_data['version'] ?? '',
			true
		);

	}

	/**
	 * Register the REST Routes 
	 */
	public static function register_rest_endpoints() {

		\register_rest_route(
			Govpack::REST_PREFIX,
			'/export',
			[
				'methods'             => 'GET',
				'callback'            => [
					__class__,
					'run_export',
				],
				'permission_callback' => function () {
				
					return \current_user_can( Capabilities::CAN_EXPORT );

				},
			] 
		);
	}

	/**
	 *  Generate the csv
	 */
	public static function run_export() {

		$csv    = Writer::createFromString();
		$model  = Profile::get_export_model();
		$header = array_keys( $model );
		$csv->insertOne( $header );

		$profiles = Profile::get_all();

		foreach ( $profiles as $profile ) {

			
			$data = [];
			foreach ( $model as $key => $action ) {
				
				if ( 'taxonomy' === $action['type'] ) {

					$terms = get_the_terms( $profile, $action['taxonomy'] );

					$labels = array_map(
						function( $term ) {
							return $term->name;
						},
						$terms
					);

					$data[ $key ] = implode( ';', $labels );

				} elseif ( 'post' === $action['type'] ) {
					$data[ $key ] = $profile->{$action['key']} ?? ' ';
				} elseif ( 'meta' === $action['type'] ) {
					$data[ $key ] = $profile->{$action['key']} ?? ' ';
				} elseif ( 'media' === $action['type'] ) {
					$media_id = $profile->{$action['key']};
					if ( $media_id ) {
						$data[ $key ] = wp_get_attachment_url( $media_id ); 
					} else {
						$data[ $key ] = '';
					}
				}           
			}

			$csv->insertOne( $data );
			
		}

		return $csv->toString();
	}
}

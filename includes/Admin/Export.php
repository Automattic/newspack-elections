<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Admin;

use Govpack\Govpack;
use Govpack\PluginAware;
use Govpack\Profile\CPT as Profile;
use Govpack\Vendor\League\Csv\Writer;

/**
 * GovPack Export
 */
class Export {

	use PluginAware;

	public function __construct( Govpack $plugin ) {
		$this->plugin( $plugin );
	}
	/**
	 * Adds Hooks used for exporting  
	 */
	public function hooks(): void {
		
		\add_action( 'rest_api_init', [ __CLASS__, 'register_rest_endpoints' ] );
		\add_action( 'admin_enqueue_scripts', [ $this, 'register_scripts' ] );
	}


	/**
	 * Adds ASSETS used for importing  
	 */
	public function register_scripts(): void {

		

		$file = $this->plugin->build_path( 'exporter.asset.php' );
		if ( file_exists( $file ) ) {
			$asset_data = require_once $file; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingVariable
		}
		
		$script_handle = 'govpack-exporter';

		wp_register_script(
			$script_handle,
			$this->plugin->build_url( 'exporter.js' ),
			$asset_data['dependencies'] ?? [],
			$asset_data['version'] ?? '',
			true
		);
	}

	/**
	 * Register the REST Routes 
	 */
	public static function register_rest_endpoints(): void {


		\register_rest_route(
			Govpack::REST_PREFIX,
			'/export',
			[
				'methods'             => 'GET',
				'callback'            => [
					__CLASS__,
					'run_export',
				],
				'permission_callback' => function () {
				
					return \current_user_can( 'govpack_export' );
				},
			] 
		);
	}

	/**
	 *  Generate the csv
	 */
	public static function run_export(): string {

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
					if ( ! $terms ) {
						// if no terms then keep it blank.
						$data[ $key ] = '';
					} else {
						$labels       = array_map(
							function ( $term ) {
								return $term->name;
							},
							$terms
						);
						$data[ $key ] = implode( ';', $labels );
					}
				} elseif ( 'post' === $action['type'] ) {
					$data[ $key ] = wp_strip_all_tags( $profile->{$action['key']} ?? ' ' );
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

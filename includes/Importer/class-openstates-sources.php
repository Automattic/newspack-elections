<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\Importer;

/**
 * Register and handle the "USIO" Importer
 */
class OpenStates_Sources extends \Newspack\Govpack\Importer\Abstracts\Abstract_Source {


	/**
	 * get URLS for OpenStates files
	 */
	public static function urls() {

		$data = [
			'all'       => [
				'label' => 'All',
				'items' => [
					'us' => [
						'label' => 'All data',
					],
				],
			],
			
			'us-states' => [
				'label' => 'States',
				'items' => [],
			],
		];

		
		foreach ( self::states as $abbr => $label ) {
			$data['us-states']['items'][ strtolower( $abbr ) ] = [
				'label' => $label,
			];
		}
	   

		foreach ( $data as $group_key => $group ) {
			foreach ( $group['items'] as $item => $info ) {
				$data[ $group_key ]['items'][ $item ]['key'] = sprintf( '%s----%s', $group_key, $item );
				$data[ $group_key ]['items'][ $item ]['url'] = sprintf( 'https://data.openstates.org/people/current/%s.csv', $item );
			}
		}
		

		return $data;
	}

	public static function download( \WP_REST_Request $request ) {

		if ( ! $request->has_param( 'source_file' ) ) {
			return new \WP_Error( 'NO SOURCE FILE SET' );
		}

		$source = self::get_source_from_key( $request->get_param( 'source_file' ) );
		update_option( 'govpack_import_extra_args', [ 'state' => $source['label'] ] );

		try {

			parent::download( $request );

			return [
				'status' => 'done',
			];

		} catch ( \Exception $e ) {
			return new \WP_Error( $e->getMessage() );
		}
	}

}


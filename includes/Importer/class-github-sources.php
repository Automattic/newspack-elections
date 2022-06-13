<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core\Importer;

/**
 * Register and handle the "USIO" Importer
 */
class GitHub_Sources extends \Govpack\Importer\Abstracts\Abstract_Source {


	/**
	 * Get URLS for Github files
	 */
	public static function urls() {

		$data = [
			'all'        => [
				'label' => 'All',
				'items' => [
					'collected' => [
						'label' => 'All data',
					],
				],
			],
			'us-federal' => [
				'label' => 'Federal',
				'items' => [
					'us-house'  => [
						'label' => 'US House',
					],
					'us-senate' => [
						'label' => 'US Senate',
					],
				],
			],
			'us-states'  => [
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
				$data[ $group_key ]['items'][ $item ]['url'] = sprintf( 'https://github.com/govpack-wp/data/raw/main/%s/%s.xml', $group_key, $item );
			}
		}
		

		return $data;
	}

}


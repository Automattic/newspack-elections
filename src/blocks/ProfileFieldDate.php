<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Blocks;

use WP_Block;

defined( 'ABSPATH' ) || exit;

/**
 * Register and handle the block.
 */
class ProfileFieldDate extends \Govpack\Blocks\ProfileFieldText {

	public string $block_name = 'npe/profile-field-date';
	public $field_type        = 'date';

	public function block_build_path(): string {
		return $this->plugin->build_path( 'blocks/ProfileFieldDate' );
	}

	public function get_value(): string {

		$date = \Govpack\Fields\DateValue::to_datetime( parent::get_value() );

		if ( null === $date ) {
			return '';
		}

		return $date->format( $this->get_date_format() );
	}

	public function get_date_format(): string {

		$format = $this->attribute( 'dateFormat' );

		$format = ! empty( $format ) ? $format : get_option( 'date_format' );

		return $format;
	}

	public function variations(): array {
		return $this->create_field_variations();
	}

	public function create_field_type_variations(): array {
		$types      = \Govpack\Profile\CPT::get_field_types();
		$variations = [];

		foreach ( $types as $type ) {
			$variation = [
				'category'    => 'govpack-profile-field',
				'name'        => sprintf( 'profile-field-%s', $type->slug ),
				'title'       => sprintf( 'Profile %s Field', ucfirst( $type->label ) ),
				'description' => sprintf(
					/* translators: %s: taxonomy's label */
					__( 'Display a profile field of type: %s', 'newspack-elections' ),
					$type->label
				),
				'attributes'  => [
					'fieldType' => $type->slug,
				],
				'isActive'    => [ 'fieldType' ],
				'scope'       => [ 'inserter', 'transform' ],
				'icon'        => $type->variation_icon(),
			];

			$variations[] = $variation;
		}

		return $variations;
	}
}

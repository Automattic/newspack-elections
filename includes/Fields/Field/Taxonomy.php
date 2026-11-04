<?php

namespace Govpack\Fields\Field;

use Govpack\Profile\Profile;
class Taxonomy extends \Govpack\Fields\Field {


	/**
	 * Field Taxonomy
	 * 
	 * The Group the field belongs to. Controls where the field is output in the admin.
	 */
	public string $taxonomy;

	/**
	 * Properties to include in array
	 * 
	 * Array of property names that will be included when transformed to an array
	 */
	protected array $to_array = [ 'slug', 'label', 'type', 'group', 'taxonomy', 'source' ];

	/**
	 * Construct the profile field
	 */
	public function __construct( string $slug, string $label, string $taxonomy, string $type = 'text' ) {
		parent::__construct( $slug, $label, 'taxonomy' );
		$this->taxonomy = $taxonomy;
		$this->meta_key = null;
		$this->source   = 'taxonomy';
	}
	
	public function raw( Profile $model ) {

		if ( $this->source === 'taxonomy' ) {
			return $model->terms( $this->taxonomy );
		}
		
		return [];
	}

	/**
	 * Value for the REST API: the profile's terms, each with its archive link.
	 *
	 * The block editor renders the term block from this value, so it does not
	 * request the profile's terms separately for each block.
	 *
	 * @param Profile $model The profile to read the terms from.
	 * @return array WP_Term fields of each term, plus `link`.
	 */
	public function value_for_rest( Profile $model ): array {

		return array_map(
			static function ( $term ) {
				if ( ! $term instanceof \WP_Term ) {
					return $term;
				}

				$data         = $term->to_array();
				$link         = get_term_link( $term );
				$data['link'] = is_wp_error( $link ) ? '' : $link;

				return $data;
			},
			$this->raw( $model )
		);
	}
}

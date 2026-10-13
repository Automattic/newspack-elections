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
class ProfileRow extends \Govpack\Blocks\ProfileField {

	public string $block_name = 'npe/profile-row';


	public function block_build_path(): string {
		return $this->plugin->build_path( 'blocks/ProfileRow' );
	}

	/**
	 * Loads a block from display on the frontend/via render.
	 *
	 * @param array  $attributes array of block attributes.
	 * @param string $content Any HTML or content redurned form the block.
	 * @param WP_Block $template The filename of the template-part to use.
	 */
	public function handle_render( array $attributes, string $content = "", \WP_Block $block ) {
		

		$tag_name = 'div';

		$block_html = sprintf(
			'<%s %s>%s</%s>', 
			$tag_name,
			get_block_wrapper_attributes(
				$this->get_new_block_wrapper_attributes()
			),
			$this->output(),
			$tag_name
		);

		echo $block_html;
	}

	

	public function get_block_class_name(): string {
		return wp_get_block_default_classname( $this->block_name );
	}

	public function show_block(): bool {

		// Rows without a profile field (e.g. Free Text) hold their own content, so they're never treated as empty.
		if ( ! $this->should_hide_if_empty() || ! $this->has_field_key() ) {
			return true;
		}

		// Match the inner field blocks, which treat only '' and [] as empty, so a stored '0' still shows.
		$value = $this->get_value();

		if ( '' === $value || [] === $value ) {
			return false;
		}

		// Date blocks hide stored dates they can't read, so the row treats those as empty too.
		if ( 'date' === $this->get_field()->type->slug && null === \Govpack\Fields\DateValue::to_datetime( $value ) ) {
			return false;
		}

		return true;
	}

	
	public function showLabel(): bool {

		
		$row_show_label   = $this->attribute( 'showLabel' );
		$group_show_label = ( $this->has_context( 'showLabels' ) ? $this->context( 'showLabels' ) : null );

		$show_label = $row_show_label ?? $group_show_label ?? true;

		return $show_label;
	}

	public function output(): string {
		ob_start();
		
		if ( $this->showLabel() ) {
			?>
				<div><?php echo wp_kses_post( $this->label() ); ?></div>
			<?php
		}
		
		echo $this->content;

		return ob_get_clean();
	}

	public function label(): string {

		if ( $this->has_label_from_attributes() ) {
			return $this->attribute( 'label' );
		} 
			
		if ( $this->has_field() ) {
			return $this->get_field()->label;
		}
	
		return '';
	}

	private function has_label_from_attributes(): bool {
		
		if (
			! $this->has_attribute( 'label' ) ||
			( $this->attribute( 'label' ) === '' ) ||
			( $this->attribute( 'label' ) === false ) ||
			( $this->attribute( 'label' ) === null )
		) {
			return false;
		}

		return true;
	}

	public function should_hide_if_empty(): bool {
		return $this->attribute( 'hideFieldIfEmpty' );
	}

	public function variations(): array {
		

		return array_merge( 
		//  $this->create_empty_variations(),
			$this->create_field_type_variations(), 
			$this->create_field_variations(), 
			$this->create_free_type_variations()
		);
	}

	public function create_empty_variations(): array {
		$variation = [
			'category'    => 'newspack-elections-profile-row-fields',
			'name'        => sprintf( 'profile-field-row-%s', 'empty' ),
			'title'       => 'Profile Field',
			'description' => sprintf(
				/* translators: %s: taxonomy's label */
				__( 'Display Empty Profile Field', 'newspack-elections' ),
			),
			'attributes'  => [
				'field' => [ 
					'type' => '',
					'key'  => '',
				],
			],
			'scope'       => [ 'inserter', 'block' ],
			'icon'        => 'connection',
			'isActive'    => [ 'field.type' ],
		];

		return $variation;
	}

	public function create_field_variations(): array {

		$variations = [];

		foreach ( \Govpack\Profile\CPT::fields()->all() as $field ) {

			if ( ! $field->is_block_enabled() ) {
				continue;
			}
			
			

			$variation = [
				'category'    => 'newspack-elections-profile-row-fields',
				'name'        => sprintf( 'profile-field-row-%s', $field->slug ),
				'title'       => $field->label,
				'description' => sprintf(
					/* translators: %s: taxonomy's label */
					__( 'Display Profile Field: %s', 'newspack-elections' ),
					$field->label
				),
				'attributes'  => [
					'field' => [ 
						'type' => $field->type->slug,
						'key'  => $field->slug,
					],
				],
				'isActive'    => [ 'field.type', 'field.key' ],
				'scope'       => [ 'inserter', 'block' ],
				'icon'        => $field->variation_icon(),
				'innerBlocks' => $field->get_variation_inner_blocks(),
			];

			$variations[] = $variation;
		}

		return $variations;
	}


	public function create_field_type_variations(): array {
		
		$variations = [];

		foreach ( $this->plugin->fields()->types()->all() as $type ) {
			$variation = [
				'category'    => 'newspack-elections-profile-row-type',
				'name'        => sprintf( 'profile-field-%s', $type->slug ),
				'title'       => sprintf( 'Profile %s', ucfirst( $type->label ) ),
				'description' => sprintf(
					/* translators: %s: taxonomy's label */
					__( 'Display a profile row of type: %s', 'newspack-elections' ),
					$type->label
				),
				'attributes'  => [
					'field' => [ 
						'type' => $type->slug,
					],
				],
				'isActive'    => [ 'field.type' ],
				'scope'       => [],
				'icon'        => $type->variation_icon(),
				'innerBlocks' => $type->get_variation_inner_blocks(),
			];

			$variations[] = $variation;
		}

		return $variations;
	}

	public function create_free_type_variations(): array {
		
		$variations = [];
	
		$variation = [
			'category'    => 'newspack-elections',
			'name'        => sprintf( 'profile-field-%s', 'free-text' ),
			'title'       => sprintf( 'Profile %s Row', 'Free Text' ),
			'description' => sprintf(
				/* translators: %s: taxonomy's label */
				__( 'Display a profile row of type: %s', 'newspack-elections' ),
				'Free Text'
			),
			'attributes'  => [
				'field' => [
					'type' => 'free-text',
				],
			],
			'isActive'    => [ 'field.type' ],
			'scope'       => [ 'inserter', 'transform' ],
			'icon'        => 'text',
			'innerBlocks' => [
				[
					'core/paragraph',
					[
						'placeholder' => 'Add a custom value',
					],
				],
			],
		];

		$variations[] = $variation;
		return $variations;
	}
}

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
class ProfileFieldLink extends \Govpack\Blocks\ProfileFieldText {

	public string $block_name = 'npe/profile-field-link';
	public $field_type        = 'link';
	
	public function block_build_path(): string {
		return $this->plugin->build_path( 'blocks/ProfileFieldLink' );
	}

	/**
	 * Loads a block from display on the frontend/via render.
	 *
	 * @param array  $attributes array of block attributes.
	 * @param string $content Any HTML or content redurned form the block.
	 * @param WP_Block $template The filename of the template-part to use.
	 */
	public function handle_render( array $attributes, string $content, WP_Block $block ) {

		$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => $this->get_css_class( $attributes ) ] );
		?>
		<div <?php echo $wrapper_attributes; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php echo $this->output();  //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<?php
	}

	public function show_block(): bool {
		
		if ( empty( $this->get_value() ) ) {
			return false;
		}

		return true;
	}

	public function output(): string {
		
		$link = $this->get_value();
		if ( ! is_array( $link ) ) {
			return '';
		}

		$url = $link['url'];

		if ( is_email( $url ) ) {
			$url = 'mailto:' . antispambot( $url );
		} elseif ( $this->get_field()->type->slug === 'phone' ) {
			$url = 'tel:' . $url;
		}

		if ( ! wp_parse_url( $url, PHP_URL_SCHEME ) && ! str_starts_with( $url, '//' ) && ! str_starts_with( $url, '#' ) ) {
			$url = 'https://' . $url;
		}
		
		return sprintf( '<a href="%s">%s</a>', $url, $this->linkText() );
	}

	public function linkText(): string {
		$link = $this->get_value();

		$has_label_override = ( $this->attribute( 'linkTextOverride' ) && $this->attribute( 'linkTextOverride' ) );
		$has_default_label  = ( isset( $link['linkText'] ) && $link['linkText'] );
		$default_label      = $has_default_label ? $link['linkText'] : 'Link';
		
		if ( $this->attribute( 'linkFormat' ) === 'url' ) {
			return $link['url'] ?? '';
		}

		if ( $this->attribute( 'linkFormat' ) === 'label' ) {
			return ( $has_label_override ? $this->attribute( 'linkTextOverride' ) : $default_label );
		}

		if ( $this->attribute( 'linkFormat' ) === 'icon' ) {
			return $this->get_field()->icon_markup() ?? '';
		}


		return $default_label;
	}

	public function variations(): array {
		return $this->create_field_variations();
	}

	public function create_field_variations(): array {

		$variations = [];
		
	

		foreach ( \Govpack\Profile\CPT::fields()->of_format( $this->field_type ) as $field ) {

			if ( ! $field->is_block_enabled() ) {
				continue;
			}

			$variation = [
				'category'    => 'govpack-profile-fields',
				'name'        => sprintf( 'profile-field-%s', $field->slug ),
				'title'       => $field->label,
				'description' => sprintf(
					/* translators: %s: taxonomy's label */
					__( 'Display Profile Field: %s', 'newspack-elections' ),
					$field->label
				),
				'attributes'  => [
					'fieldType' => $field->type->slug,
					'fieldKey'  => $field->slug,
				],
				'isActive'    => [ 'fieldKey' ],
				'scope'       => [ 'inserter' ],
				'icon'        => $field->type->variation_icon(),
			];

			$variations[] = $variation;
		}

		return $variations;
	}

	/**
	 * Get CSS class for the block wrapper.
	 *
	 * @param array $attributes Block attributes.
	 * @return string CSS class.
	 */
	public function get_css_class( $attributes ): string {
		$classes     = [];
		$link_format = '';

		if ( ! empty( $attributes['linkFormat'] ) ) {
			$link_format = sanitize_html_class( $attributes['linkFormat'] );
			if ( $link_format ) {
				$classes[] = 'is-format-' . $link_format;
			}
		}
	
		// Add iconSize class only for icon format
		if ( $link_format === 'icon' && ! empty( $attributes['iconSize'] ) ) {
			$icon_size = sanitize_html_class( $attributes['iconSize'] );
			if ( $icon_size ) {
				$classes[] = $icon_size;
			}
		}
	
		return implode( ' ', $classes );
	}
}

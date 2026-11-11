<?php
/**
 * Functions for Displaying Govpack Blocks in PHP Templates.
 * 
 * @package Govpack
 */
if ( ! function_exists( 'gp_get_available_widths' ) ) {
	/**
	 * @return string[][]
	 *
	 * @psalm-return array{small: array{label: 'Small', value: 'small', maxWidth: '300px'}, medium: array{label: 'Medium', value: 'medium', maxWidth: '400px'}, large: array{label: 'Large', value: 'large', maxWidth: '600px'}, full: array{label: 'Full', value: 'full', maxWidth: '100%'}, auto: array{label: 'Auto', value: 'auto', maxWidth: 'none'}}
	 */
	function gp_get_available_widths(): array {
		return [
			'small'  => [
				'label'    => 'Small',
				'value'    => 'small',
				'maxWidth' => '300px',
			],
			'medium' => [
				'label'    => 'Medium',
				'value'    => 'medium',
				'maxWidth' => '400px',
			],
			'large'  => [
				'label'    => 'Large',
				'value'    => 'large',
				'maxWidth' => '600px',
			],
			'full'   => [
				'label'    => 'Full',
				'value'    => 'full',
				'maxWidth' => '100%',
			],
			'auto'   => [
				'label'    => 'Auto',
				'value'    => 'auto',
				'maxWidth' => 'none',
			],
		];
	}
}

if ( ! function_exists( 'gp_classnames' ) ) {
	function gp_classnames( string|array $classnames = '', array $candidates = [] ) {

		if ( is_array( ( $classnames ) ) ) {
			$classnames = trim( join( ' ', $classnames ) );
		}

		$selection = [];
		foreach ( $candidates as $key => $value ) {
			if ( is_int( $key ) ) {
				$selection[] = $value;
				continue;
			}

			if ( $value === true ) {
				$selection[] = $key;
				continue;
			}       
		}
		

		return trim(
			$classnames . ' ' . join(
				' ',
				$selection
			)
		); 
	}
}


if ( ! function_exists( 'gp_normalise_html_element_args' ) ) {
	function gp_normalise_html_element_args( $elm_attributes ) {

		$normalized_attributes = [];
		foreach ( $elm_attributes as $key => $value ) {
			$normalized_attributes[] = $key . '="' . esc_attr( $value ) . '"';
		}

		$elm_attributes = implode( ' ', $normalized_attributes );

		return trim( $elm_attributes );
	}
}


if ( ! function_exists( 'gp_line_attributes' ) ) {
	function gp_line_attributes( $line, $attributes ) {
		
		$elm_attributes = [
			'id'    => esc_attr( sprintf( 'govpack-profile-block-%s', $line['key'] ) ),
			'class' => esc_attr(
				gp_classnames(
					'wp-block-govpack-profile__line',
					[
						'wp-block-govpack-profile__line--' . $line['key'],
						'npe-profile-row',
						'npe-profile-row--labels-beside',
					]
				)
			),
		];

		return gp_normalise_html_element_args( $elm_attributes );
	}
}






if ( ! function_exists( 'gp_should_show_link' ) ) {
	function gp_should_show_link( string $key, array $attributes ): bool {
		if ( ! isset( $attributes['showOtherLinks'] ) ) {
			return false;
		}

		if (
			( isset( $attributes['selectedLinks'] ) ) &&
			( isset( $attributes['selectedLinks'][ $key ] ) ) &&
			( $attributes['selectedLinks'][ $key ] === false )
		) {
			return false;
		}

		return true;
	}
}

if ( ! function_exists( 'gp_get_photo_styles' ) ) {
	function gp_get_photo_styles( $attributes ) {

		// CSS props to embed with a value getter or boolean.
		$rules = [
			'border-radius' => ( isset( $attributes['avatarBorderRadius'] ) ? esc_attr( $attributes['avatarBorderRadius'] ) : false ),
			'width'         => ( isset( $attributes['avatarSize'] ) ? esc_attr( $attributes['avatarSize'] . 'px' ) : false ),
			'height'        => ( isset( $attributes['avatarSize'] ) ? esc_attr( $attributes['avatarSize'] . 'px' ) : false ),
		];

		return gp_style_attribute_generator( $rules );
	}
}

if ( ! function_exists( 'gp_style_attribute_generator' ) ) {
	function gp_style_attribute_generator( $rules ) {
		// filter the rules where the getter returns false;
		$rules = array_filter( $rules );

		// normalise the rules into css syntax;
		$normalized_rules = [];
		foreach ( $rules as $property => $rule ) {
			$normalized_rules[] = sprintf( '%s: %s;', $property, $rule );
		}

		// join all the normalsed rules and trim any excess whitespace
		return trim( join( ' ', $normalized_rules ) );
	}
}

/**
 * Utility Function that conditionally Outputs a link to a profile around some other content.
 *
 * Takes plain text and returns HTML that is safe to echo: the content is
 * escaped on every path, linked or not, so a caller never has to know which
 * branch it took. Pass text, not markup.
 *
 * @param string  $content The plain-text content to wrap with a link.
 * @param string  $url The URL to link to.
 * @param boolean $use_link Condition control, outputs link if true.
 * @return string Escaped HTML.
 */
if ( ! function_exists( 'gp_maybe_link' ) ) {
	function gp_maybe_link( string $content, string $url, bool $use_link ): string {

		if ( ! $use_link ) {
			return esc_html( $content );
		}
		return '<a href="' . esc_url( $url ) . '">' . esc_html( $content ) . '</a>';
	}
}

if ( ! function_exists( 'gp_get_icons' ) ) {
	function gp_get_icons(): array {
		return gp()->icons()->all();
	}
}

if ( ! function_exists( 'gp_get_icon' ) ) {
	function gp_get_icon( string $key ): string {
		return gp()->icons()->get( $key );
	}
}

if ( ! function_exists( 'gp_has_icon' ) ) {
	function gp_icon_exists( string $key ): bool {
		return gp()->icons()->exists( $key );
	}
}


/**
 * Utility Function that Outputs a Profiles's Contact Sections
 * 
 * @param array $label label for the section being output.
 * @param array $links Data about the profile.
 * @param array $attrs Attributes from the Block.
 */
/*
if ( ! function_exists( 'gp_contact_info' ) ) {
	function gp_contact_info( string $label, array $links, array $attrs ): string|null {
		$outer_template = '
		<div class="wp-block-govpack-profile__comms">
			<div class="wp-block-govpack-profile__label">%s:</div>
			<ul class="wp-block-govpack-profile__comms-icons govpack-inline-list">
				%s
			</ul>
			%s
		</div>';

		$icons = gp_get_icons();

		$services = [ 
			'email'   => 'showEmail',
			'phone'   => 'showPhone',
			'fax'     => 'showFax',
			'website' => 'showWebsite',
		];

		$content = '';

		foreach ( $services as $service => $show ) {

			// no data, dont show it.
			if ( ! isset( $links[ $service ] ) || ! $links[ $service ] ) {
				continue;
			}

			// show control might be disabled.
			if ( ! $attrs[ $show ] ) {
				continue;
			}

			$classes = gp_classnames('wp-block-govpack-profile__contact',[
				'wp-block-govpack-profile__contact--hide-label',
				"wp-block-govpack-profile__contact--{$service}",
			]);

			var_dump($classes);
			die();
			//$classes = join( ' ', $classes );

			$icon         = '<span class="wp-block-govpack-profile__contact__icon wp-block-govpack-profile__contact__icon--%s">%s</span>';
			$contact_icon = sprintf( $icon, $service, gp_get_icon( $service ) );

			if ( ( 'phone' === $service ) || ( 'fax' === $service ) ) {
				$protocol = 'tel:';
			} elseif ( 'email' === $service ) {
				$protocol = 'mailto:';
			} else {
				$protocol = ''; // web has no protocol as it should come from the url itself.
			}

			$content .=  
			"<li class=\"{$classes} \">
				<a href=\"{$protocol}{$links[$service]}\" class=\"wp-block-govpack-profile__contact__link\">
					{$contact_icon}
					<span class=\"wp-block-govpack-profile__contact__label\">{$service}</span>
				</a>
			</li>";

		}

		$address = '';
		if ( $attrs['showAddress'] && $links['address'] ) {
			$classes = [
				'wp-block-govpack-profile__contact',
				'wp-block-govpack-profile__contact--hide-label',
				'wp-block-govpack-profile__contact--address',
			];
			$classes = join( ' ', $classes );   
			$address = sprintf( '<address class="%s">%s</address>', $classes, $links['address'] );
		}

		if ( ! $content && ! $address ) {
			return null;
		}

		return sprintf( $outer_template, $label, $content, $address ); 
	}
}
*/
/**
 * Utility Function that Outputs a Profiles's Contact Other
 * 
 * @param array $label label for the section being output.
 * @param array $links Data about the profile.
 * @param array $attrs Attributes from the Block.
 */
if ( ! function_exists( 'gp_contact_other' ) ) {
	function gp_contact_other( string $label, array $links, array $attrs ): string|null {
		$outer_template = '
		<div class="wp-block-govpack-profile__comms-other">
			<div class="wp-block-govpack-profile__label">%s:</div>
			<dl class="wp-block-govpack-profile__comms-other key-pair-list">
				%s
			</dl>
		</div>';    

		$content = '';
		foreach ( $links as $key => $link ) {
			if ( isset( $attrs[ $key ] ) && $attrs[ $key ] && $link['value'] ) {
				$content .= sprintf( '<dt class="key-pair-list__key" role="term">%s</dt><dd class="key-pair-list__value">%s</dd>', $link['label'], $link['value'] );
			}
		}

		if ( ! $content ) {
			return null;
		}

		return sprintf( $outer_template, $label, $content );
	}
}

if ( ! function_exists( 'gp_get_the_term' ) ) {
	function gp_get_the_term( \WP_Term|int $term_id ): string {

		if ( is_a( $term_id, '\WP_Term' ) ) {
			$term = $term_id;
		} else {
			$term = get_term( $term_id );
		}

		if ( ( $term === null ) || is_wp_error( $term ) ) {
			return '';
		}

		$classnames = [
			'govpack-tag',
			'govpack-tag--' . $term->taxonomy,
			'govpack-tag--' . $term->slug,
			'govpack-tag--' . $term->term_id,
		];

		$classnames = implode( ' ', $classnames );

		return '<span rel="tag" class="' . esc_attr( $classnames ) . '">' . esc_html( $term->name ) . '</span>';
	}
}

if ( ! function_exists( 'gp_get_the_status_terms_list' ) ) {
	/**
	 * @return WP_Error|false|string
	 */
	function gp_get_the_status_terms_list( int $post_id, string $before = '', string $sep = '', string $after = '' ): string|WP_Error|false {
		$taxonomy = 'govpack_officeholder_status';
		$terms    = get_the_terms( $post_id, $taxonomy );

		if ( is_wp_error( $terms ) ) {
			return $terms;
		}

		if ( $terms === false ) {
			return false;
		}

		$tags = [];

		foreach ( $terms as $term ) {
			$tags[] = gp_get_the_term( $term );
		}

		return trim( $before . implode( $sep, $tags ) . $after );
	}
}

if ( ! function_exists( 'esc_svg' ) ) {
	function esc_svg( string $svg_string ): string {
		return wp_kses(
			$svg_string,
			[
				'svg'      => [
					'xmlns'       => [],
					'width'       => [],
					'height'      => [],
					'viewbox'     => [], //lowercase not camelcase!
					'fill'        => [],
					'aria-hidden' => [],
					'role'        => [],
					'focusable'   => [],
					'class'       => [],
				],
				'path'     => [
					'd'         => [],
					'fill'      => [],
					'fill-rule' => [],
					'clip-rule' => [],
					'clip-path' => [],
				],
				'g'        => [
					'path'      => [],
					'fill'      => [],
					'clip-path' => [],
				],
				'defs'     => [],
				'clippath' => [
					'id' => [],
				],
				
			]
		);
	}
}

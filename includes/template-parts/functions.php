<?php
/**
 * Functions for Displaying Govpack Blocks in PHP Templates.
 * 
 * @package Govpack
 */

/**
 * Utility Function that Outputs a row
 * 
 * @param string  $value The value to output.
 * @param boolean $display Override to control if this row will output.
 */
function gp_row( $value, $display ) {

	if ( ! $display ) {
		return null;
	}

	if ( ! $value ) {
		return null;
	}

	// No escaping here. $value here needs to handle HTML beyond what wp_kses can realistically handle. Escaping should be done before passing to this function.
	echo '<div class="wp-block-govpack-profile__line">' . $value . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

}

/**
 * Utility Function that Outputs a link to a profile
 * 
 * @param string  $url The url to link to.
 * @param boolean $title Name of the profile to link to eg More About {$title}.
 */
function gp_link( $url, $title ) {
	return '<a href=' . esc_url( $url ) . '>More About ' . esc_html( $title ) . '</a>';
}

/**
 * Utility Function that conditionally Outputs a link to a profile around some other content
 * 
 * @param string  $content The content to wrap with a link.
 * @param string  $url The URL to link to.
 * @param boolean $use_link Condition control, outputs link if true.
 */
function gp_maybe_link( $content, $url, $use_link ) {

	if ( ! $use_link ) {
		return $content;
	}
	return '<a href=' . esc_url( $url ) . '>' . $content . '</a>';
}

/**
 * Utility Function that Outputs a links to the profile's websites.
 * 
 * Currently only supports the campaign & legislative websites
 * 
 * @param array $websites Data about websites from the profile.
 */
function gp_websites( $websites ) {

	$campaign    = '';
	$legislative = '';
	$li          = '<li><a href="%s">%s</a></li>';

	if ( $websites['campaign'] ) {
		$campaign = sprintf( $li, esc_url( $websites['campaign'] ), 'Campaign Website' );
	}

	if ( $websites['legislative'] ) {
		$legislative = sprintf( $li, esc_url( $websites['legislative'] ), 'Legislative Website' );
	}

	return sprintf(
		'<div class="wp-block-govpack-profile__contacts">
                <ul>
                    %s
                    %s
                </ul>
            </div>',
		$campaign ?? '',
		$legislative ?? '',
	);

}

/**
 * Utility Function that Outputs a Profiles Social and Email.
 * 
 * @param array $profile_data Data about the profile.
 * @param array $attributes Attributes from the Block.
 */
function gp_contacts( $profile_data, $attributes ) {

	$icons = [
		'facebook'  => file_get_contents( GOVPACK_PLUGIN_FILE . '/src/images/facebook.svg' ),
		'twitter'   => file_get_contents( GOVPACK_PLUGIN_FILE . '/src/images/twitter.svg' ),
		'linkedin'  => file_get_contents( GOVPACK_PLUGIN_FILE . '/src/images/linkedin.svg' ),
		'instagram' => file_get_contents( GOVPACK_PLUGIN_FILE . '/src/images/instagram.svg' ),
		'email'     => file_get_contents( GOVPACK_PLUGIN_FILE . '/src/images/email.svg' ),
	];
  
	$icon = '<span class="wp-block-govpack-profile__contact__icon wp-block-govpack-profile__contact__icon--{%s}">%s</span>';

	if ( $attributes['showEmail'] && $profile_data['email'] ) {
		$email_icon = sprintf( $icon, 'email', $icons['email'] );
		$classes    = [
			'wp-block-govpack-profile__contact--hide-label',
		];

		$classes = join( ' ', $classes );

		$email = "<li class=\"wp-block-govpack-profile__contact {$classes}\">
            <a href=\"mailto:{$profile_data['email']}\" class=\"wp-block-govpack-profile__contact__link\">
                {$email_icon}
                <span class=\"wp-block-govpack-profile__contact__label\">Email</span>
            </a>
        </li>";

	}


	$social = '';
	if ( $attributes['showSocial'] ) {

		$services = [ 'facebook', 'twitter', 'linkedin', 'instagram' ];


		foreach ( $services as $service ) {
			if ( ! isset( $profile_data[ $service ] ) || ! $profile_data[ $service ] ) {
				continue;
			}

			$classes = [
				'wp-block-govpack-profile__contact',
				'wp-block-govpack-profile__contact--hide-label',
				"wp-block-govpack-profile__contact--{$service}",
			];
	
			$classes = join( ' ', $classes );


			$contact_icon = sprintf( $icon, $service, $icons[ $service ] );
			$social      .=  
			"<li class=\"{$classes} \">
                <a href=\"{$profile_data[$service]}\" class=\"wp-block-govpack-profile__contact__link\">
                    {$contact_icon}
                    <span class=\"wp-block-govpack-profile__contact__label\">{$service}</span>
                </a>
            </li>";

		}
	}


	return sprintf(
		'<div class="wp-block-govpack-profile__contacts">
                <ul>
                    %s
                    %s
                </ul>
            </div>',
		$email ?? '',
		$social ?? '',
	);
}



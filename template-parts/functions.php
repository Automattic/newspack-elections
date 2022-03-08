<?php

function Row( $value, $display ) {

	if ( ! $display ) {
		return null;
	}

	if ( ! $value ) {
		return null;
	}

	echo '<div class="wp-block-govpack-profile__line">' . $value . '</div>';

}

function GP_Link( $url, $title ) {
	return '<a href=' . $url . '>More About ' . $title . '</a>';
}

function GP_Maybe_Link( $content, $url, $useLink ) {

	if ( ! $useLink ) {
		return $content;
	}
	return '<a href=' . $url . '>' . $content . '</a>';
}

function GP_Contacts( $profile_data, $attributes ) {

	$icons = [
		'facebook'  => file_get_contents( GOVPACK_PLUGIN_FILE . '/assets/images/facebook.svg' ),
		'twitter'   => file_get_contents( GOVPACK_PLUGIN_FILE . '/assets/images/twitter.svg' ),
		'linkedin'  => file_get_contents( GOVPACK_PLUGIN_FILE . '/assets/images/linkedin.svg' ),
		'instagram' => file_get_contents( GOVPACK_PLUGIN_FILE . '/assets/images/instagram.svg' ),
		'email'     => file_get_contents( GOVPACK_PLUGIN_FILE . '/assets/images/email.svg' ),
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

		unset( $classses );
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

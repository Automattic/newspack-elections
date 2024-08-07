<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$profile_data = $extra['profile_data'];
$show         = gp_get_show_data( $profile_data, $attributes );

if ( $show['bio'] ) {
	echo wp_kses_post( $profile_data['bio'] );
}

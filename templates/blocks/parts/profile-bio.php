<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$profile_data = $extra["profile_data"];
$show = gp_get_show_data($profile_data, $attributes);

if ( $show['bio'] ) {
	esc_html_e( $profile_data['bio'] );
} 
			
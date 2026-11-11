<?php

$profile_data  = $extra['profile_data'];
$profile_block = $extra['profile_block'];

if ( ! $profile_block->show( 'profile_link' ) ) {
	return;
}

echo gp_maybe_link(
	/* translators: %s: the profile's name. */
	sprintf( __( 'More About %s', 'newspack-elections' ), $profile_data['name']['name'] ),
	$profile_data['link'],
	true
);

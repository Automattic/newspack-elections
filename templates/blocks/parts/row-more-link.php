<?php

$profile_data  = $extra['profile_data'];
$profile_block = $extra['profile_block'];

if ( ! $profile_block->show( 'profile_link' ) ) {
	return;
}

echo gp_maybe_link( sprintf( 'More About %s', $profile_data['name']['name'] ), $profile_data['link'], true );

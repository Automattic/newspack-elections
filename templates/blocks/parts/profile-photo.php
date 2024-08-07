<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$profile_data = $extra['profile_data'];
$show         = gp_get_show_data( $profile_data, $attributes );

if ( $show['photo'] ) { ?>
	<div class="wp-block-govpack-profile__avatar">
		<figure class="govpack-photo" style="<?php echo esc_attr( gp_get_photo_styles( $attributes ) ); ?>">
			<?php echo wp_kses_post( GP_Maybe_Link( get_the_post_thumbnail( $profile_data['id'], 'post-thumbnail', [ 'class' => 'govpack-photo-image' ] ), $profile_data['link'], false ) ); ?>
		</figure>
	</div>
	<?php
}
<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$profile_data  = $extra['profile_data'];
$profile_block = $extra['profile_block'];


if ( $profile_block->show( 'photo' ) ) { ?>
	<div class="wp-block-govpack-profile__avatar">
		<figure class="govpack-photo" style="<?php echo esc_attr( gp_get_photo_styles( $attributes ) ); ?>">
			<?php echo wp_kses_post( get_the_post_thumbnail( $profile_data['id'], 'post-thumbnail', [ 'class' => 'govpack-photo-image' ] ) ); ?>
		</figure>
	</div>
	<?php
}
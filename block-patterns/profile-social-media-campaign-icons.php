<?php
/**
 * Title: Profile Campaign Social Media Icons
 * Slug: npe/profile-social-media-campaign-icons
 * Viewport Width: 250
 * Inserter: true
 */
?>
<!-- wp:npe/profile-social-links {"openInNewTab":true,"size":"has-small-icon-size","className":"is-style-logos-only","style":{"spacing":{"blockGap":{"left":"5px"}}}} -->
	<?php foreach ( [ 'x', 'facebook', 'instagram', 'youtube' ] as $service ) { ?>
		<!-- wp:npe/profile-social-link {"field":{"key":"<?php echo esc_attr( $service ); ?>_campaign"}} /-->
	<?php } ?>
<!-- /wp:npe/profile-social-links -->

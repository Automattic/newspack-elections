<?php
/**
 * Title: Profile Other Links Icons
 * Slug: npe/profile-other-links-icons
 * Viewport Width: 250
 * Inserter: true
 */

$services = [ 'ballotpedia', 'fec_id', 'gab', 'wikipedia', 'openstates_id', 'opensecrets_id', 'linkedin', 'rumble' ];

?>
<!-- wp:npe/profile-social-links {"openInNewTab":true,"size":"has-small-icon-size","className":"is-style-logos-only","style":{"spacing":{"blockGap":{"left":"5px"}}}} -->
	<?php foreach ( $services as $service ) { ?>
		<!-- wp:npe/profile-social-link {"field":{"key":"<?php echo esc_attr( $service ); ?>"}} /-->
	<?php } ?>
<!-- /wp:npe/profile-social-links -->

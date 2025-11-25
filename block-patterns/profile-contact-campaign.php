<?php
/**
 * Title: Profile Contact Information (Campaign)
 * Slug: npe/profile-contact-campaign
 * Viewport Width: 250
 * Inserter: true
 */
?>
<!-- wp:group {"style":{"spacing":{"blockGap":"0","margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0">
	<!-- wp:npe/profile-separator {"style":{"spacing":{"margin":{"top":"var:preset|spacing|10","bottom":"var:preset|spacing|10"}}}} /-->

	<!-- wp:heading {"style":{"typography":{"fontStyle":"normal","fontWeight":"500"},"spacing":{"margin":{"top":"0rem","bottom":"0.5rem"}}},"fontSize":"medium","fontFamily":"system-sans-serif"} -->
	<h2 class="wp-block-heading has-system-sans-serif-font-family has-medium-font-size" style="margin-top:0rem;margin-bottom:0.5rem;font-style:normal;font-weight:500">Campaign Contact</h2>
	<!-- /wp:heading -->

	<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"top"}} -->
	<div class="wp-block-group">
		<!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch","flexWrap":"wrap"}} -->
		<div class="wp-block-group">
			<!-- wp:npe/profile-row {"showLabel":false,"field":{"type":"text","key":"address_campaign"}} -->
				<!-- wp:npe/profile-field-text {"fontSize":"small","field":{"type":"text","key":"address_campaign"}} /-->
			<!-- /wp:npe/profile-row -->

			<!-- wp:npe/profile-row {"showLabel":false,"field":{"type":"email","key":"email_campaign"}} -->
				<!-- wp:npe/profile-field-link {"fontSize":"small"} /-->
			<!-- /wp:npe/profile-row -->

			<!-- wp:npe/profile-row {"showLabel":false,"field":{"type":"link","key":"website_campaign"}} -->
				<!-- wp:npe/profile-field-link {"linkTextOverride":"Campaign Website","fontSize":"small"} /-->
			<!-- /wp:npe/profile-row -->
			</div>
		<!-- /wp:group -->
		<!-- wp:pattern {"slug":"npe/profile-social-media-campaign-icons"} /-->
	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->

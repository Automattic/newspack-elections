<?php
/**
 * Title: Full Page Profile
 * Slug: npe/full-page-profile
 * Viewport Width: 400
 * Inserter: true
 * Post Types: govpack_profiles
 * Block Types: npe/profile
 */
?>
<!-- wp:npe/profile -->
	<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"1"} /-->
	<!-- wp:npe/profile-row-group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|0"}}} -->
		<!-- wp:npe/profile-name {"metadata":{"name":"Sean Spiller"}} /-->
		<!-- wp:npe/profile-row {"style":{"typography":{"fontWeight":"700","fontStyle":"normal"}},"showLabel":false,"field":{"key":"party","type":"taxonomy"},"fontFamily":"system-sans-serif","fontSize":"small"} -->
			<!-- wp:npe/profile-field-term /-->
		<!-- /wp:npe/profile-row -->

		<!-- wp:npe/profile-row {"style":{"typography":{"fontWeight":"500"}},"showLabel":false,"field":{"key":"status","type":"taxonomy"},"fontFamily":"system-sans-serif","fontSize":"small"} /-->
		<!-- wp:npe/profile-row {"showLabel":false,"field":{"type":"text","key":"endorsements"}} -->
			<!-- wp:npe/profile-field-text {"metadata":{"name":"Former State Senator Raymond Lesniak; New Jersey Education Association"}} /-->
		<!-- /wp:npe/profile-row -->

		<!-- wp:npe/profile-separator {"style":{"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}}} /-->

		<!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group">
				<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
				<div class="wp-block-group">
					<!-- wp:heading {"level":4,"fontSize":"small"} -->
						<h4 class="wp-block-heading has-small-font-size">Official</h4>
					<!-- /wp:heading -->

					<!-- wp:pattern {"slug":"npe/profile-social-media-official-icons"} /-->
				</div>
				<!-- /wp:group -->

				<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
					<div class="wp-block-group">
						<!-- wp:heading {"level":4,"fontSize":"small"} -->
							<h4 class="wp-block-heading has-small-font-size">Campaign</h4>
						<!-- /wp:heading -->

						<!-- wp:pattern {"slug":"npe/profile-social-media-campaign-icons"} /-->
					</div>
				<!-- /wp:group -->

				<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
					<div class="wp-block-group">
						<!-- wp:heading {"level":4,"fontSize":"small"} -->
							<h4 class="wp-block-heading has-small-font-size">Personal</h4>
						<!-- /wp:heading -->
						<!-- wp:pattern {"slug":"npe/profile-social-media-personal-icons"} /-->
					</div>
				<!-- /wp:group -->
			</div>
		<!-- /wp:group -->

		<!-- wp:npe/profile-separator {"style":{"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}}} /-->

		<!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group">
				<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"top"}} -->
					<div class="wp-block-group">
						<!-- wp:heading {"level":4,"fontSize":"small"} -->
							<h4 class="wp-block-heading has-small-font-size">Official</h4>
						<!-- /wp:heading -->
						<!-- wp:group {"style":{"spacing":{"blockGap":"0","margin":{"bottom":"0"}}},"layout":{"type":"constrained","justifyContent":"right"}} -->
							<div class="wp-block-group" style="margin-bottom:0">
								<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30","margin":{"bottom":"var:preset|spacing|20"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
									<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--20)">
										<!-- wp:npe/profile-field-link {"linkFormat":"icon","iconSize":"has-small-icon-size","lock":{"move":false,"remove":false},"field":{"type":"email","key":"email_official"}} /-->
										<!-- wp:npe/profile-field-link {"linkFormat":"icon","iconSize":"has-small-icon-size","lock":{"move":false,"remove":false},"field":{"type":"phone","key":"phone_official"}} /-->
										<!-- wp:npe/profile-field-link {"linkFormat":"icon","iconSize":"has-small-icon-size","lock":{"move":false,"remove":false},"field":{"type":"phone","key":"fax_official"}} /-->
										<!-- wp:npe/profile-field-link {"linkFormat":"icon","iconSize":"has-small-icon-size","lock":{"move":false,"remove":false},"field":{"type":"link","key":"website_official"}} /-->
									</div>
								<!-- /wp:group -->
								<!-- wp:npe/profile-field-text {"style":{"typography":{"textAlign":"right"}},"layout":{"type":"flex","justifyContent":"right"},"metadata":{"name":"d"},"field":{"type":"text","key":"address_official"}} /-->
							</div>
						<!-- /wp:group -->
					</div>
				<!-- /wp:group -->

				<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"top"}} -->
					<div class="wp-block-group">
						<!-- wp:heading {"level":4,"fontSize":"small"} -->
							<h4 class="wp-block-heading has-small-font-size">Campaign</h4>
						<!-- /wp:heading -->

						<!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"constrained"}} -->
							<div class="wp-block-group">
								<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30","margin":{"bottom":"var:preset|spacing|20"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
									<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--20)">
										<!-- wp:npe/profile-field-link {"linkFormat":"icon","lock":{"move":false,"remove":false},"field":{"type":"email","key":"email_campaign"}} /-->
										<!-- wp:npe/profile-field-link {"linkFormat":"icon","lock":{"move":false,"remove":false},"field":{"type":"phone","key":"phone_campaign"}} /-->
										<!-- wp:npe/profile-field-link {"linkFormat":"icon","lock":{"move":false,"remove":false},"field":{"type":"phone","key":"fax_campaign"}} /-->
										<!-- wp:npe/profile-field-link {"linkFormat":"url","lock":{"move":false,"remove":false},"field":{"type":"link","key":"website_campaign"}} /-->
									</div>
								<!-- /wp:group -->
								<!-- wp:npe/profile-field-text {"style":{"typography":{"textAlign":"right"}},"layout":{"type":"flex","justifyContent":"right"},"metadata":{"name":"d"},"field":{"type":"text","key":"address_campaign"}} /-->
							</div>
						<!-- /wp:group -->
					</div>
				<!-- /wp:group -->
			</div>
		<!-- /wp:group -->

		<!-- wp:npe/profile-separator {"style":{"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}}} /-->

		<!-- wp:npe/profile-social-links {"size":"has-small-icon-size","className":"is-style-logos-only","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|20"}}}} -->
			<!-- wp:npe/profile-social-link {"field":{"key":"ballotpedia"}} /-->
			<!-- wp:npe/profile-social-link {"field":{"key":"fec_id"}} /-->
			<!-- wp:npe/profile-social-link {"field":{"key":"gab"}} /-->
			<!-- wp:npe/profile-social-link {"field":{"key":"wikipedia"}} /-->
			<!-- wp:npe/profile-social-link {"field":{"key":"openstates_id"}} /-->
			<!-- wp:npe/profile-social-link {"field":{"key":"opensecrets_id"}} /-->
			<!-- wp:npe/profile-social-link {"field":{"key":"linkedin"}} /-->
			<!-- wp:npe/profile-social-link {"field":{"key":"rumble"}} /-->
		<!-- /wp:npe/profile-social-links -->
	<!-- /wp:npe/profile-row-group -->
<!-- /wp:npe/profile -->

<?php
/**
 * Govpack profile template.
 *
 * @package Govpack
 */

// $profile_data is defined elsewhere.
// phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable

$profile_data = $extra["profile_data"];

$classes = join(
	' ',
	array_filter(
		[ 
			'wp-block-govpack-profile', 
			$attributes['className'],
			( isset( $attributes['align'] ) ? 'align' . $attributes['align'] : false ),
		] 
	) 
);

$available_widths = [
	'small'  => [
		'label'    => 'Small',
		'value'    => 'small',
		'maxWidth' => '300px',
	],
	'medium' => [
		'label'    => 'Medium',
		'value'    => 'medium',
		'maxWidth' => '400px',
	],
	'large'  => [
		'label'    => 'Large',
		'value'    => 'large',
		'maxWidth' => '600px',
	],
	'full'   => [
		'label'    => 'Full',
		'value'    => 'full',
		'maxWidth' => '100%',
	],
];

$styles = join(
	' ',
	[
		'max-width:' . $available_widths[ $attributes['width'] ?? 'full' ]['maxWidth'] . ';',
	]
);

$container_classes = join(
	' ',
	array_filter(
		[ 
			'wp-block-govpack-profile__container', 
			( 'right' === $attributes['avatarAlignment'] ? 'wp-block-govpack-profile__container--right' : false ),
			( 'left' === $attributes['avatarAlignment'] ? 'wp-block-govpack-profile__container--left' : false ),
			( 'is-styled-center' === $attributes['className'] ? 'wp-block-govpack-profile__container--center' : false ),
			( isset( $attributes['align'] ) && ( 'center' === $attributes['align'] ? 'wp-block-govpack-profile__container--align-center' : false ) ),
			( isset( $attributes['align'] ) && ( 'right' === $attributes['align'] ? 'wp-block-govpack-profile__container--align-right' : false ) ),
			
		] 
	) 
);

$show_secondary_address = ( isset( $profile_data['address']['secondary'] ) && 
	( $profile_data['address']['secondary'] !== $profile_data['address']['default'] )
);


$show_name              = ( isset( $profile_data['name']['full']  ) && $attributes['showName'] );
$show_status_tag              = ( isset( $profile_data['status'] ) && $attributes['showStatusTag'] );

?>

<aside class="<?php echo esc_attr( $classes ); ?>" style="<?php echo esc_attr( $styles ); ?>">
	<div class="<?php echo esc_attr( $container_classes ); ?>">
	   

		<div class="wp-block-govpack-profile__avatar">
			<figure
				style = "
					border-radius: <?php echo esc_attr( $attributes['avatarBorderRadius'] ); ?>;
					height:<?php echo esc_attr( $attributes['avatarSize'] ); ?>px;
					width: <?php echo esc_attr( $attributes['avatarSize'] ); ?>px;
				"
			>
				<?php echo GP_Maybe_Link( get_the_post_thumbnail( $profile_data['id'] ), $profile_data['link'], $attributes['showProfileLink'] );  //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</figure>
		</div>


		<div class="wp-block-govpack-profile__info">
			<?php if ( $show_name || $show_status_tag) { ?>
				<div class="wp-block-govpack-profile__line wp-block-govpack-profile--flex-left">
				<?php if ( $show_name) { ?>
					<h3 class="wp-block-govpack-profile__name"> <?php echo GP_Maybe_Link( $profile_data['name']['full'], $profile_data['link'], $attributes['showProfileLink'] );  //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h3>
				<?php } ?>
				<?php if ( $show_status_tag) { ?>
					<div class="wp-block-govpack-profile__status-tag">
							<div class="govpack-termlist">
								<?php echo gp_get_the_status_terms_list($profile_data["id"]); ?>
							</div>
						</div>
				<?php } ?>
				</div>
			<?php } ?>
				
<?php
			if ( $attributes['showBio'] && $profile_data['bio'] ) {
				echo esc_html( $profile_data['bio'] );
			} 
			?>

			</div>
			<?php
				gp_row( 'age', $profile_data['age'], $attributes['showAge'], );
				gp_row( 'leg_body', $profile_data['legislative_body'], $attributes['showLegislativeBody'], );
				gp_row( 'position', $profile_data['position'], $attributes['showPosition'] );
				gp_row( 'party', $profile_data['party'], $attributes['showParty'] );
				gp_row( 'district', $profile_data['district'], ( $attributes['showDistrict'] && $profile_data['district'] ) );
				gp_row( 'state', $profile_data['state'], ( $attributes['showState'] && $profile_data['state'] ) );
				gp_row( 'status', $profile_data['status'], ( $attributes['showStatus'] && $profile_data['status'] ) );
				gp_row( 'social', gp_social_media( $profile_data, $attributes ), ( $attributes['showSocial'] && $profile_data['hasSocial'] ) );
				gp_row( 'comms_capitol', gp_contact_info( 'Capitol', $profile_data['comms']['capitol'], $attributes['selectedCapitolCommunicationDetails'] ), $attributes['showCapitolCommunicationDetails'] );
				gp_row( 'comms_district', gp_contact_info( 'District', $profile_data['comms']['district'], $attributes['selectedDistrictCommunicationDetails'] ), $attributes['showDistrictCommunicationDetails'] );
				gp_row( 'comms_campaign', gp_contact_info( 'Campaign', $profile_data['comms']['campaign'], $attributes['selectedCampaignCommunicationDetails'] ), $attributes['showCampaignCommunicationDetails'] );
				gp_row( 'comms_other', gp_contact_other( 'Other', $profile_data['comms']['other'], $attributes['selectedOtherCommunicationDetails'] ), $attributes['showOtherCommunicationDetails'] );
				gp_row( 'more_about', gp_maybe_link( 'More About ' . $profile_data['name']['full'], $profile_data['link'], $attributes['showProfileLink'] ), $attributes['showProfileLink'] );

			?>

		</div>
	</div> <!-- end __container -->
</aside>

<?php
/**
 * Govpack profile template.
 *
 * @package Govpack
 */

// $profile_data is defined elsewhere.
// phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable

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
			
		] 
	) 
);

$show_secondary_address = ( isset( $profile_data['address']['secondary'] ) && 
	( $profile_data['address']['secondary'] !== $profile_data['address']['default'] )
);

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
			<div class="wp-block-govpack-profile__line">
				
			<?php 
				if ( $attributes['showName'] && $profile_data['name']["full"] ) {
				?>
					<h3> <?php echo GP_Maybe_Link( $profile_data['name']["full"], $profile_data['link'], $attributes['showProfileLink'] );  //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h3>
				<?php
				}
				

				if ( $attributes['showBio'] && $profile_data['bio'] ) {
					echo esc_html( $profile_data['bio'] );
				} 
				?>

			</div>
			<?php
				gp_row( $profile_data['legislative_body'], $attributes['showLegislativeBody'], );
				gp_row( $profile_data['position'], $attributes['showPosition'] );
				gp_row( $profile_data['party'], $attributes['showParty'] );
				gp_row( $profile_data['state'], ( $attributes['showState'] && $profile_data['state'] ) );
				gp_row( gp_social_media( $profile_data, $attributes ), ( $attributes['showSocial'] && $profile_data['hasSocial'] ) );
				gp_row( gp_contact_info( 'Capitol', $profile_data['comms']['capitol'], $attributes['selectedCapitolCommunicationDetails'] ), $attributes['showCapitolCommunicationDetails'] );
				gp_row( gp_contact_info( 'District', $profile_data['comms']['district'], $attributes['selectedDistrictCommunicationDetails'] ), $attributes['showDistrictCommunicationDetails'] );
				gp_row( gp_contact_info( 'Campaign', $profile_data['comms']['campaign'], $attributes['selectedCampaignCommunicationDetails'] ), $attributes['showCampaignCommunicationDetails'] );
				gp_row( gp_contact_other( 'Other', $profile_data['comms']['other'], $attributes['selectedOtherCommunicationDetails'] ), $attributes['showOtherCommunicationDetails'] );
				gp_row( gp_maybe_link("More About " . $profile_data['name']["full"], $profile_data['link'], $attributes['showProfileLink']) , $attributes['showProfileLink'] );

			?>			
		</div>
	</div> <!-- end __container -->
</aside>

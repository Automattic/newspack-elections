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
			'wp-block-govpack-profile-self', 
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
	'auto' => [
		'label'    => 'Auto',
		'value'    => 'auto',
		'maxWidth' => 'auto',
	]
];


$styles = join(
	' ',
	[
		'max-width:' . $available_widths[ $attributes['width'] ?? 'auto' ]['maxWidth'] . ';',
	]
);



$container_classes = join(
	' ',
	array_filter(
		[ 
			'wp-block-govpack-profile-self__container', 
			( isset( $attributes['avatarAlignment'] ) && 'right' === $attributes['avatarAlignment'] ? 'wp-block-govpack-profile-self__container--right' : false ),
			( isset( $attributes['avatarAlignment'] ) && 'left' === $attributes['avatarAlignment'] ? 'wp-block-govpack-profile-self__container--left' : false ),
			( isset( $attributes['align'] ) && ( 'center' === $attributes['align'] ? 'wp-block-govpack-profile-self__container--align-center' : false ) ),
			( 'is-styled-center' === $attributes['className'] ? 'wp-block-govpack-profile-self__container--center' : false ),
		] 
	) 
);


$show_photo             = ( has_post_thumbnail( $profile_data['id'] ) && $attributes['showAvatar'] );
$show_secondary_address = ( isset( $profile_data['address']['secondary'] ) && 
	( $profile_data['address']['secondary'] !== $profile_data['address']['default'] )
);
$show_name              = ( isset( $profile_data['name'] ) && $attributes['showName'] );

?>

<aside class="<?php echo esc_attr( $classes ); ?>" style="<?php echo esc_attr( $styles ); ?>">
	<div class="<?php echo esc_attr( $container_classes ); ?>">
	   
		<?php if ( $show_photo ) { ?>
		<div class="wp-block-govpack-profile-self__avatar">
			<figure>
				<?php echo wp_kses_post( GP_Maybe_Link( "<img src=" . get_the_post_thumbnail_url( $profile_data['id'], "full" ) ." />", $profile_data['link'], false ) ); ?>
			</figure>
		</div>
		<?php } ?>

		<div class="wp-block-govpack-profile-self__info">
			<?php if ( $show_name ) { ?>
				<h3> <?php echo esc_html( $profile_data['name']["full"] ); ?></h3>
			<?php } ?>
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
				
			?>
		</div>
	</div> <!-- end __container -->
</aside>

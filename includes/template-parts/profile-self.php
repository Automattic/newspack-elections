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
				<?php echo wp_kses_post( GP_Maybe_Link( get_the_post_thumbnail( $profile_data['id'] ), $profile_data['link'], false ) ); ?>
			</figure>
		</div>
		<?php } ?>

		<div class="wp-block-govpack-profile-self__info">
			<?php if ( $show_name ) { ?>
				<h1> <?php echo esc_html( $profile_data['name'] ); ?></h1>
			<?php } ?>
			<?php
				gp_row( $profile_data['legislative_body'], $attributes['showLegislativeBody'], );
				gp_row( $profile_data['position'], $attributes['showPosition'] );
				gp_row( $profile_data['party'], $attributes['showParty'] );
				gp_row( $profile_data['state'], ( $attributes['showState'] && $profile_data['state'] ) );
				gp_row( gp_contacts( $profile_data, $attributes ), ( $attributes['showEmail'] || $attributes['showSocial'] && $profile_data['hasSocial'] ) );
				gp_row( $profile_data['address']['default'], $attributes['showAddress'] );
				gp_row( $profile_data['address']['secondary'], ( $attributes['showAddress'] && $show_secondary_address ) );
				gp_row( gp_websites( $profile_data['websites'] ), ( $attributes['showWebsites'] && $profile_data['hasWebsites'] ) );
				
			?>
		</div>
	</div> <!-- end __container -->
</aside>

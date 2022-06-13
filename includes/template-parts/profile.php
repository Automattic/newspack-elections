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
				<?php echo esc_html( GP_Maybe_Link( wp_kses_post( get_the_post_thumbnail( $profile_data['id'] ) ), $profile_data['link'], $attributes['showProfileLink'] ) ); ?>
			</figure>
		</div>


		<div class="wp-block-govpack-profile__info">
			<div class="wp-block-govpack-profile__line">
				<h3> <?php echo esc_html( GP_Maybe_Link( $profile_data['name'], $profile_data['link'], $attributes['showProfileLink'] ) ); ?></h3>

				<?php 
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
				gp_row( GP_Contacts( $profile_data, $attributes ), ( $attributes['showEmail'] || $attributes['showSocial'] && $profile_data['hasSocial'] ) );
				gp_row( $profile_data['address']['default'], $attributes['showAddress'] );
				gp_row( $profile_data['address']['secondary'], ( $attributes['showAddress'] && $show_secondary_address ) );
				gp_row( GP_Websites( $profile_data['websites'] ), ( $attributes['showWebsites'] && $profile_data['hasWebsites'] ) );
				
			?>
		</div>
	</div> <!-- end __container -->
</aside>

<?php
/**
 * Govpack profile template.
 *
 * @package Newspack
 */

// $profile_data is defined elsewhere.
// phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable

$title_role  = array_filter( [ $profile_data['title'], $profile_data['legislative_body'] ] );
$party_state = array_filter( [ $profile_data['party'], $profile_data['state'] ] );
?>
<aside>
<h3><?php echo esc_html( $profile_data['first_name'] . ' ' . $profile_data['last_name'] ); ?></h3>

<?php if ( $party_state ) : ?>
<p><?php echo esc_html( join( ' — ', $party_state ) ); ?></p>
<?php endif; ?>

<?php if ( $title_role ) : ?>
<p><?php echo esc_html( join( ', ', $title_role ) ); ?></p>
<?php endif; ?>

<?php if ( $profile_data['phone'] ) : ?>
<p>
	<a href="<?php echo esc_url( 'tel:' . $profile_data['phone'] ); ?>">
		<img src="<?php echo esc_url( plugins_url( 'assets/images/phone.svg', __DIR__ ) ); ?>" with="39" height="39" alt="phone" />
		<br />phone
	</a>
</p>
<?php endif; ?>
<?php if ( $profile_data['email'] ) : ?>
<p>
	<a href="<?php echo esc_url( 'mailto:' . $profile_data['email'] ); ?>">
		<img src="<?php echo esc_url( plugins_url( 'assets/images/at.svg', __DIR__ ) ); ?>" with="39" height="39" alt="email" />
		<br />email
	</a>
</p>
<?php endif; ?>
<?php if ( $profile_data['website'] ) : ?>
<p>
	<a href="<?php echo esc_url( $profile_data['website'] ); ?>">
		<img src="<?php echo esc_url( plugins_url( 'assets/images/globe.svg', __DIR__ ) ); ?>" with="39" height="39" alt="website" />
		<br />website
	</a>
</p>
<?php endif; ?>
<?php if ( $profile_data['facebook'] ) : ?>
<p>
	<a href="<?php echo esc_url( $profile_data['facebook'] ); ?>">
		<img src="<?php echo esc_url( plugins_url( 'assets/images/facebook.svg', __DIR__ ) ); ?>" with="39" height="39" alt="facebook" />
		<br />facebook
	</a>
</p>
<?php endif; ?>

<?php echo wp_kses_post( get_the_post_thumbnail( $profile_data['id'], 'govpack-square' ) ); ?>

</aside>

<?php
/**
 * Govpack profile template.
 *
 * @package Govpack
 */

// $profile_data is defined elsewhere.
// phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable

if ( in_array( $profile_data['format'], [ 'wiki', 'full' ], true ) ) {
	$title_role  = array_filter( [ $profile_data['title'], $profile_data['legislative_body'] ] );
	$party_state = array_filter( [ $profile_data['party'], $profile_data['state'] ] );
} else {
	$title_role  = false;
	$party_state = false;
}
$classes = join( ' ', array_filter( [ 'govpack-profile', $atts['className'], $profile_data['format'] ] ) );
?>
<aside class="<?php echo esc_attr( $classes ); ?>">
	<p class="photo"><?php echo wp_kses_post( get_the_post_thumbnail( $profile_data['id'], 'govpack-square' ) ); ?></p>

	<div class="name-details">
		<h3 class="name">
			<span class="first-name"><?php echo esc_html( $profile_data['first_name'] ); ?></span>
			<span class="last-name"><?php echo esc_html( $profile_data['last_name'] ); ?></span>
		</h3>

		<?php if ( $party_state ) : ?>
		<p class="info"><?php echo esc_html( join( ' — ', $party_state ) ); ?></p>
		<?php endif; ?>

		<?php if ( $title_role ) : ?>
		<p class="info"><?php echo esc_html( join( ', ', $title_role ) ); ?></p>
		<?php endif; ?>

		<?php if ( 'wiki' === $profile_data['format'] ) : ?>
		<div class="biography">
			<?php echo wp_kses_post( $profile_data['biography'] ); ?>
		</div>
		<?php endif; ?>
	</div>

	<div class="links">
		<?php if ( $profile_data['phone'] ) : ?>
		<p>
			<a href="<?php echo esc_url( 'tel:' . $profile_data['phone'] ); ?>">
				<img src="<?php echo esc_url( plugins_url( 'assets/images/phone.svg', __DIR__ ) ); ?>" with="39" height="39" alt="phone" />
				<span class="label">phone</span>
			</a>
		</p>
		<?php endif; ?>
		<?php if ( $profile_data['email'] ) : ?>
		<p>
			<a href="<?php echo esc_url( 'mailto:' . $profile_data['email'] ); ?>">
				<img src="<?php echo esc_url( plugins_url( 'assets/images/at.svg', __DIR__ ) ); ?>" with="39" height="39" alt="email" />
				<span class="label">email</span>
			</a>
		</p>
		<?php endif; ?>
		<?php if ( $profile_data['website'] ) : ?>
		<p>
			<a href="<?php echo esc_url( $profile_data['website'] ); ?>">
				<img src="<?php echo esc_url( plugins_url( 'assets/images/globe.svg', __DIR__ ) ); ?>" with="39" height="39" alt="website" />
				<span class="label">website</span>
			</a>
		</p>
		<?php endif; ?>
		<?php if ( $profile_data['facebook'] ) : ?>
		<p>
			<a href="<?php echo esc_url( $profile_data['facebook'] ); ?>">
				<img src="<?php echo esc_url( plugins_url( 'assets/images/facebook.svg', __DIR__ ) ); ?>" with="39" height="39" alt="facebook" />
				<span class="label">facebook</span>
			</a>
		</p>
		<?php endif; ?>
	</div>
</aside>

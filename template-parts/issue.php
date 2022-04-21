<?php
/**
 * Govpack issue template.
 *
 * @package Govpack
 */

// $issue_data is defined elsewhere.
// phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable

$classes = join( ' ', array_filter( [ 'govpack-profile', $atts['className'] ] ) );
?>
<aside class="<?php echo esc_attr( $classes ); ?>">
	<p class="photo"><?php echo wp_kses_post( get_the_post_thumbnail( $issue_data['id'], 'govpack-square' ) ); ?></p>

	<div class="name-details">
		<h3 class="name"><?php echo esc_html( $issue_data['title'] ); ?></h3>
		<div class="biography">
			<?php echo wp_kses_post( $issue_data['content'] ); ?>
		</div>
	</div>

</aside>

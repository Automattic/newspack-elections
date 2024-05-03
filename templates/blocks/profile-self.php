<?php
/**
 * Govpack profile template.
 *
 * @package Govpack
 */

// $profile_data is defined elsewhere.
// phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable

$profile_data = $extra["profile_data"];
$block_class = $attributes["className"];
$show = gp_get_show_data($profile_data, $attributes);
$available_widths = gp_get_available_widths();

$container_classes = join(
	' ',
	array_filter(
		[ 
			'wp-block-govpack-profile-self__container', 
			( isset( $attributes['avatarAlignment'] ) && 'right' === $attributes['avatarAlignment'] ? 'wp-block-govpack-profile-self__container--right' : false ),
			( isset( $attributes['avatarAlignment'] ) && 'left' === $attributes['avatarAlignment'] ? 'wp-block-govpack-profile-self__container--left' : false ),
			( isset( $attributes['align'] ) && ( 'center' === $attributes['align'] ? 'wp-block-govpack-profile-self__container--align-center' : false ) ),
			( isset( $attributes['align'] ) && ( 'right' === $attributes['align'] ? 'wp-block-govpack-profile-self__container--align-right' : false ) ),
			( 'is-styled-center' === $attributes['className'] ? 'wp-block-govpack-profile-self__container--center' : false ),
		] 
	) 
);

?>

<aside <?php echo get_block_wrapper_attributes([
	'class' => gp_classnames("wp-block-govpack-profile-self", [
		( isset( $attributes['align'] ) ? 'align' . $attributes['align'] : false ),
		( (isset( $attributes['showLabels'] ) && ($attributes['showLabels']) ) ? "wp-block-govpack-profile--show-labels": false ),
	] ),
	'style' => gp_style_attr_generator([
		"max-width" => $available_widths[ $attributes['width'] ?? 'auto' ]['maxWidth']
	])
]); ?>>
	<!-- start __container -->
	<div class="<?php echo esc_attr( $container_classes ); ?>">	
		<?php gp_get_block_part("blocks/parts/profile", "photo", $attributes, $content, $block, $extra);  ?>
		<dl class="wp-block-govpack-profile__info ">
			<?php gp_get_block_part("blocks/parts/profile", "header", $attributes, $content, $block, $extra);  ?>
			<?php gp_get_block_part("blocks/parts/profile", "lines", $attributes, $content, $block, $extra);  ?>
		</dl>
	</div>
	<!-- end __container -->
</aside>

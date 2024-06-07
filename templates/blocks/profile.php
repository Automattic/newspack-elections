<?php
/**
 * Govpack profile template.
 *
 * @package Govpack
 */

// $profile_data is defined elsewhere.
// phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable

$profile_block = $extra["profile_block"];
$block_class = $attributes["className"];
$show = gp_get_show_data($profile_data, $attributes);
$available_widths = gp_get_available_widths();

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

?>

<aside <?php echo get_block_wrapper_attributes([
	'class' => gp_classnames("wp-block-govpack-profile-self", [
		( isset( $attributes['align'] ) ? 'align' . $attributes['align'] : false ),
	] ),
	'style' => gp_style_attr_generator([
		"max-width" => $available_widths[ $attributes['width'] ?? 'auto' ]['maxWidth']
	])
]); ?>>
	<div class="<?php echo esc_attr( $container_classes ); ?>">
	
		<?php gp_get_block_part("blocks/parts/profile", "photo", $attributes, $content, $block, $extra);  ?>
		<dl class="wp-block-govpack-profile__info">
			<?php if ( $show['name'] || $show['status_tag']) { ?>
				<div class="wp-block-govpack-profile__line wp-block-govpack-profile--flex-left">
				<?php if ( $show['name']) { ?>
					<h3 class="wp-block-govpack-profile__name"> <?php echo GP_Maybe_Link( $profile_data['name']['name'], $profile_data['link'], $attributes['showProfileLink'] );  //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h3>
				<?php } ?>
				<?php if ( $show['status_tag']) { ?>
					<div class="wp-block-govpack-profile__status-tag">
							<div class="govpack-termlist">
								<?php echo gp_get_the_status_terms_list($profile_data["id"]); ?>
							</div>
						</div>
				<?php } ?>
				</div>
			<?php } ?>

			<?php  gp_get_block_part("blocks/parts/profile", "bio", $attributes, $content, $block, $extra);  ?>
			<?php  gp_get_block_part("blocks/parts/profile", "lines", $attributes, $content, $block, $extra);  ?>

		</dl>
	</div> <!-- end __container -->
</aside>

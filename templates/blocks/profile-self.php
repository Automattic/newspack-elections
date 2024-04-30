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

$block_classes = gp_classnames("", [
	( isset( $attributes['align'] ) ? 'align' . $attributes['align'] : false ),
] );

$available_widths = gp_get_available_widths();
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
			( isset( $attributes['align'] ) && ( 'right' === $attributes['align'] ? 'wp-block-govpack-profile-self__container--align-right' : false ) ),
			( 'is-styled-center' === $attributes['className'] ? 'wp-block-govpack-profile-self__container--center' : false ),
		] 
	) 
);


?>

<aside <?php echo get_block_wrapper_attributes([
	'class' => $block_classes,
	'style' => $styles,
]); ?>>

	<div class="<?php echo esc_attr( $container_classes ); ?>">

		<?php if ( $show['photo'] ) { ?>
		<div class="<?php echo esc_attr($block_class);?>__avatar">

			<figure style="<?php echo esc_attr( gp_get_photo_styles($attributes) ); ?>">
				<?php echo wp_kses_post( GP_Maybe_Link( '<img src=' . get_the_post_thumbnail_url( $profile_data['id'], 'full' ) . ' />', $profile_data['link'], false ) ); ?>
			</figure>
		</div>
		<?php } ?>


		<div class="wp-block-govpack-profile-self__info ">
			<?php if ( $show['name'] || $show['status_tag']) { ?>
				<div class="wp-block-govpack-profile-self__line wp-block-govpack-profile-self--flex-left">
					<?php if( $show['name'] ){ ?>
						<h3 class="wp-block-govpack-profile-self__name"> <?php echo esc_html( $profile_data['name']['full'] ); ?></h3>
					<?php } ?>
					<?php if(  $show['status_tag'] ){ ?>
						<div class="wp-block-govpack-profile-self__status-tag">
							<div class="govpack-termlist">
								<?php echo gp_get_the_status_terms_list($profile_data["id"]); ?>
							</div>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
			<?php




			foreach(gp_get_profile_lines($attributes, $profile_data) as $index => $line){
				if ( ! $line["shouldShow"] ) {
					continue;
				}

				if ( ! $line["value"] ) {
					continue;
				}

				?>
					<div <?php echo gp_line_attributes($line);?>>
						<p><?php esc_html_e($line["label"]); ?></p>
						<p><?php echo $line["value"]; ?></p>
					</div>
				<?php
			}

			?>
		</div>
	</div> <!-- end __container -->
</aside>

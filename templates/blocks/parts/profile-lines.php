<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$profile_data = $extra['profile_data'];
$show         = gp_get_show_data( $profile_data, $attributes );


foreach ( gp_get_profile_lines( $attributes, $profile_data ) as $index => $line ) {
	if ( ! $line['shouldShow'] ) {
		continue;
	}

	if ( ! $line['value'] ) {
		continue;
	}

	?>
		<div <?php echo gp_line_attributes( $line, $attributes ); ?>>
			<?php if ( isset( $line['label'] ) && ( $line['label'] ) ) { ?>
			<dt 
				class="
				<?php
				echo esc_attr(
					gp_classnames(
						'govpack-line__label',
						[
							$show['labels'] ? 'govpack-line__label--show' : 'govpack-line__label--hide',
						]
					)
				);
				?>
				"
			><?php echo esc_html( $line['label'] ); ?></dt>
			<?php } ?>
			<dd class="govpack-line__content">
			<?php 
				// Do not escape here. Should escape in the functions that generate the output for value.
				// This will be mixed strings and HTML
				// TODO : Consider a custom wp_kses function but this may cause double escaping
				echo $line['value']; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
				</dd> 
		</div>
	<?php
}


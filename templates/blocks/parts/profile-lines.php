<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$profile_data = $extra["profile_data"];
$show = gp_get_show_data($profile_data, $attributes);


foreach(gp_get_profile_lines($attributes, $profile_data) as $index => $line){
	if ( ! $line["shouldShow"] ) {
		continue;
	}

	if ( ! $line["value"] ) {
		continue;
	}

	?>
		<div <?php echo gp_line_attributes($line, $attributes);?>>
			<?php if(isset($line["label"]) && ($line["label"])){ ?>
			<dt 
				class="<?php echo gp_classnames("govpack-line__label", [
					$show["labels"] ? "govpack-line__label--show" : "govpack-line__label--hide"
				]);?>"
			><?php esc_html_e($line["label"]);?></dt>
			<?php } ?>
			<dd class="govpack-line__content"><?php echo $line["value"]; ?></dd>
		</div>
	<?php
}


<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! is_active_sidebar( 'govpack-sidebar' ) ) {
	return;
}

?>
<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'govpack-sidebar' ); ?>
</aside><!-- #secondary -->

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="main-content">
	<header class="entry-header">
		<?php govpack_get_template_part( 'template-parts/header/entry', 'header' ); ?>
	</header>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-content">
			<?php the_content(); ?>
		</div>
	</article>
</div>
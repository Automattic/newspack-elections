<?php
/**
 * Template for displaying a single Govpack Profile
 *
 * This template can be overridden by copying it to yourtheme/govpack/single-govpack_profile.php.
 *
 * @package     Govpack\Templates
 * @version     1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'govpack' ); ?>

	<?php
		/**
		 * govpack_before_main_content hook.
		 *
		 * @hooked govpack_output_content_wrapper - 10 (opening div for the content)
		 */
		do_action( 'govpack_before_main_content' );
	?>
	
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
		
			<?php govpack_get_template_part( 'content/single', 'profile' ); ?>

		<?php endwhile; // end of the loop. ?>

		<?php
		/**
		 * govpack_sidebar hook.
		 *
		 * @hooked govpack_get_sidebar - 10
		 */
		do_action( 'govpack_sidebar' );
	?>

	<?php
		/**
		 * govpack_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (closing div for the content)
		 */
		do_action( 'govpack_after_main_content' );
	?>

	

<?php
get_footer( 'govpack' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
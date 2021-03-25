<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Newspack
 */

get_header();
?>

	<section id="primary" class="content-area <?php echo esc_attr( newspack_get_category_tag_classes( get_the_ID() ) ); ?>">
		<main id="main" class="site-main">

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				// Template part for large featured images.
				?>
					<header class="entry-header">
						<h1 class="entry-title">
							<?php echo wp_kses_post( get_the_title() ); ?>
						</h1>
					</header>

				<div class="main-content">

				</div><!-- .main-content -->

				<?php
				endwhile;
			?>
			<aside id="secondary" class="widget-area">
				<?php
					echo wp_kses_post( do_shortcode( '[govpack format=main id=' . get_the_ID() . ']' ) );
					do_action( 'before_sidebar' );
					dynamic_sidebar( \Newspack\Govpack\CPT\Profile::CPT_SLUG );
					do_action( 'after_sidebar' );
				?>
			</aside><!-- #secondary -->


		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();

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
		<?php
		/* Start the Loop */
		while ( have_posts() ) :
			the_post();
			?>
			<header class="page-header">
				<span>
				<h1 class="page-title">
					<span class="page-description"><?php echo wp_kses_post( get_the_title() ); ?></span>
				</h1>
				</span>
			</header>
		<?php endwhile; ?>

		<main id="main" class="site-main">
			<?php
			$current_post_type = get_post_type();

			if ( \Newspack\Govpack\CPT\Profile::CPT_SLUG === $current_post_type ) {
				$stories = \Newspack\Govpack\CPT\Profile::get_stories( get_the_ID() );
			} elseif ( \Newspack\Govpack\CPT\Issue::CPT_SLUG === $current_post_type ) {
				$stories = \Newspack\Govpack\CPT\Issue::get_stories( get_the_ID() );
			}

			if ( isset( $stories ) ) :
				$post_count = 0;

				while ( $stories->have_posts() ) :
					$post_count++;
					$stories->the_post();

					if ( 1 === $post_count && 0 === get_query_var( 'paged' ) ) {
						get_template_part( 'template-parts/content/content', 'excerpt' );
					} else {
						get_template_part( 'template-parts/content/content', 'archive' );
					}

				endwhile;
				wp_reset_postdata();
			endif;
			?>
		</main><!-- #main -->

		<aside id="secondary" class="widget-area">
			<?php
				echo wp_kses_post( do_shortcode( '[govpack format=main id=' . get_the_ID() . ']' ) );
				do_action( 'before_sidebar' );
				dynamic_sidebar( \Newspack\Govpack\CPT\Profile::CPT_SLUG );
				do_action( 'after_sidebar' );
			?>
		</aside><!-- #secondary -->

	</section><!-- #primary -->

<?php
get_footer();

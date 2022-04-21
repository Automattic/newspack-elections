<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Govpack issue archive template.
 *
 * @package Govpack
 */

// $issue_data is defined elsewhere.
// phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable

$post_count = 0;
$stories    = \Govpack\Block\IssueArchive::get_stories( $issue_data['id'], $atts['issue'] );

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

<?php
/**
 * The template for displaying a single report.
 *
 * @package Velstadt
 */

get_header();

while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/reports/single' );
endwhile;

get_footer();

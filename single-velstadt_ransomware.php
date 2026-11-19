<?php
/**
 * The template for displaying a single ransomware profile.
 *
 * @package Velstadt
 */

get_header();

while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/ransomware/single' );
endwhile;

get_footer();

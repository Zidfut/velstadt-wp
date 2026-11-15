<?php
/**
 * The template for displaying a single blog post.
 *
 * @package Velstadt
 */

get_header();

while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/post/single' );
endwhile;

get_footer();

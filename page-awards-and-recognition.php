<?php
/**
 * Awards & Recognition page template.
 *
 * Template Name: Awards & Recognition
 *
 * WordPress automatically uses this file for the page with the
 * awards-and-recognition slug.
 *
 * @package Velstadt
 */

get_header();
?>

	<main id="primary" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/awards/hero' );
			get_template_part( 'template-parts/awards/platforms' );
			get_template_part( 'template-parts/awards/rankings' );
			get_template_part( 'template-parts/awards/feedback' );
		endwhile;
		?>
	</main>

<?php
get_footer();

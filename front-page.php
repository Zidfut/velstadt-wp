<?php
/**
 * The front page template.
 *
 * @package Velstadt
 */

get_header();
?>

	<main id="primary" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/home/hero' );
			get_template_part( 'template-parts/home/partners' );
			get_template_part( 'template-parts/home/security' );
			get_template_part( 'template-parts/home/about' );
			get_template_part( 'template-parts/home/services' );
			get_template_part( 'template-parts/home/phantom' );
			get_template_part( 'template-parts/home/advantages' );
			get_template_part( 'template-parts/home/awards' );
			get_template_part( 'template-parts/home/expertise' );
			get_template_part( 'template-parts/home/customer' );
			get_template_part( 'template-parts/home/resources' );
			get_template_part( 'template-parts/home/blog' );
			get_template_part( 'template-parts/home/subs' );
			get_template_part( 'template-parts/home/cta' );
		endwhile;
		?>
	</main>

<?php
get_footer();

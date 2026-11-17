<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Velstadt
 */

?>

	<?php get_template_part( is_page_template( 'page-request-demo.php' ) ? 'template-parts/demo/footer' : 'template-parts/footer/site-footer' ); ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

<?php
/**
 * Home subscription section.
 *
 * @package Velstadt
 */

$has_scf  = function_exists( 'get_field' );
$show     = $has_scf ? (bool) get_field( 'home_subs_show' ) : true;
$title    = velstadt_get_home_field( 'home_subs_title', 'Velstadt Intelligence Brief' );
$subtitle = velstadt_get_home_field( 'home_subs_subtitle', 'Monthly threat research, practical recommendations, and executive insights.' );
$form     = velstadt_get_home_field( 'home_subs_form_shortcode', '' );

if ( ! $show ) {
	return;
}
?>
<section class="section subs">
	<div class="container subs__container section__lines">
		<div class="subs__text">
			<?php if ( $title ) : ?><h2 class="h2 subs__title"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
			<?php if ( $subtitle ) : ?><h3 class="h3 subs__subtitle"><?php echo esc_html( $subtitle ); ?></h3><?php endif; ?>
		</div>
		<?php if ( $form ) : ?>
			<?php echo do_shortcode( $form ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php endif; ?>
	</div>
</section>

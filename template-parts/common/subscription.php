<?php
/**
 * Shared newsletter subscription section.
 *
 * @package Velstadt
 *
 * @var array $args Template arguments.
 */

$show     = ! isset( $args['show'] ) || (bool) $args['show'];
$title    = isset( $args['title'] ) ? (string) $args['title'] : '';
$subtitle = isset( $args['subtitle'] ) ? (string) $args['subtitle'] : '';
$form     = isset( $args['form'] ) ? (string) $args['form'] : '';

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

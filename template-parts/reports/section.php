<?php
/**
 * Shared report cards section.
 *
 * @package Velstadt
 */

$report_ids = isset( $args['reports'] ) ? (array) $args['reports'] : array();
$subtitle = isset( $args['subtitle'] ) ? $args['subtitle'] : '';
$title = isset( $args['title'] ) ? $args['title'] : '';
$link = ! empty( $args['link'] ) ? velstadt_normalize_header_link( $args['link'] ) : null;
if ( ! $report_ids ) {
	return;
}
?>
<section class="section resources reports__section">
	<div class="section__header">
		<div class="container section__header-container section__lines">
			<div class="section__header-left">
				<?php if ( $subtitle ) : ?><span class="h3 section__subtitle"><?php echo esc_html( $subtitle ); ?></span><?php endif; ?>
				<?php if ( $title ) : ?><h2 class="h2 section__title"><?php echo nl2br( esc_html( $title ) ); ?></h2><?php endif; ?>
			</div>
			<?php if ( $link ) : ?><div class="section__header-right"><a class="link link--arrow" href="<?php echo esc_url( $link['url'] ); ?>"<?php if ( '_blank' === $link['target'] ) : ?> target="_blank" rel="noopener noreferrer"<?php endif; ?>><?php echo esc_html( $link['title'] ); ?></a></div><?php endif; ?>
		</div>
	</div>
	<div class="container section__lines report__related-grid">
		<?php foreach ( $report_ids as $report_id ) : ?>
			<?php get_template_part( 'template-parts/reports/card', null, array( 'post_id' => (int) $report_id ) ); ?>
		<?php endforeach; ?>
	</div>
</section>

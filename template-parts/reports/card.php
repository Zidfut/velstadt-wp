<?php
/**
 * Report catalog card.
 *
 * @package Velstadt
 *
 * @var array $args Template arguments.
 */

$report_id = isset( $args['post_id'] ) ? (int) $args['post_id'] : get_the_ID();
if ( ! $report_id ) {
	return;
}

$category  = velstadt_report_primary_category( $report_id );
$excerpt   = get_the_excerpt( $report_id );
$permalink = get_permalink( $report_id );
$classes   = 'reports__card' . ( ! empty( $args['class'] ) ? ' ' . sanitize_html_class( $args['class'] ) : '' );
?>
<article class="<?php echo esc_attr( $classes ); ?>" data-report-id="<?php echo esc_attr( $report_id ); ?>">
	<a class="reports__card-media" href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true">
		<?php if ( has_post_thumbnail( $report_id ) ) : ?>
			<?php echo get_the_post_thumbnail( $report_id, 'large', array( 'class' => 'reports__card-image' ) ); ?>
		<?php endif; ?>
		<?php if ( $category ) : ?><span class="reports__card-category"><?php echo esc_html( $category->name ); ?></span><?php endif; ?>
	</a>
	<div class="reports__card-body">
		<div class="reports__card-content">
			<h3><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( get_the_title( $report_id ) ); ?></a></h3>
			<?php if ( $excerpt ) : ?><p><?php echo esc_html( wp_strip_all_tags( $excerpt ) ); ?></p><?php endif; ?>
		</div>
		<p class="reports__card-meta"><span><?php esc_html_e( 'Velstadt Research', 'velstadt' ); ?> &middot; <?php echo esc_html( get_the_date( 'F j, Y', $report_id ) ); ?></span><img src="<?php echo esc_url( get_template_directory_uri() . '/markup/images/icons/arrow-narrow-up-right.svg' ); ?>" width="16" height="16" alt=""></p>
	</div>
</article>

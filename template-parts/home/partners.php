<?php
/**
 * Home Partners section.
 *
 * @package Velstadt
 */

$has_scf       = function_exists( 'get_field' );
$show_partners = $has_scf ? (bool) get_field( 'home_partners_show' ) : true;
$intro         = velstadt_get_home_field( 'home_partners_text', 'Chosen by teams that take security seriously' );
$stories_link  = velstadt_normalize_header_link( velstadt_get_home_field( 'home_partners_link', velstadt_header_default_link( 'Explore client stories' ) ), __( 'Explore client stories', 'velstadt' ) );
$partners      = velstadt_get_home_field( 'home_partners_items', array() );
$partners      = is_array( $partners ) ? $partners : array();

if ( ! $show_partners ) {
	return;
}

$stories_target = $stories_link['target'] ? ' target="' . esc_attr( $stories_link['target'] ) . '" rel="noopener noreferrer"' : '';
?>
<section class="section partners">
	<div class="container partners__container section__lines section__lines-white">
		<div class="partners__header">
			<?php if ( $intro ) : ?>
				<p><?php echo esc_html( $intro ); ?></p>
			<?php endif; ?>
			<?php if ( $stories_link['title'] ) : ?>
				<a href="<?php echo esc_url( $stories_link['url'] ); ?>" class="link--arrow"<?php echo $stories_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $stories_link['title'] ); ?></a>
			<?php endif; ?>
		</div>

		<?php if ( $partners ) : ?>
			<div class="partners__slider">
				<div class="partners__swiper swiper">
					<div class="swiper-wrapper">
						<?php foreach ( $partners as $partner ) : ?>
							<?php
							$logo_url = velstadt_header_image_url( isset( $partner['logo'] ) ? $partner['logo'] : null );
							$link     = ! empty( $partner['link'] ) ? velstadt_normalize_header_link( $partner['link'] ) : null;
							$target   = $link && $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : '';
							?>
							<?php if ( $logo_url ) : ?>
								<div class="swiper-slide">
									<?php if ( $link ) : ?>
										<a href="<?php echo esc_url( $link['url'] ); ?>"<?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
									<?php endif; ?>
									<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( isset( $partner['alt'] ) ? $partner['alt'] : '' ); ?>">
									<?php if ( $link ) : ?>
										</a>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>

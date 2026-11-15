<?php
/**
 * Home customer stories section.
 *
 * @package Velstadt
 */

$has_scf            = function_exists( 'get_field' );
$show               = $has_scf ? (bool) get_field( 'home_customer_show' ) : true;
$subtitle           = velstadt_get_home_field( 'home_customer_subtitle', 'Customer Stories' );
$title              = velstadt_get_home_field( 'home_customer_title', 'From signal to measurable impact' );
$archive_link_value = velstadt_get_home_field( 'home_customer_archive_link', velstadt_header_default_link( 'View customer stories' ) );
$archive_link       = $archive_link_value ? velstadt_normalize_header_link( $archive_link_value, __( 'View customer stories', 'velstadt' ) ) : null;
$items              = velstadt_get_home_field( 'home_customer_items', array() );
$items              = is_array( $items ) ? $items : array();

if ( ! $show ) {
	return;
}
?>
<section class="section customer">
	<div class="section__header">
		<div class="container section__header-container section__lines">
			<div class="section__header-left">
				<?php if ( $subtitle ) : ?><h3 class="h3 section__subtitle"><?php echo esc_html( $subtitle ); ?></h3><?php endif; ?>
				<?php if ( $title ) : ?><h2 class="h2 section__title"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
			</div>
			<?php if ( $archive_link && $archive_link['title'] ) : ?>
				<div class="section__header-right">
					<a href="<?php echo esc_url( $archive_link['url'] ); ?>" class="link link--arrow"<?php if ( $archive_link['target'] ) : ?> target="<?php echo esc_attr( $archive_link['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>><?php echo esc_html( $archive_link['title'] ); ?></a>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<?php if ( $items ) : ?>
		<div class="container customer__container customer__swiper swiper section__lines">
			<div class="swiper-wrapper">
				<?php foreach ( $items as $item ) : ?>
					<?php
					$link     = ! empty( $item['link'] ) ? velstadt_normalize_header_link( $item['link'] ) : null;
					$logo     = isset( $item['logo'] ) ? $item['logo'] : null;
					$logo_url = velstadt_header_image_url( $logo );
					$logo_alt = is_array( $logo ) && ! empty( $logo['alt'] ) ? $logo['alt'] : '';
					?>
					<?php if ( $link ) : ?>
						<a href="<?php echo esc_url( $link['url'] ); ?>" class="customer__card swiper-slide"<?php if ( $link['target'] ) : ?> target="<?php echo esc_attr( $link['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>>
					<?php else : ?>
						<div class="customer__card swiper-slide">
					<?php endif; ?>
						<?php if ( ! empty( $item['quote'] ) ) : ?><p class="customer__card-quote"><?php echo esc_html( $item['quote'] ); ?></p><?php endif; ?>
						<?php if ( ! empty( $item['stat'] ) || ! empty( $item['stat_label'] ) ) : ?>
							<div class="customer__card-info">
								<?php if ( ! empty( $item['stat'] ) ) : ?><span class="customer__card-issue"><?php echo esc_html( $item['stat'] ); ?></span><?php endif; ?>
								<?php if ( ! empty( $item['stat_label'] ) ) : ?><span class="customer__card-service"><?php echo esc_html( $item['stat_label'] ); ?></span><?php endif; ?>
							</div>
						<?php endif; ?>
						<?php if ( $logo_url ) : ?>
							<div class="customer__card-footer">
								<span class="<?php echo $link ? 'link--arrow' : ''; ?>">
									<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>" class="customer__card-logo">
								</span>
							</div>
						<?php endif; ?>
					<?php if ( $link ) : ?>
						</a>
					<?php else : ?>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>
</section>

<?php
/**
 * Home resources section.
 *
 * @package Velstadt
 */

$has_scf     = function_exists( 'get_field' );
$show        = $has_scf ? (bool) get_field( 'home_resources_show' ) : true;
$subtitle    = velstadt_get_home_field( 'home_resources_subtitle', 'Reports and Research' );
$title       = velstadt_get_home_field( 'home_resources_title', 'Intelligence for your next decision' );
$description = velstadt_get_home_field( 'home_resources_description', 'Proprietary intelligence for security leaders, technical teams, and executives—based on what Velstadt observes in real-world operations.' );
$items       = velstadt_get_home_field( 'home_resources_items', array() );
$items       = is_array( $items ) ? $items : array();

if ( ! $show ) {
	return;
}
?>
<section class="section resources">
	<div class="section__header">
		<div class="container section__header-container section__lines">
			<div class="section__header-left">
				<?php if ( $subtitle ) : ?><h3 class="h3 section__subtitle"><?php echo esc_html( $subtitle ); ?></h3><?php endif; ?>
				<?php if ( $title ) : ?><h2 class="h2 section__title"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
			</div>
			<?php if ( $description ) : ?><div class="section__header-right"><p><?php echo esc_html( $description ); ?></p></div><?php endif; ?>
		</div>
	</div>

	<?php if ( $items ) : ?>
		<div class="container section__lines swiper resources__swiper">
			<div class="swiper-wrapper">
				<?php foreach ( $items as $item ) : ?>
					<?php
					$link      = ! empty( $item['link'] ) ? velstadt_normalize_header_link( $item['link'] ) : null;
					$image     = isset( $item['image'] ) ? $item['image'] : null;
					$image_url = velstadt_header_image_url( $image );
					$image_alt = is_array( $image ) && ! empty( $image['alt'] ) ? $image['alt'] : ( $item['title'] ?? '' );
					?>
					<div class="resources__card swiper-slide">
						<?php if ( $link ) : ?>
							<a href="<?php echo esc_url( $link['url'] ); ?>" class="resources__card-preview"<?php if ( $link['target'] ) : ?> target="<?php echo esc_attr( $link['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>>
						<?php else : ?>
							<div class="resources__card-preview">
						<?php endif; ?>
							<?php if ( ! empty( $item['badge'] ) ) : ?><span class="resources__card-badge"><?php echo esc_html( $item['badge'] ); ?></span><?php endif; ?>
							<?php if ( $image_url ) : ?><img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="resources__card-img"><?php endif; ?>
						<?php if ( $link ) : ?>
							</a>
						<?php else : ?>
							</div>
						<?php endif; ?>

						<div class="resources__card-details">
							<?php if ( ! empty( $item['title'] ) ) : ?><h3 class="h3 resources__card-title"><?php echo esc_html( $item['title'] ); ?></h3><?php endif; ?>
							<?php if ( ! empty( $item['description'] ) ) : ?><p class="resources__card-description"><?php echo esc_html( $item['description'] ); ?></p><?php endif; ?>
							<?php if ( ! empty( $item['author'] ) || ! empty( $item['date'] ) ) : ?>
								<div class="resources__card-info">
									<?php if ( ! empty( $item['author'] ) ) : ?><span class="resources__card-author"><?php echo esc_html( $item['author'] ); ?></span><?php endif; ?>
									<?php if ( ! empty( $item['date'] ) ) : ?><span class="resources__card-date"><?php echo esc_html( $item['date'] ); ?></span><?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>
</section>

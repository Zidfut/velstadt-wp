<?php
/**
 * Awards page feedback section.
 *
 * @package Velstadt
 */

$show_section = function_exists( 'get_field' ) ? get_field( 'awards_feedback_show' ) : true;
if ( false === $show_section || 0 === $show_section || '0' === $show_section ) {
	return;
}

$subtitle = function_exists( 'get_field' ) ? get_field( 'awards_feedback_subtitle' ) : '';
$title    = function_exists( 'get_field' ) ? get_field( 'awards_feedback_title' ) : '';
$reviews  = function_exists( 'get_field' ) ? get_field( 'awards_feedback_items' ) : array();

$subtitle = $subtitle ?: 'Verified customer feedback';
$title    = $title ?: 'What our clients say';

if ( ! is_array( $reviews ) || ! $reviews ) {
	return;
}
?>
<section class="section feedback">
	<div class="section__header">
		<div class="container section__header-container section__lines">
			<div class="section__header-left">
				<?php if ( $subtitle ) : ?><h3 class="h3 section__subtitle"><?php echo esc_html( $subtitle ); ?></h3><?php endif; ?>
				<?php if ( $title ) : ?><h2 class="h2 section__title"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
			</div>
			<div class="section__header-right">
				<div class="feedback__arrows">
					<div class="feedback__arrow feedback__arrows-prev"></div>
					<div class="feedback__arrow feedback__arrows-next"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="container feedback__container section__lines">
		<div class="feedback__swiper swiper">
			<div class="swiper-wrapper">
				<?php foreach ( $reviews as $review ) : ?>
					<?php
					$rating   = isset( $review['rating'] ) ? $review['rating'] : '';
					$stars    = isset( $review['stars'] ) ? min( 5, max( 0, (int) $review['stars'] ) ) : 5;
					$label    = isset( $review['label'] ) ? $review['label'] : '';
					$quote    = isset( $review['quote'] ) ? $review['quote'] : '';
					$name     = isset( $review['name'] ) ? $review['name'] : '';
					$position = isset( $review['position'] ) ? $review['position'] : '';
					$logo     = isset( $review['logo'] ) ? $review['logo'] : '';
					$asset    = isset( $review['logo_asset'] ) ? $review['logo_asset'] : '';
					$logo_url = velstadt_header_image_url( $logo, $asset );
					?>
					<div class="feedback__card swiper-slide">
						<div class="feedback__card-top">
							<div class="feedback__card-rating">
								<div class="feedback__card-stars">
									<?php for ( $star = 0; $star < $stars; $star++ ) : ?><span class="star"></span><?php endfor; ?>
								</div>
								<?php if ( '' !== $rating ) : ?><span class="feedback__card-number"><?php echo esc_html( $rating ); ?></span><?php endif; ?>
							</div>
							<?php if ( $label ) : ?><div class="feedback__card-label"><?php echo esc_html( $label ); ?></div><?php endif; ?>
						</div>
						<?php if ( $quote ) : ?><div class="feedback__card-text"><p><?php echo esc_html( $quote ); ?></p></div><?php endif; ?>
						<div class="feedback__card-bot">
							<?php if ( $logo_url ) : ?><span class="feedback__card-icon"><img src="<?php echo esc_url( $logo_url ); ?>" alt=""></span><?php endif; ?>
							<?php if ( $name || $position ) : ?>
								<div class="feedback__card-author">
									<?php if ( $name ) : ?><span class="feedback__card-name"><?php echo esc_html( $name ); ?></span><?php endif; ?>
									<?php if ( $position ) : ?><span class="feedback__card-position"><?php echo esc_html( $position ); ?></span><?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

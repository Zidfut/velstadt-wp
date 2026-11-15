<?php
/**
 * Home Phantom section.
 *
 * @package Velstadt
 */

$has_scf     = function_exists( 'get_field' );
$show        = $has_scf ? (bool) get_field( 'home_phantom_show' ) : true;
$subtitle    = velstadt_get_home_field( 'home_phantom_subtitle', 'Phantom by Velstadt' );
$title       = velstadt_get_home_field( 'home_phantom_title', 'One view of external threats' );
$description = velstadt_get_home_field( 'home_phantom_description', 'The platform collects, enriches, and prioritizes data so your team sees the risks that truly matter.' );
$items       = velstadt_get_home_field( 'home_phantom_items', velstadt_home_default_phantom_items() );
$items       = is_array( $items ) ? array_values( $items ) : array();

if ( ! $show ) {
	return;
}
?>
<section class="section phantom">
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
		<div class="container phantom__container section__lines">
			<div class="phantom__block">
				<div class="phantom__tabs-wrap">
					<div class="phantom__tabs">
						<ul>
							<?php foreach ( $items as $index => $item ) : ?>
								<?php if ( ! empty( $item['title'] ) ) : ?>
									<li><a href="#" class="<?php echo 0 === $index ? 'active' : ''; ?>" data-tab="<?php echo esc_attr( (string) ( $index + 1 ) ); ?>"><?php echo esc_html( $item['title'] ); ?></a></li>
								<?php endif; ?>
							<?php endforeach; ?>
							<span class="phantom__tabs-indicator"></span>
						</ul>
					</div>
				</div>

				<div class="phantom__content">
					<?php foreach ( $items as $index => $item ) : ?>
						<?php
						$bullets     = ! empty( $item['bullets'] ) && is_array( $item['bullets'] ) ? $item['bullets'] : array();
						$demo_link   = ! empty( $item['demo_link'] ) ? velstadt_normalize_header_link( $item['demo_link'], __( 'Request a demo', 'velstadt' ) ) : null;
						$expert_link = ! empty( $item['expert_link'] ) ? velstadt_normalize_header_link( $item['expert_link'], __( 'Talk to an expert', 'velstadt' ) ) : null;
						$image        = isset( $item['image'] ) ? $item['image'] : null;
						$image_url    = velstadt_header_image_url( $image );
						$image_alt    = is_array( $image ) && ! empty( $image['alt'] ) ? $image['alt'] : ( $item['title'] ?? '' );
						?>
						<div class="phantom__item<?php echo 0 === $index ? ' active' : ''; ?>" data-tab-content="<?php echo esc_attr( (string) ( $index + 1 ) ); ?>">
							<div class="phantom__item-left">
								<span class="phantom__item-current">/<?php echo esc_html( str_pad( (string) count( $items ), 2, '0', STR_PAD_LEFT ) ); ?></span>
								<?php if ( ! empty( $item['title'] ) ) : ?><h3 class="h3 phantom__item-title"><?php echo esc_html( $item['title'] ); ?></h3><?php endif; ?>
								<?php if ( ! empty( $item['description'] ) ) : ?><p><?php echo esc_html( $item['description'] ); ?></p><?php endif; ?>
								<?php if ( $bullets ) : ?>
									<ul><?php foreach ( $bullets as $bullet ) : ?><?php if ( ! empty( $bullet['label'] ) ) : ?><li><?php echo esc_html( $bullet['label'] ); ?></li><?php endif; ?><?php endforeach; ?></ul>
								<?php endif; ?>
								<?php if ( $demo_link || $expert_link ) : ?>
									<div class="phantom__item-buttons">
										<?php if ( $demo_link ) : ?><a href="<?php echo esc_url( $demo_link['url'] ); ?>" class="btn btn--lg btn--primary"<?php if ( $demo_link['target'] ) : ?> target="<?php echo esc_attr( $demo_link['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>><?php echo esc_html( $demo_link['title'] ); ?></a><?php endif; ?>
										<?php if ( $expert_link ) : ?><a href="<?php echo esc_url( $expert_link['url'] ); ?>" class="btn btn--lg"<?php if ( $expert_link['target'] ) : ?> target="<?php echo esc_attr( $expert_link['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>><?php echo esc_html( $expert_link['title'] ); ?></a><?php endif; ?>
									</div>
								<?php endif; ?>
							</div>
							<?php if ( $image_url ) : ?>
								<div class="phantom__item-right">
									<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="phantom__item-img">
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
</section>

<?php
/**
 * Home services section.
 *
 * @package Velstadt
 */

$has_scf     = function_exists( 'get_field' );
$show        = $has_scf ? (bool) get_field( 'home_services_show' ) : true;
$subtitle    = velstadt_get_home_field( 'home_services_subtitle', 'Services' );
$title       = velstadt_get_home_field( 'home_services_title', 'Security built around your risks' );
$description = velstadt_get_home_field( 'home_services_description', 'Every engagement is focused on measurable outcomes: reduced risk, audit readiness, protected business continuity, or a stronger security model.' );
$services    = velstadt_get_home_field( 'home_services_items', array() );
$services    = is_array( $services ) ? $services : array();

if ( ! $show ) {
	return;
}
?>
<section class="section services">
	<div class="section__header">
		<div class="container section__header-container section__lines">
			<div class="section__header-left">
				<?php if ( $subtitle ) : ?><h3 class="h3 section__subtitle"><?php echo esc_html( $subtitle ); ?></h3><?php endif; ?>
				<?php if ( $title ) : ?><h2 class="h2 section__title"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
			</div>
			<?php if ( $description ) : ?><div class="section__header-right"><p><?php echo esc_html( $description ); ?></p></div><?php endif; ?>
		</div>
	</div>

	<?php if ( $services ) : ?>
		<div class="container services__container section__lines">
			<div class="services__accardion">
				<div class="services__accardion-list">
					<?php foreach ( $services as $index => $service ) : ?>
						<?php
						$bullets   = ! empty( $service['bullets'] ) && is_array( $service['bullets'] ) ? $service['bullets'] : array();
						$link      = ! empty( $service['link'] ) ? velstadt_normalize_header_link( $service['link'], __( 'Learn more', 'velstadt' ) ) : null;
						$target    = $link && $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : '';
						$image_url = velstadt_header_image_url( isset( $service['image'] ) ? $service['image'] : null );
						?>
						<div class="services__accardion-item<?php echo 0 === $index ? ' active' : ''; ?>">
							<div class="services__accardion-header">
								<?php if ( ! empty( $service['number'] ) ) : ?><span class="services__accardion-number"><?php echo esc_html( $service['number'] ); ?></span><?php endif; ?>
								<?php if ( ! empty( $service['title'] ) ) : ?><h3 class="h3 services__accardion-title"><?php echo esc_html( $service['title'] ); ?></h3><?php endif; ?>
							</div>
							<div class="services__accardion-content-wrapper">
								<div class="services__accardion-content">
									<?php if ( ! empty( $service['description'] ) ) : ?><p><?php echo esc_html( $service['description'] ); ?></p><?php endif; ?>
									<?php if ( $bullets ) : ?>
										<ul><?php foreach ( $bullets as $bullet ) : ?><?php if ( ! empty( $bullet['label'] ) ) : ?><li><?php echo esc_html( $bullet['label'] ); ?></li><?php endif; ?><?php endforeach; ?></ul>
									<?php endif; ?>
									<?php if ( $link ) : ?><a href="<?php echo esc_url( $link['url'] ); ?>" class="link link--arrow"<?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $link['title'] ); ?></a><?php endif; ?>
								</div>
								<?php if ( $image_url ) : ?><img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( isset( $service['title'] ) ? $service['title'] : '' ); ?>" class="services__accardion-img"><?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
</section>

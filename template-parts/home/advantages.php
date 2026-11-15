<?php
/**
 * Home advantages section.
 *
 * @package Velstadt
 */

$has_scf            = function_exists( 'get_field' );
$show               = $has_scf ? (bool) get_field( 'home_advantages_show' ) : true;
$subtitle           = velstadt_get_home_field( 'home_advantages_subtitle', 'Velstadt in numbers' );
$title              = velstadt_get_home_field( 'home_advantages_title', 'Security at scale. Proven in practice' );
$description        = velstadt_get_home_field( 'home_advantages_description', 'A snapshot of the coverage, data volume, and intelligence behind our operations.' );
$feature_value      = velstadt_get_home_field( 'home_advantages_feature_value', '~40%' );
$feature_title      = velstadt_get_home_field( 'home_advantages_feature_title', 'Faster threat response' );
$feature_description = velstadt_get_home_field( 'home_advantages_feature_description', 'Reduced response time through mature workflows, analysts, and automation.' );
$cards              = velstadt_get_home_field( 'home_advantages_cards', velstadt_home_default_advantages_cards() );
$cards              = is_array( $cards ) ? $cards : array();

if ( ! $show ) {
	return;
}
?>
<section class="section advantages">
	<div class="section__header">
		<div class="container section__header-container section__lines">
			<div class="section__header-left">
				<?php if ( $subtitle ) : ?><h3 class="h3 section__subtitle"><?php echo esc_html( $subtitle ); ?></h3><?php endif; ?>
				<?php if ( $title ) : ?><h2 class="h2 section__title"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
			</div>
			<?php if ( $description ) : ?><div class="section__header-right"><p><?php echo esc_html( $description ); ?></p></div><?php endif; ?>
		</div>
	</div>

	<div class="container advantages__container section__lines">
		<?php if ( $feature_value || $feature_title || $feature_description ) : ?>
			<div class="advantages__main">
				<div class="advantages__preview">
					<?php if ( $feature_value ) : ?><span class="advantages__preview-numbers"><?php echo esc_html( $feature_value ); ?></span><?php endif; ?>
					<?php if ( $feature_title ) : ?><h3 class="h3 advantages__preview-title"><?php echo esc_html( $feature_title ); ?></h3><?php endif; ?>
					<?php if ( $feature_description ) : ?><span class="advantages__preview-description"><?php echo esc_html( $feature_description ); ?></span><?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $cards ) : ?>
			<div class="advantages__grid">
				<?php foreach ( $cards as $card ) : ?>
					<div class="advantages__card">
						<?php if ( ! empty( $card['value'] ) ) : ?><span class="advantages__card-numbers"><?php echo esc_html( $card['value'] ); ?></span><?php endif; ?>
						<?php if ( ! empty( $card['title'] ) ) : ?><h3 class="h3 advantages__card-title"><?php echo esc_html( $card['title'] ); ?></h3><?php endif; ?>
						<?php if ( ! empty( $card['description'] ) ) : ?><span class="advantages__card-description"><?php echo esc_html( $card['description'] ); ?></span><?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

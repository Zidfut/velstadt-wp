<?php
/**
 * Home about section.
 *
 * @package Velstadt
 */

$has_scf     = function_exists( 'get_field' );
$show        = $has_scf ? (bool) get_field( 'home_about_show' ) : true;
$subtitle    = velstadt_get_home_field( 'home_about_subtitle', 'Why Velstadt' );
$title       = velstadt_get_home_field( 'home_about_title', 'Intelligence that drives better decisions' );
$description = velstadt_get_home_field( 'home_about_description', 'Technical depth for security teams. Business clarity for leadership. One trusted partner at every stage.' );
$cards       = velstadt_get_home_field( 'home_about_cards', velstadt_home_default_about_cards() );
$cards       = is_array( $cards ) ? $cards : array();

if ( ! $show ) {
	return;
}
?>
<section class="section about">
	<div class="section__header">
		<div class="container section__header-container section__lines">
			<div class="section__header-left">
				<?php if ( $subtitle ) : ?><h3 class="h3 section__subtitle"><?php echo esc_html( $subtitle ); ?></h3><?php endif; ?>
				<?php if ( $title ) : ?><h2 class="h2 section__title"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
			</div>
			<?php if ( $description ) : ?><div class="section__header-right"><p><?php echo esc_html( $description ); ?></p></div><?php endif; ?>
		</div>
	</div>

	<?php if ( $cards ) : ?>
		<div class="container about__container section__lines">
			<?php foreach ( $cards as $card ) : ?>
				<?php $icon_url = velstadt_header_image_url( isset( $card['icon'] ) ? $card['icon'] : null ); ?>
				<div class="about__card">
					<?php if ( $icon_url ) : ?><span class="about__card-icon" style="background-image: url('<?php echo esc_url( $icon_url ); ?>');"></span><?php endif; ?>
					<?php if ( ! empty( $card['title'] ) ) : ?><h3 class="h3 about__card-title"><?php echo esc_html( $card['title'] ); ?></h3><?php endif; ?>
					<?php if ( ! empty( $card['description'] ) ) : ?><p class="about__card-description"><?php echo esc_html( $card['description'] ); ?></p><?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>

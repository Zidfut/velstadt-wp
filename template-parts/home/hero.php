<?php
/**
 * Home Hero section.
 *
 * @package Velstadt
 */

$has_scf     = function_exists( 'get_field' );
$show_hero   = $has_scf ? (bool) get_field( 'home_hero_show' ) : true;
$subtitle    = velstadt_get_home_field( 'home_hero_subtitle', 'Threat intelligence built for action' );
$title       = velstadt_get_home_field( 'home_hero_title', 'Threats become visible' );
$highlight   = velstadt_get_home_field( 'home_hero_highlight', 'before the incident' );
$description = velstadt_get_home_field( 'home_hero_description', 'The Velstadt platform and experts help uncover critical risks before they become incidents' );
$expert_link = velstadt_normalize_header_link( velstadt_get_home_field( 'home_hero_expert_link', velstadt_header_default_link( 'Talk to an expert' ) ), __( 'Talk to an expert', 'velstadt' ) );
$demo_link   = velstadt_normalize_header_link( velstadt_get_home_field( 'home_hero_demo_link', velstadt_header_default_link( 'Request a demo' ) ), __( 'Request a demo', 'velstadt' ) );
$image       = velstadt_get_home_field( 'home_hero_image' );
$image_url   = velstadt_header_image_url( $image, 'stories-book.png' );
$image_alt   = velstadt_get_home_field( 'home_hero_image_alt', '' );

if ( ! $show_hero ) {
	return;
}

$expert_target = $expert_link['target'] ? ' target="' . esc_attr( $expert_link['target'] ) . '" rel="noopener noreferrer"' : '';
$demo_target   = $demo_link['target'] ? ' target="' . esc_attr( $demo_link['target'] ) . '" rel="noopener noreferrer"' : '';
?>
<section class="section hero">
	<div class="header__duplicate">
		<div class="container header__duplicate-container section__lines section__lines-white"></div>
	</div>
	<div class="container hero__container section__lines section__lines-white">
		<div class="hero__content">
			<?php if ( $subtitle ) : ?>
				<h3 class="h3 hero__subtitle"><?php echo esc_html( $subtitle ); ?></h3>
			<?php endif; ?>
			<h1 class="h1 hero__title">
				<?php echo esc_html( $title ); ?>
				<?php if ( $highlight ) : ?>
					<span><?php echo esc_html( $highlight ); ?></span>
				<?php endif; ?>
			</h1>
			<?php if ( $description ) : ?>
				<h2 class="h2 hero__description"><?php echo esc_html( $description ); ?></h2>
			<?php endif; ?>
			<div class="hero__buttons">
				<a href="<?php echo esc_url( $expert_link['url'] ); ?>" class="btn btn--lg btn--transparent"<?php echo $expert_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $expert_link['title'] ); ?></a>
				<a href="<?php echo esc_url( $demo_link['url'] ); ?>" class="btn btn--lg btn--primary"<?php echo $demo_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $demo_link['title'] ); ?></a>
			</div>
		</div>

		<?php if ( $image_url ) : ?>
			<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="hero__img">
		<?php endif; ?>
	</div>
</section>

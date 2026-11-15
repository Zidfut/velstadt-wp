<?php
/**
 * Home CTA section.
 *
 * @package Velstadt
 */

$has_scf          = function_exists( 'get_field' );
$show             = $has_scf ? (bool) get_field( 'home_cta_show' ) : true;
$eyebrow          = velstadt_get_home_field( 'home_cta_eyebrow', 'Next step' );
$title            = velstadt_get_home_field( 'home_cta_title', 'See the threats that matter to your organization' );
$subtitle         = velstadt_get_home_field( 'home_cta_subtitle', 'Get a platform demo or discuss current risks with a Velstadt expert.' );
$demo_link_value  = velstadt_get_home_field( 'home_cta_demo_link', velstadt_header_default_link( 'Request a demo' ) );
$expert_link_value = velstadt_get_home_field( 'home_cta_expert_link', velstadt_header_default_link( 'Talk to an expert' ) );
$demo_link        = $demo_link_value ? velstadt_normalize_header_link( $demo_link_value, __( 'Request a demo', 'velstadt' ) ) : null;
$expert_link      = $expert_link_value ? velstadt_normalize_header_link( $expert_link_value, __( 'Talk to an expert', 'velstadt' ) ) : null;

if ( ! $show ) {
	return;
}
?>
<section class="section cta">
	<div class="container cta__container section__lines">
		<div class="cta__wrap">
			<div class="cta__block">
				<div class="cta__content">
					<?php if ( $eyebrow ) : ?><span class="cta__step"><?php echo esc_html( $eyebrow ); ?></span><?php endif; ?>
					<?php if ( $title ) : ?><h2 class="h2 cta__title"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
					<?php if ( $subtitle ) : ?><h3 class="h3 cta__subtitle"><?php echo esc_html( $subtitle ); ?></h3><?php endif; ?>
					<?php if ( $demo_link || $expert_link ) : ?>
						<div class="cta__buttons">
							<?php if ( $demo_link ) : ?><a href="<?php echo esc_url( $demo_link['url'] ); ?>" class="btn btn--lg btn--primary"<?php if ( $demo_link['target'] ) : ?> target="<?php echo esc_attr( $demo_link['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>><?php echo esc_html( $demo_link['title'] ); ?></a><?php endif; ?>
							<?php if ( $expert_link ) : ?><a href="<?php echo esc_url( $expert_link['url'] ); ?>" class="btn btn--lg btn--transparent"<?php if ( $expert_link['target'] ) : ?> target="<?php echo esc_attr( $expert_link['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>><?php echo esc_html( $expert_link['title'] ); ?></a><?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>

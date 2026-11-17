<?php
/**
 * Template Name: Request a Demo
 * Template Post Type: page
 * @package Velstadt
 */
get_header();
$field = static function ( $name ) {
	return function_exists( 'get_field' ) ? get_field( $name ) : null;
};
$benefits = (array) $field( 'demo_benefits' );
$ratings = (array) $field( 'demo_ratings' );
$badges = (array) $field( 'demo_badges' );
$form = $field( 'demo_form_shortcode' );
$success_link = $field( 'demo_success_link' );
$calendar_url = $field( 'demo_calendar_url' );
$image_styles = array();
foreach ( array( 'check', 'star', 'chevron', 'checkbox' ) as $icon ) {
	$url = wp_get_attachment_image_url( (int) $field( 'demo_' . $icon . '_icon' ), 'full' );
	if ( $url ) {
		$image_styles[] = '--demo-' . $icon . ':url("' . esc_url( $url ) . '")';
	}
}
?>
<main id="primary" class="request-demo" style="<?php echo esc_attr( implode( ';', $image_styles ) ); ?>">
	<div class="container request-demo__container">
		<div class="request-demo__intro">
			<div class="request-demo__copy">
				<div class="request-demo__heading">
					<p class="request-demo__eyebrow"><?php if ( $field( 'demo_eyebrow_icon' ) ) { echo wp_get_attachment_image( (int) $field( 'demo_eyebrow_icon' ), 'full', false, array( 'alt' => '' ) ); } ?><?php echo esc_html( $field( 'demo_eyebrow' ) ); ?></p>
					<h1><?php echo esc_html( $field( 'demo_title' ) ); ?></h1>
				</div>
				<div class="request-demo__benefits">
					<h2><?php echo esc_html( $field( 'demo_benefits_title' ) ); ?></h2>
					<ul><?php foreach ( $benefits as $benefit ) : ?>
						<li><h3><?php echo esc_html( $benefit['title'] ?? '' ); ?></h3><p><?php echo esc_html( $benefit['description'] ?? '' ); ?></p></li>
					<?php endforeach; ?></ul>
				</div>
			</div>
			<div class="request-demo__proof">
				<?php if ( $ratings ) : ?><ul class="request-demo__ratings">
					<?php foreach ( $ratings as $rating ) : ?>
						<li><div class="request-demo__rating-logo"><?php echo wp_get_attachment_image( (int) ( $rating['logo'] ?? 0 ), 'full', false, array( 'alt' => '' ) ); ?></div><div><span><?php echo esc_html( $rating['name'] ?? '' ); ?></span><span class="request-demo__rating-value"><?php echo esc_html( $rating['value'] ?? '' ); ?></span></div></li>
					<?php endforeach; ?>
				</ul><?php endif; ?>
				<?php if ( $badges ) : ?><ul class="request-demo__badges">
					<?php foreach ( $badges as $badge ) : ?><li><?php echo wp_get_attachment_image( (int) ( $badge['image'] ?? 0 ), 'full' ); ?></li><?php endforeach; ?>
				</ul><?php endif; ?>
			</div>
		</div>
		<div class="request-demo__panel-wrap">
			<section class="request-demo__panel" aria-labelledby="demo-form-title" data-demo-panel>
				<div data-demo-form>
					<h2 id="demo-form-title"><?php echo esc_html( $field( 'demo_form_title' ) ); ?></h2>
					<?php
					if ( $form && shortcode_exists( 'contact-form-7' ) ) {
						$form_html = new WP_HTML_Tag_Processor( do_shortcode( $form ) );
						if ( $form_html->next_tag( array( 'tag_name' => 'FORM', 'class_name' => 'wpcf7-form' ) ) ) {
							$form_html->add_class( 'custom__form' );
							$form_html->add_class( 'request-demo__form' );
						}
						echo $form_html->get_updated_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
					?>
				</div>
				<div class="request-demo__success" data-demo-success hidden>
					<div class="request-demo__success-message">
						<?php if ( $field( 'demo_success_icon' ) ) : ?><span class="request-demo__success-icon"><?php echo wp_get_attachment_image( (int) $field( 'demo_success_icon' ), 'full', false, array( 'alt' => '' ) ); ?></span><?php endif; ?>
						<h2 tabindex="-1" data-demo-success-title><?php echo esc_html( $field( 'demo_success_title' ) ); ?></h2>
						<p data-demo-success-description data-template="<?php echo esc_attr( $field( 'demo_success_description' ) ); ?>"><?php echo esc_html( str_replace( '{email}', '', (string) $field( 'demo_success_description' ) ) ); ?></p>
					</div>
					<div class="request-demo__success-actions">
						<?php if ( $calendar_url ) : ?><a href="<?php echo esc_url( $calendar_url ); ?>" class="btn btn--primary btn--lg" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $field( 'demo_calendar_label' ) ); ?></a><?php endif; ?>
						<?php if ( is_array( $success_link ) && ! empty( $success_link['url'] ) ) : ?><a href="<?php echo esc_url( $success_link['url'] ); ?>" class="btn btn--lg"<?php if ( ! empty( $success_link['target'] ) ) : ?> target="<?php echo esc_attr( $success_link['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>><?php echo esc_html( $success_link['title'] ); ?></a><?php endif; ?>
					</div>
				</div>
			</section>
		</div>
	</div>
</main>
<?php get_footer(); ?>

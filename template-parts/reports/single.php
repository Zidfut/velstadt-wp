<?php
/**
 * Single report layout.
 *
 * @package Velstadt
 */

$report_id   = get_the_ID();
$category    = velstadt_report_primary_category( $report_id );
$catalog     = get_page_by_path( 'reports' );
$catalog_url = $catalog ? get_permalink( $catalog ) : home_url( '/reports/' );
$details     = function_exists( 'get_fields' ) ? ( get_fields( $report_id ) ?: array() ) : array();
$page_count  = absint( $details['report_page_count'] ?? 0 );
$audience    = $details['report_audience'] ?? '';
$downloads   = $details['report_download_count'] ?? '';
$shortcode   = trim( (string) ( $details['report_form_shortcode'] ?? '' ) );
$form_markup = '';
if ( shortcode_exists( 'contact-form-7' ) && has_shortcode( $shortcode, 'contact-form-7' ) ) {
	$form_html = new WP_HTML_Tag_Processor( do_shortcode( $shortcode ) );
	if ( $form_html->next_tag( array( 'tag_name' => 'FORM', 'class_name' => 'wpcf7-form' ) ) ) {
		$form_html->add_class( 'custom__form' );
		$form_markup = $form_html->get_updated_html();
	}
}
$headline    = ( $details['report_detail_headline'] ?? '' ) ?: get_the_title();
$intro       = ( $details['report_detail_intro'] ?? '' ) ?: ( has_excerpt() ? get_the_excerpt() : '' );
$cover_id    = (int) ( $details['report_detail_cover'] ?? 0 );
$cover       = wp_get_attachment_image( $cover_id, 'large' ) ?: get_the_post_thumbnail( $report_id, 'large' );
$related_ids = velstadt_get_related_report_ids( $report_id, $category );
?>
<main id="primary" class="page post report__page">
	<div class="header__duplicate header__duplicate--dark"><div class="container header__duplicate-container section__lines"></div></div>
	<nav class="breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumbs', 'velstadt' ); ?>">
		<div class="container breadcrumbs__container section__lines">
			<ul>
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'velstadt' ); ?></a></li>
				<li><a href="<?php echo esc_url( $catalog_url ); ?>"><?php esc_html_e( 'Reports', 'velstadt' ); ?></a></li>
				<li><span aria-current="page"><?php echo esc_html( $headline ); ?></span></li>
			</ul>
		</div>
	</nav>

	<article <?php post_class( 'report' ); ?>>
		<header class="report__hero">
			<div class="container section__lines report__columns<?php echo $cover ? '' : ' report__columns--wide'; ?>">
				<div class="report__intro">
					<div class="report__heading">
						<?php if ( $category ) : ?><span class="report__category"><?php echo esc_html( $category->name ); ?></span><?php endif; ?>
						<h1><?php echo esc_html( $headline ); ?></h1>
						<?php if ( $intro ) : ?><p><?php echo esc_html( $intro ); ?></p><?php endif; ?>
					</div>
					<dl class="report__facts">
						<?php if ( $page_count ) : ?>
							<div><dt><?php esc_html_e( 'PDF report', 'velstadt' ); ?></dt><dd><?php echo esc_html( sprintf( _n( '%s page', '%s pages', $page_count, 'velstadt' ), number_format_i18n( $page_count ) ) ); ?></dd></div>
						<?php endif; ?>
						<?php if ( $audience ) : ?>
							<div><dt><?php esc_html_e( 'For security leaders', 'velstadt' ); ?></dt><dd><?php echo esc_html( $audience ); ?></dd></div>
						<?php endif; ?>
						<div><dt><?php esc_html_e( 'Publication date', 'velstadt' ); ?></dt><dd><time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></dd></div>
						<?php if ( is_numeric( $downloads ) ) : ?>
							<div><dt><?php esc_html_e( 'Report downloads', 'velstadt' ); ?></dt><dd><?php echo esc_html( number_format_i18n( absint( $downloads ) ) ); ?></dd></div>
						<?php endif; ?>
					</dl>
				</div>
				<?php if ( $cover ) : ?>
					<div class="report__cover"><div class="report__cover-frame"><?php echo $cover; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div></div>
				<?php endif; ?>
			</div>
		</header>

		<div class="container section__lines report__columns report__body<?php echo $form_markup ? '' : ' report__columns--wide'; ?>">
			<div class="page__content report__content">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
				<?php get_template_part( 'template-parts/reports/research-team', null, array( 'author_ids' => $details['report_research_authors'] ?? array() ) ); ?>
			</div>
			<?php if ( $form_markup ) : ?>
				<aside class="report__sidebar" aria-labelledby="report-form-title">
					<div class="report__form">
						<span><?php esc_html_e( 'Free report', 'velstadt' ); ?></span>
						<h2 id="report-form-title"><?php esc_html_e( 'Get the full analysis', 'velstadt' ); ?></h2>
						<p><?php esc_html_e( 'Request a copy using your work email', 'velstadt' ); ?></p>
						<?php echo $form_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				</aside>
			<?php endif; ?>
		</div>
	</article>

	<?php if ( $related_ids ) : ?>
		<section class="section report__related" aria-labelledby="report-related-title">
			<div class="container section__lines report__related-header">
				<h2 id="report-related-title"><?php esc_html_e( 'Related reports', 'velstadt' ); ?></h2>
				<a class="link link--arrow" href="<?php echo esc_url( $catalog_url ); ?>"><?php esc_html_e( 'View all reports', 'velstadt' ); ?></a>
			</div>
			<div class="container section__lines report__related-grid">
				<?php foreach ( $related_ids as $related_id ) : ?>
					<?php get_template_part( 'template-parts/reports/card', null, array( 'post_id' => $related_id ) ); ?>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>
</main>

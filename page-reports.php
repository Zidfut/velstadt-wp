<?php
/**
 * Template Name: Reports
 *
 * @package Velstadt
 */

$page_id     = get_queried_object_id();
$catalog_url = get_permalink( $page_id );
$catalog     = velstadt_reports_catalog_query( $page_id );
$reports     = $catalog['query'];
$featured_id = (int) velstadt_get_reports_page_field( 'reports_featured_report', $page_id, 0 );
$categories  = get_terms(
	array(
		'taxonomy'   => 'report_category',
		'hide_empty' => false,
		'orderby'    => 'term_id',
		'order'      => 'ASC',
	)
);
$filter_url  = static function ( $category ) use ( $catalog_url ) {
	return add_query_arg( array_filter( array( 'report_category' => $category ) ), $catalog_url );
};

get_header();
?>
<main id="primary" class="page reports__page" data-reports-catalog>
	<div class="header__duplicate header__duplicate--dark"><div class="container header__duplicate-container section__lines"></div></div>
	<header class="reports__hero">
		<div class="container section__lines reports__hero-container">
			<span class="reports__eyebrow"><?php echo esc_html( velstadt_get_reports_page_field( 'reports_hero_eyebrow', $page_id, __( 'Velstadt research', 'velstadt' ) ) ); ?></span>
			<h1><?php echo esc_html( velstadt_get_reports_page_field( 'reports_hero_title', $page_id, get_the_title( $page_id ) ?: __( 'Reports & Research', 'velstadt' ) ) ); ?></h1>
			<?php $hero_description = velstadt_get_reports_page_field( 'reports_hero_description', $page_id, get_the_excerpt( $page_id ) ); ?>
			<?php if ( $hero_description ) : ?><p><?php echo esc_html( $hero_description ); ?></p><?php endif; ?>
		</div>
	</header>

	<section class="reports__catalog" aria-label="<?php esc_attr_e( 'Reports and research', 'velstadt' ); ?>">

		<div class="reports__catalog-section">
			<div class="container section__lines reports__catalog-container">
				<?php if ( $featured_id && 'velstadt_report' === get_post_type( $featured_id ) && 'publish' === get_post_status( $featured_id ) ) : ?>
					<div class="reports__featured">
						<?php get_template_part( 'template-parts/reports/card', null, array( 'post_id' => $featured_id, 'class' => 'reports__card--featured' ) ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="reports__catalog-section">
			<div class="container section__lines reports__catalog-container">
				<nav class="reports__categories" aria-label="<?php esc_attr_e( 'Filter reports by category', 'velstadt' ); ?>">
					<ul>
						<li><a href="<?php echo esc_url( $filter_url( '' ) ); ?>" data-reports-filter<?php if ( ! $catalog['category'] ) : ?> aria-current="page"<?php endif; ?>><?php echo esc_html( velstadt_get_reports_page_field( 'reports_all_label', $page_id, __( 'All', 'velstadt' ) ) ); ?></a></li>
						<?php if ( ! is_wp_error( $categories ) ) : ?>
							<?php foreach ( $categories as $category ) : ?>
								<li><a href="<?php echo esc_url( $filter_url( $category->slug ) ); ?>" data-reports-filter<?php if ( $catalog['category'] === $category->slug ) : ?> aria-current="page"<?php endif; ?>><?php echo esc_html( $category->name ); ?></a></li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>
				</nav>
			</div>
		</div>

		<div class="reports__catalog-section">
			<div class="container section__lines reports__catalog-container reports__catalog-grid">
				<div class="reports__results" data-reports-results>
				<div class="reports__grid" data-reports-grid>
					<?php foreach ( $reports->posts as $report ) : ?>
						<?php get_template_part( 'template-parts/reports/card', null, array( 'post_id' => $report->ID ) ); ?>
					<?php endforeach; ?>
				</div>

				<?php if ( ! $reports->have_posts() ) : ?>
					<p class="reports__empty"><?php echo esc_html( velstadt_get_reports_page_field( 'reports_empty_message', $page_id, __( 'No reports found.', 'velstadt' ) ) ); ?></p>
				<?php endif; ?>

				<?php if ( $catalog['page'] < $reports->max_num_pages ) : ?>
					<div class="reports__more">
						<a class="btn" data-reports-more href="<?php echo esc_url( add_query_arg( 'report_page', $catalog['page'] + 1, $filter_url( $catalog['category'] ) ) ); ?>"><?php echo esc_html( velstadt_get_reports_page_field( 'reports_load_more_label', $page_id, __( 'Load more', 'velstadt' ) ) ); ?></a>
					</div>
				<?php endif; ?>
				<span class="screen-reader-text" data-reports-count><?php echo esc_html( sprintf( __( '%d reports found.', 'velstadt' ), $reports->found_posts ) ); ?></span>
				</div>
				<p class="screen-reader-text" data-reports-status role="status" aria-live="polite"></p>
			</div>
		</div>
	</section>

	<?php
	$reports_form = velstadt_get_reports_page_field( 'reports_subs_form_shortcode', $page_id, '' );
	if ( ! $reports_form && function_exists( 'get_field' ) ) {
		$reports_form = get_field( 'home_subs_form_shortcode', (int) get_option( 'page_on_front' ) );
	}
	get_template_part(
		'template-parts/common/subscription',
		null,
		array(
			'show'     => velstadt_get_reports_page_toggle( 'reports_subs_show', $page_id, true ),
			'title'    => velstadt_get_reports_page_field( 'reports_subs_title', $page_id, __( 'Research worth your time', 'velstadt' ) ),
			'subtitle' => velstadt_get_reports_page_field( 'reports_subs_subtitle', $page_id, __( 'Get new threat research, technical findings, and practical guidance from Velstadt specialists.', 'velstadt' ) ),
			'form'     => $reports_form,
		)
	);
	?>
</main>
<?php
get_footer();

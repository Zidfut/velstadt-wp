<?php
/**
 * Filterable awards timeline.
 *
 * @package Velstadt
 */

$show_section = function_exists( 'get_field' ) ? get_field( 'awards_rankings_show' ) : true;
if ( false === $show_section || 0 === $show_section || '0' === $show_section ) {
	return;
}

$section_subtitle = function_exists( 'get_field' ) ? get_field( 'awards_rankings_subtitle' ) : '';
$section_title    = function_exists( 'get_field' ) ? get_field( 'awards_rankings_title' ) : '';
$section_subtitle = $section_subtitle ?: 'Independent recognition';
$section_title    = $section_title ?: 'Awards and rankings';

$awards_query = new WP_Query(
	array(
		'post_type'      => 'award',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'meta_key'       => 'award_year',
		'orderby'        => array( 'meta_value_num' => 'DESC', 'date' => 'DESC' ),
	)
);
$awards_by_year = array();
$used_platforms = array();
$year_headings  = array();
$active_platform = isset( $_GET['platform'] ) ? sanitize_title( wp_unslash( $_GET['platform'] ) ) : 'all';
$year_sections  = function_exists( 'get_field' ) ? get_field( 'awards_year_sections', get_queried_object_id() ) : array();

if ( is_array( $year_sections ) ) {
	foreach ( $year_sections as $year_section ) {
		$configured_year = isset( $year_section['year'] ) ? (int) $year_section['year'] : 0;
		if ( $configured_year && ! empty( $year_section['heading'] ) ) {
			$year_headings[ $configured_year ] = $year_section['heading'];
		}
	}
}

foreach ( $awards_query->posts as $award ) {
	$year = (int) get_field( 'award_year', $award->ID );
	if ( ! $year ) {
		continue;
	}
	$terms = get_the_terms( $award->ID, 'award_platform' );
	$term  = $terms && ! is_wp_error( $terms ) ? reset( $terms ) : null;
	if ( $term ) {
		$used_platforms[ $term->slug ] = $term;
	}
	$awards_by_year[ $year ][] = array( 'post' => $award, 'platform' => $term );
}
wp_reset_postdata();

if ( ! $awards_by_year ) {
	return;
}
krsort( $awards_by_year, SORT_NUMERIC );
uasort( $used_platforms, static function ( $a, $b ) { return strcasecmp( $a->name, $b->name ); } );

if ( 'all' !== $active_platform && ! isset( $used_platforms[ $active_platform ] ) ) {
	$active_platform = 'all';
}
?>
<section class="section ranking" data-awards-filter>
	<div class="section__header">
		<div class="container section__header-container section__lines">
			<div class="section__header-left">
				<?php if ( $section_subtitle ) : ?><h3 class="h3 section__subtitle"><?php echo esc_html( $section_subtitle ); ?></h3><?php endif; ?>
				<?php if ( $section_title ) : ?><h2 class="h2 section__title"><?php echo esc_html( $section_title ); ?></h2><?php endif; ?>
			</div>
			<div class="section__header-right">
				<div class="ranking__filter-wrap">
					<div class="ranking__filter">
						<ul>
							<li><a href="<?php echo esc_url( remove_query_arg( 'platform' ) ); ?>" class="<?php echo 'all' === $active_platform ? 'active' : ''; ?>" data-award-platform="all">All</a></li>
							<?php foreach ( $used_platforms as $platform ) : ?>
								<li><a href="<?php echo esc_url( add_query_arg( 'platform', $platform->slug ) ); ?>" class="<?php echo $platform->slug === $active_platform ? 'active' : ''; ?>" data-award-platform="<?php echo esc_attr( $platform->slug ); ?>"><?php echo esc_html( $platform->name ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container ranking__container section__lines">
		<?php foreach ( $awards_by_year as $year => $awards ) : ?>
			<?php
			$year_has_visible_awards = 'all' === $active_platform;
			if ( ! $year_has_visible_awards ) {
				foreach ( $awards as $award_data ) {
					if ( $award_data['platform'] && $award_data['platform']->slug === $active_platform ) {
						$year_has_visible_awards = true;
						break;
					}
				}
			}
			?>
			<div class="ranking__timeline" data-award-year="<?php echo esc_attr( $year ); ?>"<?php echo $year_has_visible_awards ? '' : ' hidden'; ?>>
				<div class="ranking__timeline-left">
					<div class="ranking__timeline-header">
						<span class="ranking__timeline-icon"></span>
						<div class="ranking__timeline-text">
							<span class="ranking__timeline-year"><?php echo esc_html( $year ); ?></span>
							<h3 class="h3 ranking__timeline-heading"><?php echo esc_html( isset( $year_headings[ $year ] ) ? $year_headings[ $year ] : __( 'Awards and recognition', 'velstadt' ) ); ?></h3>
						</div>
					</div>
				</div>
				<div class="ranking__timeline-right">
					<?php foreach ( $awards as $award_data ) : ?>
						<?php
						$award      = $award_data['post'];
						$platform   = $award_data['platform'];
						$badge_url  = velstadt_get_award_badge_url( $award->ID );
						$platform_slug = $platform ? $platform->slug : 'uncategorized';
						$is_visible = 'all' === $active_platform || $platform_slug === $active_platform;
						?>
						<div class="ranking__timeline-item" data-award-item data-platform="<?php echo esc_attr( $platform_slug ); ?>"<?php echo $is_visible ? '' : ' hidden'; ?>>
							<?php if ( $badge_url ) : ?><img src="<?php echo esc_url( $badge_url ); ?>" alt="" class="ranking__timeline-logo"><?php endif; ?>
							<div class="ranking__timeline-text">
								<h3 class="h3 ranking__timeline-title"><?php echo esc_html( get_the_title( $award ) ); ?></h3>
								<?php if ( $platform ) : ?><span class="ranking__timeline-name"><?php echo esc_html( $platform->name ); ?></span><?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

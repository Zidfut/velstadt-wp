<?php
/**
 * Blog posts page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#home-page-display
 *
 * @package Velstadt
 */

$blog_page_id = (int) get_option( 'page_for_posts' );
$blog_url     = $blog_page_id ? get_permalink( $blog_page_id ) : home_url( '/blog/' );

$hero_show        = function_exists( 'get_field' ) ? get_field( 'blog_hero_show', $blog_page_id ) : true;
$hero_subtitle    = function_exists( 'get_field' ) ? get_field( 'blog_hero_subtitle', $blog_page_id ) : '';
$hero_title       = function_exists( 'get_field' ) ? get_field( 'blog_hero_title', $blog_page_id ) : '';
$hero_description = function_exists( 'get_field' ) ? get_field( 'blog_hero_description', $blog_page_id ) : '';
$hero_note        = function_exists( 'get_field' ) ? get_field( 'blog_hero_note', $blog_page_id ) : '';
$featured_id      = function_exists( 'get_field' ) ? (int) get_field( 'blog_featured_post', $blog_page_id ) : 0;
$posts_per_page   = function_exists( 'get_field' ) ? (int) get_field( 'blog_posts_per_page', $blog_page_id ) : 6;
$show_resources   = function_exists( 'get_field' ) ? get_field( 'blog_show_resources', $blog_page_id ) : true;
$show_subscribe   = function_exists( 'get_field' ) ? get_field( 'blog_show_subscribe', $blog_page_id ) : true;

$hero_subtitle    = $hero_subtitle ?: 'Velstadt Blog';
$hero_title       = $hero_title ?: 'Cybersecurity insights that matter';
$hero_description = $hero_description ?: 'Research, threat trends, and practical guidance from specialists who connect technical findings with business context';
$hero_note        = $hero_note ?: 'Research · Analysis · Guidance';
$posts_per_page   = $posts_per_page > 0 ? min( 24, $posts_per_page ) : 6;

if ( ! $featured_id || 'publish' !== get_post_status( $featured_id ) ) {
	$latest_ids  = get_posts( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 1, 'fields' => 'ids' ) );
	$featured_id = $latest_ids ? (int) $latest_ids[0] : 0;
}

$active_category_slug = isset( $_GET['blog_category'] ) && is_string( $_GET['blog_category'] ) ? sanitize_title( wp_unslash( $_GET['blog_category'] ) ) : '';
$active_category      = $active_category_slug ? get_term_by( 'slug', $active_category_slug, 'category' ) : null;
if ( ! $active_category || is_wp_error( $active_category ) ) {
	$active_category_slug = '';
	$active_category      = null;
}

$blog_search = isset( $_GET['blog_search'] ) && is_string( $_GET['blog_search'] ) ? sanitize_text_field( wp_unslash( $_GET['blog_search'] ) ) : '';
$blog_order  = isset( $_GET['blog_order'] ) && is_string( $_GET['blog_order'] ) ? sanitize_key( wp_unslash( $_GET['blog_order'] ) ) : 'newest';
$blog_order  = 'oldest' === $blog_order ? 'oldest' : 'newest';
$blog_format = isset( $_GET['blog_format'] ) && is_string( $_GET['blog_format'] ) ? sanitize_title( wp_unslash( $_GET['blog_format'] ) ) : '';
$format_term = $blog_format ? get_term_by( 'slug', $blog_format, 'blog_format' ) : null;
if ( ! $format_term || is_wp_error( $format_term ) ) {
	$blog_format = '';
}

$paged      = max( 1, (int) get_query_var( 'paged' ) );
$query_args = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => $posts_per_page,
	'paged'               => $paged,
	'ignore_sticky_posts' => true,
	'orderby'             => 'date',
	'order'               => 'oldest' === $blog_order ? 'ASC' : 'DESC',
	'velstadt_blog_search' => true,
);
if ( $active_category_slug ) {
	$query_args['category_name'] = $active_category_slug;
}
if ( $blog_search ) {
	$query_args['s'] = $blog_search;
}
if ( $blog_format ) {
	$query_args['tax_query'] = array( array( 'taxonomy' => 'blog_format', 'field' => 'slug', 'terms' => $blog_format ) );
}

$posts_query = new WP_Query( $query_args );
$has_results = ! empty( $posts_query->posts );
$show_intro = $has_results && '' === $active_category_slug && '' === trim( $blog_search );
$categories  = get_categories( array( 'hide_empty' => false ) );
$formats     = get_terms( array( 'taxonomy' => 'blog_format', 'hide_empty' => false, 'orderby' => 'term_id', 'order' => 'ASC' ) );

$active_filters = array_filter(
	array(
		'blog_category' => $active_category_slug,
		'blog_search'   => $blog_search,
		'blog_order'    => 'oldest' === $blog_order ? 'oldest' : '',
		'blog_format'   => $blog_format,
	)
);

$filtered_blog_url = static function ( $category_slug = null ) use ( $blog_url, $active_filters ) {
	$filters = $active_filters;

	if ( null !== $category_slug ) {
		$filters['blog_category'] = $category_slug;
	}

	$filters = array_filter( $filters );

	return $filters ? add_query_arg( $filters, $blog_url ) : $blog_url;
};

$pagination_url = static function ( $page_number ) use ( $active_filters ) {
	$url = get_pagenum_link( max( 1, (int) $page_number ) );
	$url = remove_query_arg( array( 'blog_category', 'blog_search', 'blog_order', 'blog_format' ), $url );

	return $active_filters ? add_query_arg( $active_filters, $url ) : $url;
};

get_header();
?>

	<section class="page blog__page">
		<div class="header__duplicate header__duplicate--dark">
			<div class="container header__duplicate-container section__lines"></div>
		</div>

		<?php if ( $show_intro && false !== $hero_show && 0 !== $hero_show && '0' !== $hero_show ) : ?>
			<div class="section__header">
				<div class="container section__header-container section__lines">
					<div class="section__header-left">
						<?php if ( $hero_subtitle ) : ?><h2 class="h3 section__subtitle"><?php echo esc_html( $hero_subtitle ); ?></h2><?php endif; ?>
						<?php if ( $hero_title ) : ?><h1 class="h2 section__title"><?php echo esc_html( $hero_title ); ?></h1><?php endif; ?>
						<?php if ( $hero_description ) : ?><p><?php echo esc_html( $hero_description ); ?></p><?php endif; ?>
					</div>
					<div class="section__header-right">
						<?php if ( $hero_note ) : ?><span class="section__header-description"><?php echo esc_html( $hero_note ); ?></span><?php endif; ?>
						<a href="<?php echo esc_url( get_bloginfo( 'rss2_url' ) ); ?>" class="rss">RSS feed</a>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $show_intro && $featured_id ) : ?>
			<?php
			$featured_category = velstadt_blog_primary_category( $featured_id );
			$featured_author   = velstadt_blog_author_name( $featured_id );
			$featured_excerpt  = get_the_excerpt( $featured_id );
			$featured_excerpt  = $featured_excerpt ?: wp_trim_words( wp_strip_all_tags( get_post_field( 'post_content', $featured_id ) ), 32 );
			$featured_read     = velstadt_blog_reading_time( $featured_id );
			?>
			<div class="blog__main">
				<div class="blog__main-container container section__lines">
					<div class="blog__main-left">
						<a href="<?php echo esc_url( get_permalink( $featured_id ) ); ?>"><?php velstadt_blog_post_image( $featured_id, '', 'large', 'featured' ); ?></a>
					</div>
					<div class="blog__main-right">
						<?php if ( $featured_category ) : ?><span class="blog__main-category"><?php echo esc_html( $featured_category->name ); ?></span><?php endif; ?>
						<h2 class="h2 blog__main-title"><a href="<?php echo esc_url( get_permalink( $featured_id ) ); ?>"><?php echo esc_html( get_the_title( $featured_id ) ); ?></a></h2>
						<?php if ( $featured_excerpt ) : ?><p><?php echo esc_html( wp_strip_all_tags( $featured_excerpt ) ); ?></p><?php endif; ?>
						<div class="blog__main-details">
							<?php echo velstadt_blog_author_avatar( $featured_id, 'blog__main-details-icon' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<div class="blog__main-details-col">
								<?php if ( $featured_author ) : ?><span class="blog__main-details-name"><?php echo esc_html( $featured_author ); ?></span><?php endif; ?>
								<span class="blog__main-details-date"><?php echo esc_html( get_the_date( 'F j, Y', $featured_id ) ); ?> · <?php echo esc_html( sprintf( _n( '%d min read', '%d min read', $featured_read, 'velstadt' ), $featured_read ) ); ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class="blog__filter">
			<div class="blog__filter-container container section__lines">
				<form class="blog__filter-form" action="<?php echo esc_url( $blog_url ); ?>" method="get" role="search">
					<?php if ( $active_category_slug ) : ?>
						<input type="hidden" name="blog_category" value="<?php echo esc_attr( $active_category_slug ); ?>">
					<?php endif; ?>

					<fieldset class="blog__filter-search">
						<legend><?php esc_html_e( 'Search', 'velstadt' ); ?></legend>
						<div class="blog__filter-search-control">
							<button type="submit" aria-label="<?php esc_attr_e( 'Search', 'velstadt' ); ?>">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
									<path d="M17.5 17.5L13.875 13.875M15.8333 9.16667C15.8333 12.8486 12.8486 15.8333 9.16667 15.8333C5.48477 15.8333 2.5 12.8486 2.5 9.16667C2.5 5.48477 5.48477 2.5 9.16667 2.5C12.8486 2.5 15.8333 5.48477 15.8333 9.16667Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</button>
							<label class="screen-reader-text" for="blog-search"><?php esc_html_e( 'Search blog posts', 'velstadt' ); ?></label>
							<input id="blog-search" type="search" name="blog_search" value="<?php echo esc_attr( $blog_search ); ?>" placeholder="<?php esc_attr_e( 'Search by title or author', 'velstadt' ); ?>">
						</div>
					</fieldset>

					<fieldset class="blog__filter-format-wrap">
						<legend><?php esc_html_e( 'Format', 'velstadt' ); ?></legend>
						<select id="blog-format" name="blog_format" aria-label="<?php esc_attr_e( 'Filter posts by format', 'velstadt' ); ?>">
							<option value=""><?php esc_html_e( 'All formats', 'velstadt' ); ?></option>
							<?php if ( ! is_wp_error( $formats ) ) : foreach ( $formats as $format ) : ?>
								<option value="<?php echo esc_attr( $format->slug ); ?>" <?php selected( $blog_format, $format->slug ); ?>><?php echo esc_html( $format->name ); ?></option>
							<?php endforeach; endif; ?>
						</select>
					</fieldset>

					<fieldset class="blog__filter-sort-wrap">
						<legend><?php esc_html_e( 'Sort by', 'velstadt' ); ?></legend>
						<select id="blog-order" class="blog__filter-sort" name="blog_order" aria-label="<?php esc_attr_e( 'Sort blog posts', 'velstadt' ); ?>">
							<option value="newest" <?php selected( $blog_order, 'newest' ); ?>><?php esc_html_e( 'Newest first', 'velstadt' ); ?></option>
							<option value="oldest" <?php selected( $blog_order, 'oldest' ); ?>><?php esc_html_e( 'Oldest first', 'velstadt' ); ?></option>
						</select>
					</fieldset>

					<a class="blog__filter-clear" href="<?php echo esc_url( $blog_url ); ?>"><?php esc_html_e( 'Clear filter', 'velstadt' ); ?></a>
				</form>

				<div class="blog__filter-category-wrap">
					<div class="blog__filter-category">
						<ul>
							<li><a href="<?php echo esc_url( $filtered_blog_url( '' ) ); ?>" class="<?php echo $active_category_slug ? '' : 'active'; ?>">All categories</a></li>
							<?php foreach ( $categories as $category ) : ?>
								<li><a href="<?php echo esc_url( $filtered_blog_url( $category->slug ) ); ?>" class="<?php echo $category->slug === $active_category_slug ? 'active' : ''; ?>"><?php echo esc_html( $category->name ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="blog__grid">
			<div class="blog__grid-container container section__lines<?php echo $has_results ? '' : ' blog__grid-container--empty'; ?>">
				<?php if ( $has_results ) : ?>
					<?php foreach ( $posts_query->posts as $blog_post ) : ?>
						<?php get_template_part( 'template-parts/blog/card', null, array( 'post_id' => $blog_post->ID ) ); ?>
					<?php endforeach; ?>
				<?php else : ?>
					<?php get_template_part( 'template-parts/blog/empty', null, array( 'search' => $blog_search, 'reset_url' => $blog_url ) ); ?>
				<?php endif; ?>
			</div>

			<?php if ( $has_results && $posts_query->max_num_pages > 1 ) : ?>
				<?php
				$total_pages = (int) $posts_query->max_num_pages;
				$pagination_items = velstadt_blog_pagination_items( $paged, $total_pages );
				?>
				<div class="container section__lines">
					<nav class="blog__pagination" aria-label="<?php esc_attr_e( 'Blog pagination', 'velstadt' ); ?>">
						<div class="blog__pagination-group">
							<?php if ( $paged > 1 ) : ?>
								<a href="<?php echo esc_url( $pagination_url( 1 ) ); ?>" class="blog__pagination-link blog__pagination-link-start" aria-label="<?php esc_attr_e( 'First page', 'velstadt' ); ?>"></a>
								<a href="<?php echo esc_url( $pagination_url( $paged - 1 ) ); ?>" class="blog__pagination-link blog__pagination-link-prev" aria-label="<?php esc_attr_e( 'Previous page', 'velstadt' ); ?>"></a>
							<?php else : ?>
								<span class="blog__pagination-link blog__pagination-link-start is-disabled" aria-disabled="true"></span>
								<span class="blog__pagination-link blog__pagination-link-prev is-disabled" aria-disabled="true"></span>
							<?php endif; ?>
						</div>
						<ul>
							<?php foreach ( $pagination_items as $pagination_item ) : ?>
								<?php if ( 'ellipsis' === $pagination_item ) : ?>
									<li><span class="blog__pagination-link blog__pagination-ellipsis">…</span></li>
								<?php else : ?>
									<li><a href="<?php echo esc_url( $pagination_url( $pagination_item ) ); ?>" class="blog__pagination-link<?php echo $pagination_item === $paged ? ' active' : ''; ?>"<?php echo $pagination_item === $paged ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $pagination_item ); ?></a></li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
						<div class="blog__pagination-group">
							<?php if ( $paged < $total_pages ) : ?>
								<a href="<?php echo esc_url( $pagination_url( $paged + 1 ) ); ?>" class="blog__pagination-link blog__pagination-link-next" aria-label="<?php esc_attr_e( 'Next page', 'velstadt' ); ?>"></a>
								<a href="<?php echo esc_url( $pagination_url( $total_pages ) ); ?>" class="blog__pagination-link blog__pagination-link-end" aria-label="<?php esc_attr_e( 'Last page', 'velstadt' ); ?>"></a>
							<?php else : ?>
								<span class="blog__pagination-link blog__pagination-link-next is-disabled" aria-disabled="true"></span>
								<span class="blog__pagination-link blog__pagination-link-end is-disabled" aria-disabled="true"></span>
							<?php endif; ?>
						</div>
					</nav>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<?php if ( false !== $show_resources && 0 !== $show_resources && '0' !== $show_resources ) : ?>
		<?php
		$selected_reports = array_filter( array_map( 'absint', (array) get_field( 'blog_resources_reports', $blog_page_id ) ) );
		$report_args = array( 'post_type' => 'velstadt_report', 'post_status' => 'publish', 'posts_per_page' => 3, 'fields' => 'ids' );
		if ( $selected_reports ) {
			$report_args['post__in'] = $selected_reports;
			$report_args['orderby'] = 'post__in';
		}
		get_template_part(
			'template-parts/reports/section',
			null,
			array(
				'reports'  => get_posts( $report_args ),
				'subtitle' => get_field( 'blog_resources_subtitle', $blog_page_id ),
				'title'    => get_field( 'blog_resources_title', $blog_page_id ),
				'link'     => get_field( 'blog_resources_link', $blog_page_id ),
			)
		);
		?>
	<?php endif; ?>

	<?php if ( false !== $show_subscribe && 0 !== $show_subscribe && '0' !== $show_subscribe ) : ?>
		<?php
		$subscription_form = get_field( 'blog_subs_form_shortcode', $blog_page_id ) ?: get_field( 'home_subs_form_shortcode', (int) get_option( 'page_on_front' ) );
		get_template_part(
			'template-parts/common/subscription',
			null,
			array(
				'title'    => get_field( 'blog_subs_title', $blog_page_id ),
				'subtitle' => get_field( 'blog_subs_subtitle', $blog_page_id ),
				'form'     => $subscription_form,
			)
		);
		?>
	<?php endif; ?>

<?php
wp_reset_postdata();
get_footer();

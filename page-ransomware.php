<?php
/**
 * Template Name: Ransomware Encyclopedia
 *
 * @package Velstadt
 */

$page_id = get_queried_object_id();
$catalog_url = get_permalink( $page_id );
$catalog = velstadt_ransomware_catalog_query( $page_id );
$profiles = $catalog['query'];
$categories = get_terms( array( 'taxonomy' => 'ransomware_category', 'hide_empty' => false, 'orderby' => 'term_id', 'order' => 'ASC' ) );
$filter_url = static function ( $category ) use ( $catalog_url, $catalog ) {
	return add_query_arg( array_filter( array( 'ransomware_category' => $category, 'ransomware_search' => $catalog['search'] ) ), $catalog_url );
};

get_header();
?>
<main id="primary" class="page ransomware__page" data-ransomware-catalog>
	<div class="header__duplicate header__duplicate--dark"><div class="container header__duplicate-container section__lines"></div></div>
	<header class="ransomware__hero">
		<div class="container section__lines ransomware__hero-container">
			<?php if ( get_field( 'ransomware_eyebrow', $page_id ) ) : ?><span class="ransomware__eyebrow"><?php echo esc_html( get_field( 'ransomware_eyebrow', $page_id ) ); ?></span><?php endif; ?>
			<h1><?php echo esc_html( get_field( 'ransomware_title', $page_id ) ?: get_the_title( $page_id ) ); ?></h1>
			<?php if ( get_field( 'ransomware_catalog_description', $page_id ) ) : ?><p><?php echo esc_html( get_field( 'ransomware_catalog_description', $page_id ) ); ?></p><?php endif; ?>
		</div>
	</header>
	<section class="ransomware__library" aria-label="<?php esc_attr_e( 'Ransomware profiles', 'velstadt' ); ?>">
		<div class="container section__lines ransomware__library-container">
			<div class="ransomware__filters">
				<form action="<?php echo esc_url( $catalog_url ); ?>" method="get" role="search" class="ransomware__search" data-ransomware-search>
					<?php if ( $catalog['category'] ) : ?><input type="hidden" name="ransomware_category" value="<?php echo esc_attr( $catalog['category'] ); ?>"><?php endif; ?>
					<label for="ransomware-search"><?php esc_html_e( 'Search', 'velstadt' ); ?></label>
					<div class="ransomware__search-control">
						<button type="submit" aria-label="<?php esc_attr_e( 'Search profiles', 'velstadt' ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() . '/markup/images/ransomware/leading-icon.svg' ); ?>" width="16" height="16" alt=""></button>
						<input type="search" id="ransomware-search" name="ransomware_search" value="<?php echo esc_attr( $catalog['search'] ); ?>" placeholder="<?php echo esc_attr( get_field( 'ransomware_search_placeholder', $page_id ) ); ?>">
					</div>
				</form>
				<nav class="ransomware__categories" aria-label="<?php esc_attr_e( 'Filter profiles by category', 'velstadt' ); ?>">
					<ul>
						<li><a href="<?php echo esc_url( $filter_url( '' ) ); ?>" data-ransomware-filter<?php if ( ! $catalog['category'] ) : ?> aria-current="true"<?php endif; ?>><?php echo esc_html( get_field( 'ransomware_all_label', $page_id ) ); ?></a></li>
						<?php if ( ! is_wp_error( $categories ) ) : foreach ( $categories as $category ) : ?>
							<li><a href="<?php echo esc_url( $filter_url( $category->slug ) ); ?>" data-ransomware-filter<?php if ( $catalog['category'] === $category->slug ) : ?> aria-current="true"<?php endif; ?>><?php echo esc_html( $category->name ); ?></a></li>
						<?php endforeach; endif; ?>
					</ul>
				</nav>
			</div>
			<div class="ransomware__results" data-ransomware-results>
				<div class="ransomware__grid" data-ransomware-grid>
					<?php foreach ( $profiles->posts as $profile ) : ?>
						<?php get_template_part( 'template-parts/ransomware/card', null, array( 'post_id' => $profile->ID ) ); ?>
					<?php endforeach; ?>
				</div>
				<?php if ( ! $profiles->have_posts() ) : ?><p class="ransomware__empty"><?php echo esc_html( get_field( 'ransomware_empty_message', $page_id ) ); ?></p><?php endif; ?>
				<?php if ( $catalog['page'] < $profiles->max_num_pages ) : ?>
					<div class="ransomware__more"><a class="btn" data-ransomware-more href="<?php echo esc_url( add_query_arg( 'ransomware_page', $catalog['page'] + 1, $filter_url( $catalog['category'] ) ) ); ?>"><?php echo esc_html( get_field( 'ransomware_load_more_label', $page_id ) ); ?></a></div>
				<?php endif; ?>
				<span class="screen-reader-text" data-ransomware-count><?php echo esc_html( sprintf( __( '%d profiles found.', 'velstadt' ), $profiles->found_posts ) ); ?></span>
			</div>
			<p class="ransomware__status" data-ransomware-status role="status" aria-live="polite"></p>
		</div>
	</section>
	<?php get_template_part( 'template-parts/ransomware/catalog-cta', null, array( 'page_id' => $page_id ) ); ?>
</main>
<?php get_footer(); ?>

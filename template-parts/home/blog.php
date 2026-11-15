<?php
/**
 * Latest blog posts section on the front page.
 *
 * @package Velstadt
 */

$has_scf           = function_exists( 'get_field' );
$show              = $has_scf ? (bool) get_field( 'home_blog_show' ) : true;
$subtitle          = velstadt_get_home_field( 'home_blog_subtitle', 'Blog and Insights' );
$title             = velstadt_get_home_field( 'home_blog_title', 'Practical insight into cyber threats' );
$archive_link_data = velstadt_get_home_field( 'home_blog_archive_link', velstadt_header_default_link( 'All posts', get_permalink( (int) get_option( 'page_for_posts' ) ) ) );
$archive_link      = $archive_link_data ? velstadt_normalize_header_link( $archive_link_data, __( 'All posts', 'velstadt' ) ) : null;

if ( ! $show ) {
	return;
}

$posts_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 5,
		'ignore_sticky_posts' => true,
		'orderby'             => 'date',
		'order'               => 'DESC',
	)
);
$posts         = $posts_query->posts;
$featured_post = $posts ? array_shift( $posts ) : null;
?>
<section class="section blog__section">
	<div class="section__header">
		<div class="container section__header-container section__lines">
			<div class="section__header-left">
				<?php if ( $subtitle ) : ?><h3 class="h3 section__subtitle"><?php echo esc_html( $subtitle ); ?></h3><?php endif; ?>
				<?php if ( $title ) : ?><h2 class="h2 section__title"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
			</div>
			<?php if ( $archive_link && $archive_link['title'] ) : ?>
				<div class="section__header-right">
					<a href="<?php echo esc_url( $archive_link['url'] ); ?>" class="link link--arrow"<?php if ( $archive_link['target'] ) : ?> target="<?php echo esc_attr( $archive_link['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>><?php echo esc_html( $archive_link['title'] ); ?></a>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<?php if ( $featured_post ) : ?>
		<?php
		$featured_id       = (int) $featured_post->ID;
		$featured_category = velstadt_blog_primary_category( $featured_id );
		$featured_excerpt  = get_the_excerpt( $featured_id );
		$featured_excerpt  = $featured_excerpt ?: wp_trim_words( wp_strip_all_tags( get_post_field( 'post_content', $featured_id ) ), 28 );
		$featured_author   = velstadt_blog_author_name( $featured_id );
		$featured_read     = velstadt_blog_reading_time( $featured_id );
		$featured_url      = get_permalink( $featured_id );
		?>
		<div class="container blog__container section__lines">
			<div class="blog__main">
				<article class="main__card">
					<?php if ( $featured_category ) : ?><span class="main__card-badge"><?php echo esc_html( $featured_category->name ); ?></span><?php endif; ?>
					<?php if ( has_post_thumbnail( $featured_id ) ) : ?>
						<?php echo get_the_post_thumbnail( $featured_id, 'large', array( 'class' => 'main__card-img', 'alt' => get_the_title( $featured_id ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php endif; ?>
					<div class="main__card-details">
						<h3 class="h3 main__card-title"><a href="<?php echo esc_url( $featured_url ); ?>"><?php echo esc_html( get_the_title( $featured_id ) ); ?></a></h3>
						<?php if ( $featured_excerpt ) : ?><p><?php echo esc_html( wp_strip_all_tags( $featured_excerpt ) ); ?></p><?php endif; ?>
						<span class="main__card-info"><?php echo esc_html( $featured_author ); ?> <span class="date"><?php echo esc_html( get_the_date( 'F j, Y', $featured_id ) ); ?> · <?php echo esc_html( sprintf( _n( '%d min read', '%d min read', $featured_read, 'velstadt' ), $featured_read ) ); ?></span></span>
					</div>
				</article>
			</div>

			<?php if ( $posts ) : ?>
				<div class="blog__grid">
					<?php foreach ( $posts as $blog_post ) : ?>
						<?php
						$post_id     = (int) $blog_post->ID;
						$post_url    = get_permalink( $post_id );
						$category    = velstadt_blog_primary_category( $post_id );
						$author_name = velstadt_blog_author_name( $post_id );
						$read_time   = velstadt_blog_reading_time( $post_id );
						?>
						<article class="blog__card">
							<a href="<?php echo esc_url( $post_url ); ?>" class="post__card-preview">
								<?php if ( has_post_thumbnail( $post_id ) ) : ?><?php echo get_the_post_thumbnail( $post_id, 'medium_large', array( 'alt' => get_the_title( $post_id ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php endif; ?>
								<?php if ( $category ) : ?><span class="post__card-category"><?php echo esc_html( $category->name ); ?></span><?php endif; ?>
							</a>
							<a href="<?php echo esc_url( $post_url ); ?>" class="post__card-title"><?php echo esc_html( get_the_title( $post_id ) ); ?></a>
							<span class="post__card-details"><?php echo esc_html( $author_name ); ?> <span><?php echo esc_html( get_the_date( 'F j, Y', $post_id ) ); ?> · <?php echo esc_html( sprintf( _n( '%d min read', '%d min read', $read_time, 'velstadt' ), $read_time ) ); ?></span></span>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</section>
<?php wp_reset_postdata(); ?>

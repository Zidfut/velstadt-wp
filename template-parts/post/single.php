<?php
/**
 * Single post layout.
 *
 * @package Velstadt
 */

$post_id        = get_the_ID();
$posts_page_id  = (int) get_option( 'page_for_posts' );
$posts_url      = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/blog/' );
$posts_title    = $posts_page_id ? get_the_title( $posts_page_id ) : __( 'Blog', 'velstadt' );
$category       = velstadt_blog_primary_category( $post_id );
$eyebrow        = $category ? $category->name : $posts_title;
$description    = get_the_excerpt( $post_id );
$author_id      = (int) get_post_field( 'post_author', $post_id );
$author_name    = velstadt_blog_author_name( $post_id );
$author_url     = get_author_posts_url( $author_id );
$author_bio     = get_the_author_meta( 'description', $author_id );
$read_time      = velstadt_blog_reading_time( $post_id );
$published_date = get_the_date( 'F j, Y', $post_id );
$modified_date  = get_the_modified_date( 'F j, Y', $post_id );
$content        = apply_filters( 'the_content', get_the_content() );
$prepared       = velstadt_prepare_content_page( $content );
$toc            = $prepared['toc'];
$related        = velstadt_post_related_posts( $post_id, 3 );
?>
<main id="primary" class="page post">
	<div class="header__duplicate header__duplicate--dark"><div class="container header__duplicate-container section__lines"></div></div>
	<nav class="breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumbs', 'velstadt' ); ?>">
		<div class="container breadcrumbs__container section__lines"><ul>
			<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'velstadt' ); ?></a></li>
			<li><a href="<?php echo esc_url( $posts_url ); ?>"><?php echo esc_html( $posts_title ); ?></a></li>
			<li><span><?php the_title(); ?></span></li>
		</ul></div>
	</nav>

	<header class="section__header">
		<div class="container section__header-container section__lines">
			<div class="section__header-left">
				<?php if ( $eyebrow ) : ?><span class="h3 section__subtitle"><?php echo esc_html( $eyebrow ); ?></span><?php endif; ?>
				<h1 class="h2 section__title"><?php the_title(); ?></h1>
				<?php if ( $description ) : ?><p><?php echo esc_html( $description ); ?></p><?php endif; ?>
				<div class="post__details">
					<div class="post__details-item post__author">
						<?php echo get_avatar( $author_id, 80, '', $author_name, array( 'class' => 'post__author-img' ) ); ?>
						<div class="post__details-col">
							<?php if ( $author_name ) : ?><h2 class="h3 post__author-name post__details-title"><a href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $author_name ); ?></a></h2><?php endif; ?>
							<?php if ( $author_bio ) : ?><span class="post__author-position post__details-description"><?php echo esc_html( wp_trim_words( $author_bio, 12 ) ); ?></span><?php endif; ?>
						</div>
					</div>
					<div class="post__details-item post__details-col post__date">
						<time class="post__date-title post__details-title" datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $post_id ) ); ?>"><?php echo esc_html( $published_date ); ?></time>
						<span class="post__date-status post__details-description"><?php echo esc_html( sprintf( __( 'Published · Updated %s', 'velstadt' ), $modified_date ) ); ?></span>
					</div>
					<div class="post__details-item post__details-col post__ttr">
						<span class="post__ttr-title post__details-title"><?php echo esc_html( sprintf( _n( '%d min read', '%d min read', $read_time, 'velstadt' ), $read_time ) ); ?></span>
						<span class="post__details-description"><?php esc_html_e( 'Read time', 'velstadt' ); ?></span>
					</div>
				</div>
			</div>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="section__header-right"><?php the_post_thumbnail( 'full', array( 'class' => 'post__img', 'alt' => get_the_title() ) ); ?></div>
			<?php endif; ?>
		</div>
	</header>

	<div class="record"><div class="container section__header-record section__lines"></div></div>

	<div class="container post__container section__lines<?php echo $toc ? '' : ' post__container--wide'; ?>">
		<article class="post__content">
			<?php echo $prepared['content']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'velstadt' ), 'after' => '</div>' ) ); ?>
		</article>
		<?php if ( $toc ) : ?>
			<aside class="post__sidebar">
				<nav class="toc" aria-label="<?php esc_attr_e( 'Table of contents', 'velstadt' ); ?>"><ul>
					<?php foreach ( $toc as $item ) : ?><li><a href="#<?php echo esc_attr( $item['id'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a></li><?php endforeach; ?>
				</ul></nav>
			</aside>
		<?php endif; ?>
	</div>
</main>

<?php if ( $related->have_posts() ) : ?>
	<section class="section resources related__posts">
		<div class="section__header"><div class="container section__header-container section__lines">
			<div class="section__header-left"><span class="h3 section__subtitle"><?php esc_html_e( 'Related posts', 'velstadt' ); ?></span><h2 class="h2 section__title"><?php esc_html_e( 'Continue exploring', 'velstadt' ); ?></h2></div>
			<div class="section__header-right"><a href="<?php echo esc_url( $posts_url ); ?>" class="link link--arrow"><?php esc_html_e( 'View all articles', 'velstadt' ); ?></a></div>
		</div></div>
		<div class="container section__lines swiper related__swiper"><div class="swiper-wrapper">
			<?php while ( $related->have_posts() ) : $related->the_post(); ?>
				<?php get_template_part( 'template-parts/blog/card', null, array( 'post_id' => get_the_ID(), 'class' => 'swiper-slide' ) ); ?>
			<?php endwhile; ?>
		</div></div>
	</section>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>

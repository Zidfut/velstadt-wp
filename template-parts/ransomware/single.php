<?php
/**
 * Single ransomware profile layout.
 *
 * @package Velstadt
 */

$post_id = get_the_ID();
$catalog_page = get_page_by_path( 'ransomware-encyclopedia' );
$posts_url = $catalog_page ? get_permalink( $catalog_page ) : home_url( '/ransomware-encyclopedia/' );
$posts_title = __( 'Ransomware Encyclopedia', 'velstadt' );
$category = velstadt_blog_primary_category( $post_id );
$eyebrow = $category ? $category->name : $posts_title;
$description = get_the_excerpt( $post_id );
if ( function_exists( 'get_field' ) ) {
	$description = get_field( 'ransomware_description', $post_id ) ?: $description;
}
$ransomware_dates = array();
foreach ( array( 'published' => 'date', 'updated' => 'modified' ) as $key => $source ) {
	$value = function_exists( 'get_field' ) ? get_field( 'ransomware_' . $key . '_date', $post_id ) : '';
	$date = $value ? DateTimeImmutable::createFromFormat( '!Y-m-d', $value, wp_timezone() ) : false;
	if ( ! $date || $date->format( 'Y-m-d' ) !== $value ) {
		$date = get_post_datetime( $post_id, $source );
	}
	if ( $date ) {
		$ransomware_dates[ $key ] = array( 'datetime' => $date->format( 'Y-m-d' ), 'label' => wp_date( 'F j, Y', $date->getTimestamp() ) );
	}
}

$content = apply_filters( 'the_content', get_the_content() );
$prepared = velstadt_prepare_content_page( $content );
$toc = $prepared['toc'];
?>
<main id="primary" class="page post">
	<div id="top" class="header__duplicate header__duplicate--dark"><div class="container header__duplicate-container section__lines"></div></div>
	<nav class="breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumbs', 'velstadt' ); ?>">
		<div class="container breadcrumbs__container section__lines"><ul>
			<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'velstadt' ); ?></a></li>
			<li><a href="<?php echo esc_url( $posts_url ); ?>"><?php echo esc_html( $posts_title ); ?></a></li>
			<li><span><?php the_title(); ?></span></li>
		</ul></div>
	</nav>

	<header class="section__header ransomware__header">
		<div class="container section__header-container section__lines">
			<div class="section__header-left">
				<?php if ( $eyebrow ) : ?><span class="h3 section__subtitle"><?php echo esc_html( $eyebrow ); ?></span><?php endif; ?>
				<h1 class="h2 section__title"><?php the_title(); ?></h1>
				<?php if ( $description ) : ?><p><?php echo esc_html( $description ); ?></p><?php endif; ?>
				<div class="section__header-info">
					<?php foreach ( $ransomware_dates as $key => $date ) : ?>
						<div class="ransomware__date">
							<span><?php echo 'published' === $key ? esc_html__( 'Published', 'velstadt' ) : esc_html__( 'Last updated', 'velstadt' ); ?></span>
							<time class="date" datetime="<?php echo esc_attr( $date['datetime'] ); ?>"><?php echo esc_html( $date['label'] ); ?></time>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</header>

	<div class="record"><div class="container section__header-record section__lines"></div></div>

	<div class="container post__container section__lines">
		<article class="page__content">
			<?php get_template_part( 'template-parts/ransomware/key-facts', null, array( 'post_id' => $post_id ) ); ?>
			<?php echo $prepared['content']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'velstadt' ), 'after' => '</div>' ) ); ?>
		</article>
		<?php get_template_part( 'template-parts/ransomware/sidebar', null, array( 'toc' => $toc, 'post_id' => $post_id ) ); ?>
	</div>
</main>

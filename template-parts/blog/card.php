<?php
/**
 * Blog archive card.
 *
 * @package Velstadt
 *
 * @var array $args Template arguments.
 */

$post_id = isset( $args['post_id'] ) ? (int) $args['post_id'] : get_the_ID();
$classes = 'blog__grid-card' . ( ! empty( $args['class'] ) ? ' ' . sanitize_html_class( $args['class'] ) : '' );
if ( ! $post_id ) {
	return;
}

$category    = velstadt_blog_primary_category( $post_id );
$author_name = velstadt_blog_author_name( $post_id );
$initials    = velstadt_blog_author_initials( $author_name );
$read_time   = velstadt_blog_reading_time( $post_id );
$excerpt     = get_the_excerpt( $post_id );
$excerpt     = $excerpt ?: wp_trim_words( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ), 24 );
$permalink   = get_permalink( $post_id );
?>
<article class="<?php echo esc_attr( $classes ); ?>">
	<a href="<?php echo esc_url( $permalink ); ?>" class="blog__grid-card-img">
		<?php velstadt_blog_post_image( $post_id ); ?>
	</a>
	<?php if ( $category ) : ?><span class="blog__grid-card-category"><?php echo esc_html( $category->name ); ?></span><?php endif; ?>
	<div class="blog__grid-card-content">
		<h2 class="h3 blog__grid-card-title"><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( get_the_title( $post_id ) ); ?></a></h2>
		<?php if ( $excerpt ) : ?><p><?php echo esc_html( wp_strip_all_tags( $excerpt ) ); ?></p><?php endif; ?>
	</div>
	<div class="blog__grid-card-details">
		<?php if ( $initials ) : ?><span class="blog__grid-card-details-icon"><?php echo esc_html( $initials ); ?></span><?php endif; ?>
		<div class="blog__grid-card-details-col">
			<?php if ( $author_name ) : ?><span class="blog__grid-card-details-name"><?php echo esc_html( $author_name ); ?></span><?php endif; ?>
			<span class="blog__grid-card-details-date"><?php echo esc_html( get_the_date( 'F j, Y', $post_id ) ); ?> · <?php echo esc_html( sprintf( _n( '%d min read', '%d min read', $read_time, 'velstadt' ), $read_time ) ); ?></span>
		</div>
	</div>
</article>

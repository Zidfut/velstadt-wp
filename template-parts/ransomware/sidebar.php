<?php
/** Ransomware sidebar with table of contents and categories. @package Velstadt */
$toc = isset( $args['toc'] ) ? $args['toc'] : array();
$post_id = (int) $args['post_id'];
$categories = get_the_category( $post_id );
?>
<aside class="post__sidebar"><div class="post__sidebar-container">
	<?php get_template_part( 'template-parts/common/table-of-contents', null, array( 'toc' => $toc ) ); ?>
	<?php if ( $categories ) : ?>
		<div class="post__categories">
			<h3 class="h3 post__sidebar-title"><?php esc_html_e( 'Categories', 'velstadt' ); ?></h3>
			<ul><?php foreach ( $categories as $category ) : ?><li><span><?php echo esc_html( $category->name ); ?></span></li><?php endforeach; ?></ul>
		</div>
	<?php endif; ?>
</div></aside>

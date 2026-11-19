<?php
/** Ransomware sidebar with table of contents and badge. @package Velstadt */
$toc = isset( $args['toc'] ) ? $args['toc'] : array();
$post_id = (int) $args['post_id'];
$categories = get_the_category( $post_id );
$has_scf = function_exists( 'get_field' );
$badge_show = $has_scf ? (bool) get_field( 'post_sidebar_badge_show', 'option' ) : false;
$badge_url = $has_scf ? get_field( 'post_sidebar_badge_url', 'option' ) : '';
$badge_image = $has_scf ? get_field( 'post_sidebar_badge_image', 'option' ) : 0;
$badge_alt = $has_scf ? get_field( 'post_sidebar_badge_alt', 'option' ) : '';
$badge_src = $badge_image ? wp_get_attachment_image_url( (int) $badge_image, 'full' ) : get_template_directory_uri() . '/markup/images/google-source-badge.svg';
?>
<aside class="post__sidebar"><div class="post__sidebar-container">
	<?php if ( $toc ) : ?>
		<div class="post__sidebar-item">
			<div class="post__progress">
				<div class="post__progress-header">
					<span class="post__progress-title"><?php esc_html_e( 'On this page', 'velstadt' ); ?></span>
					<a href="#top" class="post__progress-top" aria-label="<?php esc_attr_e( 'Back to top', 'velstadt' ); ?>"></a>
				</div>
				<div class="post__progress-line"><span class="post__progress-line-current" style="width: 0%;"></span></div>
			</div>
			<nav class="toc" aria-label="<?php esc_attr_e( 'Table of contents', 'velstadt' ); ?>"><ul>
				<?php foreach ( $toc as $item ) : ?><li><a href="#<?php echo esc_attr( $item['id'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a></li><?php endforeach; ?>
			</ul></nav>
		</div>
	<?php endif; ?>
	<?php if ( $categories ) : ?>
		<div class="post__categories">
			<h3 class="h3 post__sidebar-title"><?php esc_html_e( 'Categories', 'velstadt' ); ?></h3>
			<ul><?php foreach ( $categories as $category ) : ?><li><span><?php echo esc_html( $category->name ); ?></span></li><?php endforeach; ?></ul>
		</div>
	<?php endif; ?>
	<?php if ( $badge_show && $badge_url && $badge_src ) : ?>
		<div class="google__badge"><a href="<?php echo esc_url( $badge_url ); ?>" target="_blank" rel="noopener noreferrer"><img src="<?php echo esc_url( $badge_src ); ?>" alt="<?php echo esc_attr( $badge_alt ); ?>"></a></div>
	<?php endif; ?>
</div></aside>

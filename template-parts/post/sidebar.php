<?php
/** Blog sidebar with current post data. @package Velstadt */
$toc = isset( $args['toc'] ) ? $args['toc'] : array();
$post_id = (int) $args['post_id'];
$categories = get_the_category( $post_id );
$url = get_permalink( $post_id );
$share_urls = array(
	'copy' => $url,
	'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( $url ),
	'x' => 'https://twitter.com/intent/tweet?url=' . rawurlencode( $url ) . '&text=' . rawurlencode( get_the_title( $post_id ) ),
	'linkedin' => 'https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode( $url ),
);
$share_icons = array( 'copy' => 'share-link.svg', 'facebook' => 'facebook.svg', 'x' => 'share-x.svg', 'linkedin' => 'share-li.svg' );
$share_labels = array( 'copy' => __( 'Copy article link', 'velstadt' ), 'facebook' => 'Facebook', 'x' => 'X', 'linkedin' => 'LinkedIn' );
$has_scf = function_exists( 'get_field' );
$share_show = $has_scf ? (bool) get_field( 'post_sidebar_share_show', 'option' ) : false;
$share_title = $has_scf ? get_field( 'post_sidebar_share_title', 'option' ) : '';
$networks = $has_scf ? (array) get_field( 'post_sidebar_networks', 'option' ) : array();
$badge_show = $has_scf ? (bool) get_field( 'post_sidebar_badge_show', 'option' ) : false;
$badge_url = $has_scf ? get_field( 'post_sidebar_badge_url', 'option' ) : '';
$badge_image = $has_scf ? get_field( 'post_sidebar_badge_image', 'option' ) : 0;
$badge_alt = $has_scf ? get_field( 'post_sidebar_badge_alt', 'option' ) : '';
$badge_src = $badge_image ? wp_get_attachment_image_url( (int) $badge_image, 'full' ) : '';
$form_show = $has_scf ? (bool) get_field( 'post_sidebar_form_show', 'option' ) : false;
$form = $has_scf ? get_field( 'post_sidebar_form_shortcode', 'option' ) : '';
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
	<?php if ( $share_show && $networks ) : ?>
		<div class="post__share">
			<h3 class="h3 post__sidebar-title"><?php echo esc_html( $share_title ); ?></h3>
			<ul class="share__socials">
				<?php foreach ( $networks as $network ) : if ( ! isset( $share_urls[ $network ] ) ) { continue; } ?>
					<li><a href="<?php echo esc_url( $share_urls[ $network ] ); ?>" aria-label="<?php echo esc_attr( $share_labels[ $network ] ); ?>" <?php if ( 'copy' === $network ) : ?>data-copy-post-link data-copied-label="<?php esc_attr_e( 'Link copied', 'velstadt' ); ?>"<?php else : ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>><img src="<?php echo esc_url( get_template_directory_uri() . '/markup/images/icons/' . $share_icons[ $network ] ); ?>" alt=""></a></li>
				<?php endforeach; ?>
			</ul>
			<span class="screen-reader-text" data-copy-status role="status"></span>
		</div>
	<?php endif; ?>
	<?php if ( $badge_show && $badge_url && $badge_src ) : ?>
		<div class="google__badge"><a href="<?php echo esc_url( $badge_url ); ?>" target="_blank" rel="noopener noreferrer"><img src="<?php echo esc_url( $badge_src ); ?>" alt="<?php echo esc_attr( $badge_alt ); ?>"></a></div>
	<?php endif; ?>
	<?php if ( $form_show && $form && shortcode_exists( 'contact-form-7' ) ) : ?>
		<div class="post__sidebar-form">
			<?php
			$form_html = new WP_HTML_Tag_Processor( do_shortcode( $form ) );
			if ( $form_html->next_tag( array( 'tag_name' => 'FORM', 'class_name' => 'wpcf7-form' ) ) ) {
				$form_html->add_class( 'custom__form' );
				$form_html->add_class( 'subs__form' );
			}
			echo $form_html->get_updated_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</div>
	<?php endif; ?>
</div></aside>

<?php
/** Share / CTA block. @package Velstadt */
$subtitle = get_field( 'subtitle' );
$title = get_field( 'title' );
$description = get_field( 'description' );
$light = 'light' === get_field( 'background' );
$variant = get_field( 'variant' );
$button = get_field( 'button' );
$socials = get_field( 'socials' ) ?: array();
if ( ! $title && ! $subtitle && ! $description ) {
	velstadt_post_block_empty( $is_preview, __( 'Add a title or text for the Share / CTA block.', 'velstadt' ) );
	return;
}
$article_id = isset( $post_id ) && is_numeric( $post_id ) ? (int) $post_id : get_the_ID();
$article_id = wp_is_post_revision( $article_id ) ?: $article_id;
$url = get_permalink( $article_id );
$article_title = get_the_title( $article_id );
$share_urls = array(
	'copy' => $url,
	'email' => 'mailto:?subject=' . rawurlencode( $article_title ) . '&body=' . rawurlencode( $url ),
	'linkedin' => 'https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode( $url ),
	'x' => 'https://twitter.com/intent/tweet?url=' . rawurlencode( $url ) . '&text=' . rawurlencode( $article_title ),
	'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( $url ),
);
$share_labels = array( 'copy' => __( 'Copy article link', 'velstadt' ), 'email' => __( 'Share by email', 'velstadt' ), 'linkedin' => 'LinkedIn', 'x' => 'X', 'facebook' => 'Facebook' );
?>
<div id="<?php echo esc_attr( velstadt_post_block_id( $block, 'share' ) ); ?>" class="share<?php echo $light ? ' bg--light' : ''; ?>">
	<div class="share__col">
		<?php if ( $subtitle ) : ?><span class="share__subtitle"><?php echo esc_html( $subtitle ); ?></span><?php endif; ?>
		<?php if ( $title ) : ?><h3 class="h3 share__title"><?php echo esc_html( $title ); ?></h3><?php endif; ?>
		<?php if ( $description ) { echo wpautop( esc_html( $description ) ); } ?>
	</div>
	<?php if ( 'button' === $variant ) : ?>
		<?php if ( ! empty( $button['url'] ) && ! empty( $button['title'] ) ) : ?><a href="<?php echo esc_url( $button['url'] ); ?>" class="btn <?php echo $light ? 'btn--primary' : 'btn--transparent'; ?>"<?php if ( ! empty( $button['target'] ) && '_blank' === $button['target'] ) : ?> target="_blank" rel="noopener noreferrer"<?php endif; ?>><?php echo esc_html( $button['title'] ); ?></a><?php endif; ?>
	<?php elseif ( $socials ) : ?>
		<ul class="share__socials">
			<?php foreach ( $socials as $social ) :
				$network = isset( $social['network'] ) ? $social['network'] : '';
				$icon = ! empty( $social['icon'] ) ? wp_get_attachment_image( (int) $social['icon'], 'full', false, array( 'alt' => '' ) ) : '';
				if ( ! isset( $share_urls[ $network ] ) || ! $icon ) { continue; }
				?>
				<li><a href="<?php echo esc_url( $share_urls[ $network ] ); ?>" aria-label="<?php echo esc_attr( $share_labels[ $network ] ); ?>"<?php if ( 'copy' === $network ) : ?> data-copy-post-link data-copied-label="<?php esc_attr_e( 'Link copied', 'velstadt' ); ?>"<?php elseif ( 'email' !== $network ) : ?> target="_blank" rel="noopener noreferrer"<?php endif; ?>><?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></li>
			<?php endforeach; ?>
		</ul>
		<span class="screen-reader-text" data-copy-status role="status"></span>
	<?php endif; ?>
</div>

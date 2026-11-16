<?php
/** Editorial images with captions and an automatic gallery layout. @package Velstadt */
$original_ratio = (bool) get_field( 'original_ratio' );
$items = get_field( 'images' ) ?: array();
$images = array();
foreach ( $items as $item ) {
	$image_id = ! empty( $item['image'] ) ? (int) $item['image'] : 0;
	if ( ! $image_id || ! wp_attachment_is_image( $image_id ) ) {
		continue;
	}
	$image = wp_get_attachment_image( $image_id, 'large', false, array( 'class' => 'post__media-image' ) );
	if ( $image ) {
		$images[] = array(
			'html' => $image,
			'caption' => isset( $item['caption'] ) ? trim( (string) $item['caption'] ) : '',
		);
	}
}
if ( ! $images ) {
	velstadt_post_block_empty( $is_preview, __( 'Choose an image from the Media Library.', 'velstadt' ) );
	return;
}
$classes = 'post__block post__media' . ( count( $images ) > 1 ? ' post__media--gallery' : '' ) . ( $original_ratio ? ' post__media--natural' : '' );
?>
<div id="<?php echo esc_attr( velstadt_post_block_id( $block, 'media' ) ); ?>" class="<?php echo esc_attr( $classes ); ?>">
	<?php foreach ( $images as $image ) : ?>
		<figure class="post__media-item">
			<?php echo $image['html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php if ( '' !== $image['caption'] ) : ?>
				<figcaption class="post__media-caption"><?php echo nl2br( esc_html( $image['caption'] ) ); ?></figcaption>
			<?php endif; ?>
		</figure>
	<?php endforeach; ?>
</div>

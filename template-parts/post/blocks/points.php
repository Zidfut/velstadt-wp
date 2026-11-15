<?php
/** Points block. @package Velstadt */
$items = get_field( 'items' );
if ( ! $items ) { velstadt_post_block_empty( $is_preview, __( 'Add point cards.', 'velstadt' ) ); return; }
?>
<section id="<?php echo esc_attr( velstadt_post_block_id( $block, 'points' ) ); ?>" class="post__block points"><div class="points__grid">
	<?php foreach ( $items as $item ) : ?><div class="points__card"><?php if ( ! empty( $item['icon'] ) ) : ?><span class="points__card-icon"><?php echo wp_get_attachment_image( (int) $item['icon'], 'thumbnail', false, array( 'alt' => ! empty( $item['title'] ) ? $item['title'] : '' ) ); ?></span><?php endif; ?><?php if ( ! empty( $item['title'] ) ) : ?><h3 class="h3 points__card-title"><?php echo esc_html( $item['title'] ); ?></h3><?php endif; ?><?php if ( ! empty( $item['content'] ) ) : ?><p><?php echo esc_html( $item['content'] ); ?></p><?php endif; ?></div><?php endforeach; ?>
</div></section>

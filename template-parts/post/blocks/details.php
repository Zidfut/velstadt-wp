<?php
/** Details block. @package Velstadt */
$title = get_field( 'title' );
$items = get_field( 'items' );
if ( ! $title && ! $items ) { velstadt_post_block_empty( $is_preview, __( 'Add Details content.', 'velstadt' ) ); return; }
?>
<section id="<?php echo esc_attr( velstadt_post_block_id( $block, 'details' ) ); ?>" class="post__block details">
	<?php if ( $title ) : ?><header class="details__header"><h3 class="h3 details__header-label"><?php echo esc_html( $title ); ?></h3></header><?php endif; ?>
	<?php foreach ( (array) $items as $item ) : ?><div class="details__item"><div class="details-item-header"><?php if ( ! empty( $item['label'] ) ) : ?><h4 class="h4 details__item-label"><?php echo esc_html( $item['label'] ); ?></h4><?php endif; ?></div><div class="details__item-content"><?php echo ! empty( $item['content'] ) ? wp_kses_post( $item['content'] ) : ''; ?></div></div><?php endforeach; ?>
</section>

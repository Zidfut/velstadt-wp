<?php
/** Metrics block. @package Velstadt */
$layout = get_field( 'layout' );
$layout = 'row' === $layout ? 'row' : 'grid';
$items  = get_field( 'items' );
if ( ! $items ) { velstadt_post_block_empty( $is_preview, __( 'Add metrics.', 'velstadt' ) ); return; }
?>
<section id="<?php echo esc_attr( velstadt_post_block_id( $block, 'metrics' ) ); ?>" class="post__block metrics metrics--<?php echo esc_attr( $layout ); ?>"><div class="metrics__items">
	<?php foreach ( $items as $item ) : ?><div class="metrics__item"><?php if ( isset( $item['number'] ) && '' !== $item['number'] ) : ?><span class="metrics__item-number"><?php echo esc_html( $item['number'] ); ?></span><?php endif; ?><?php if ( ! empty( $item['title'] ) ) : ?><span class="metrics__item-title"><?php echo esc_html( $item['title'] ); ?></span><?php endif; ?></div><?php endforeach; ?>
</div></section>

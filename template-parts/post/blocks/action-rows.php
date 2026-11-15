<?php
/** Action Rows block. @package Velstadt */
$items = get_field( 'items' );
if ( ! $items ) { velstadt_post_block_empty( $is_preview, __( 'Add action rows.', 'velstadt' ) ); return; }
?>
<section id="<?php echo esc_attr( velstadt_post_block_id( $block, 'action-rows' ) ); ?>" class="post__block action__rows">
	<?php foreach ( $items as $item ) : ?><div class="action__rows-item"><div class="action__rows-header"><span class="action__rows-number"></span><?php if ( ! empty( $item['title'] ) ) : ?><h3 class="h3 action__rows-title"><?php echo esc_html( $item['title'] ); ?></h3><?php endif; ?></div><?php if ( ! empty( $item['content'] ) ) : ?><div class="action__rows-content"><?php echo wp_kses_post( $item['content'] ); ?></div><?php endif; ?></div><?php endforeach; ?>
</section>

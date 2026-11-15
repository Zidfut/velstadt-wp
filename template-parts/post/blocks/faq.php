<?php
/** FAQ block. @package Velstadt */
$items = get_field( 'items' );
if ( ! $items ) { velstadt_post_block_empty( $is_preview, __( 'Add FAQ items.', 'velstadt' ) ); return; }
?>
<section id="<?php echo esc_attr( velstadt_post_block_id( $block, 'faq' ) ); ?>" class="post__block faq faq__block"><div class="faq__right"><div class="services__accardion"><div class="services__accardion-list">
	<?php foreach ( $items as $index => $item ) : ?><div class="services__accardion-item<?php echo 0 === $index ? ' active' : ''; ?>"><div class="services__accardion-header"><?php if ( ! empty( $item['question'] ) ) : ?><h3 class="h3 services__accardion-title"><?php echo esc_html( $item['question'] ); ?></h3><?php endif; ?></div><div class="services__accardion-content-wrapper"><div class="services__accardion-content"><?php echo ! empty( $item['content'] ) ? wp_kses_post( $item['content'] ) : ''; ?></div></div></div><?php endforeach; ?>
</div></div></div></section>

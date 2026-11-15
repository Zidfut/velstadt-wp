<?php
/** Sources block. @package Velstadt */
$items = get_field( 'items' );
if ( ! $items ) { velstadt_post_block_empty( $is_preview, __( 'Add source links.', 'velstadt' ) ); return; }
?>
<section id="<?php echo esc_attr( velstadt_post_block_id( $block, 'sources' ) ); ?>" class="post__block sources">
	<?php foreach ( $items as $item ) : $link = ! empty( $item['link'] ) ? $item['link'] : null; if ( ! $link ) { continue; } ?><a href="<?php echo esc_url( $link['url'] ); ?>" class="sources__item link link--arrow arrow--center"<?php if ( ! empty( $link['target'] ) ) : ?> target="<?php echo esc_attr( $link['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>><span class="sources__item-number"></span><h3 class="h3 sources__item-title"><?php echo esc_html( $link['title'] ); ?></h3></a><?php endforeach; ?>
</section>

<?php
/** Key Takeaways block. @package Velstadt */
$eyebrow = get_field( 'eyebrow' );
$title   = get_field( 'title' );
$cards   = get_field( 'cards' );
if ( ! $eyebrow && ! $title && ! $cards ) { velstadt_post_block_empty( $is_preview, __( 'Add Key Takeaways content.', 'velstadt' ) ); return; }
?>
<section id="<?php echo esc_attr( velstadt_post_block_id( $block, 'key-takeaways' ) ); ?>" class="post__block keys">
	<?php if ( $eyebrow || $title ) : ?><header class="post__block-header"><?php if ( $eyebrow ) : ?><span class="post__block-subtitle"><?php echo esc_html( $eyebrow ); ?></span><?php endif; ?><?php if ( $title ) : ?><h3 class="h3 post__block-title"><?php echo esc_html( $title ); ?></h3><?php endif; ?></header><?php endif; ?>
	<?php if ( $cards ) : ?><div class="keys__grid"><?php foreach ( $cards as $card ) :
		$style = isset( $card['style'] ) && in_array( $card['style'], array( 'danger', 'success', 'warning' ), true ) ? $card['style'] : '';
		?>
		<div class="keys__card"><?php if ( ! empty( $card['icon'] ) ) : ?><span class="keys__card-icon<?php echo $style ? ' ' . esc_attr( $style ) : ''; ?>"><?php echo wp_get_attachment_image( (int) $card['icon'], 'thumbnail', false, array( 'alt' => ! empty( $card['title'] ) ? $card['title'] : '' ) ); ?></span><?php endif; ?><div class="keys__card-col"><?php if ( ! empty( $card['title'] ) ) : ?><h3 class="h4 keys__card-title"><?php echo esc_html( $card['title'] ); ?></h3><?php endif; ?><?php if ( ! empty( $card['content'] ) ) : ?><p><?php echo esc_html( $card['content'] ); ?></p><?php endif; ?></div></div>
	<?php endforeach; ?></div><?php endif; ?>
</section>

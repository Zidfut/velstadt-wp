<?php
/** Quote block. @package Velstadt */
$quote    = get_field( 'quote' );
$image    = get_field( 'author_image' );
$name     = get_field( 'author_name' );
$position = get_field( 'author_position' );
if ( ! $quote && ! $name ) { velstadt_post_block_empty( $is_preview, __( 'Add a quote.', 'velstadt' ) ); return; }
?>
<blockquote id="<?php echo esc_attr( velstadt_post_block_id( $block, 'quote' ) ); ?>" class="post__block quote">
	<?php if ( $quote ) : ?><div class="quote__text"><?php echo wp_kses_post( $quote ); ?></div><?php endif; ?>
	<?php if ( $image || $name || $position ) : ?><footer class="quote__author"><?php if ( $image ) : ?><?php echo wp_get_attachment_image( (int) $image, 'thumbnail', false, array( 'class' => 'quote__author-img', 'alt' => $name ?: '' ) ); ?><?php endif; ?><div class="quote__author-col"><?php if ( $name ) : ?><cite class="h3 quote__author-name"><?php echo esc_html( $name ); ?></cite><?php endif; ?><?php if ( $position ) : ?><span class="quote__author-position"><?php echo esc_html( $position ); ?></span><?php endif; ?></div></footer><?php endif; ?>
</blockquote>

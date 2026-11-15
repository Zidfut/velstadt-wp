<?php
/** Note block. @package Velstadt */
$variant = get_field( 'variant' );
$variant = in_array( $variant, array( 'info', 'alert', 'success' ), true ) ? $variant : 'info';
$title   = get_field( 'title' );
$content = get_field( 'content' );
if ( ! $title && ! $content ) { velstadt_post_block_empty( $is_preview, __( 'Add note content.', 'velstadt' ) ); return; }
?>
<aside id="<?php echo esc_attr( velstadt_post_block_id( $block, 'note' ) ); ?>" class="post__block note note--<?php echo esc_attr( $variant ); ?>"><span class="note__icon"></span><div class="note__content"><?php if ( $title ) : ?><h3 class="h3 note__title"><?php echo esc_html( $title ); ?></h3><?php endif; ?><?php echo $content ? wp_kses_post( $content ) : ''; ?></div></aside>

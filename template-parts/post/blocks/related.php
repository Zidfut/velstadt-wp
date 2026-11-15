<?php
/** Related Reading block. @package Velstadt */
$post = get_field( 'post' );
$post = is_object( $post ) ? $post->ID : (int) $post;
$label = get_field( 'label' ) ?: __( 'Related reading', 'velstadt' );
if ( ! $post ) { velstadt_post_block_empty( $is_preview, __( 'Select a related post.', 'velstadt' ) ); return; }
?>
<a id="<?php echo esc_attr( velstadt_post_block_id( $block, 'related' ) ); ?>" href="<?php echo esc_url( get_permalink( $post ) ); ?>" class="post__block related link--arrow arrow--center"><span class="related__icon"></span><span class="related__content"><span class="related__subtitle"><?php echo esc_html( $label ); ?></span><span class="h3 related__title"><?php echo esc_html( get_the_title( $post ) ); ?></span></span></a>

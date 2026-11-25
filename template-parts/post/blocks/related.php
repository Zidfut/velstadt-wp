<?php
/** Related Reading block. @package Velstadt */
$related_post = get_field( 'post' );
$related_post = is_object( $related_post ) ? $related_post->ID : (int) $related_post;
$label = get_field( 'label' ) ?: __( 'Related reading', 'velstadt' );
if ( ! $related_post ) { velstadt_post_block_empty( $is_preview, __( 'Select a related post.', 'velstadt' ) ); return; }
?>
<a id="<?php echo esc_attr( velstadt_post_block_id( $block, 'related' ) ); ?>" class="post__block related link--arrow arrow--center"<?php if ( $is_preview ) : ?> role="link" aria-disabled="true" tabindex="-1"<?php else : ?> href="<?php echo esc_url( get_permalink( $related_post ) ); ?>"<?php endif; ?>><span class="related__icon"></span><span class="related__content"><span class="related__subtitle"><?php echo esc_html( $label ); ?></span><span class="h3 related__title"><?php echo esc_html( get_the_title( $related_post ) ); ?></span></span></a>

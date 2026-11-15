<?php
/** Download block. @package Velstadt */
$title  = get_field( 'title' );
$meta   = get_field( 'meta' );
$file   = get_field( 'file' );
$label  = get_field( 'button_label' ) ?: __( 'Download', 'velstadt' );
$url    = is_array( $file ) && ! empty( $file['url'] ) ? $file['url'] : '';
if ( ! $title && ! $file ) { velstadt_post_block_empty( $is_preview, __( 'Add a downloadable file.', 'velstadt' ) ); return; }
?>
<section id="<?php echo esc_attr( velstadt_post_block_id( $block, 'download' ) ); ?>" class="post__block download"><span class="download__icon"></span><div class="download__content"><?php if ( $title ) : ?><h3 class="h3 download__title"><?php echo esc_html( $title ); ?></h3><?php endif; ?><?php if ( $meta ) : ?><span class="download__subtitle"><?php echo esc_html( $meta ); ?></span><?php endif; ?></div><?php if ( $url ) : ?><a href="<?php echo esc_url( $url ); ?>" class="btn btn--primary btn--icon" download><span class="icon" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/markup/images/icons/download.svg' ); ?>');"></span><?php echo esc_html( $label ); ?></a><?php endif; ?></section>

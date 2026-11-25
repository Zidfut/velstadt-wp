<?php
/** Reading progress and links to article headings. @package Velstadt */
$toc = $args['toc'] ?? array();
if ( ! $toc ) {
	return;
}
$title = ! empty( $args['title'] ) ? $args['title'] : __( 'On this page', 'velstadt' );
?>
<div class="reading__toc">
	<div class="post__progress">
		<div class="post__progress-header">
			<span class="post__progress-title"><?php echo esc_html( $title ); ?></span>
			<a href="#top" class="post__progress-top" aria-label="<?php esc_attr_e( 'Back to top', 'velstadt' ); ?>"></a>
		</div>
		<div class="post__progress-line"><span class="post__progress-line-current" style="width: 0%;"></span></div>
	</div>
	<nav class="toc" aria-label="<?php esc_attr_e( 'Table of contents', 'velstadt' ); ?>"><ul>
		<?php foreach ( $toc as $item ) : ?><li><a href="#<?php echo esc_attr( $item['id'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a></li><?php endforeach; ?>
	</ul></nav>
</div>

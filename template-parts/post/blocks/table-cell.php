<?php
/** Text, indicator, confidence or technique table cell. @package Velstadt */
$cell = $args['cell'];
$value = isset( $cell['content'] ) ? (string) $cell['content'] : '';
if ( '' === $value ) {
	return;
}
if ( 'ioc' === $args['layout'] && 1 === $args['column'] ) : ?>
	<code class="post__table-indicator"><?php echo esc_html( $value ); ?></code>
<?php elseif ( 'ioc' === $args['layout'] && 2 === $args['column'] ) :
	$color = $cell['badge_color'] ?? 'auto';
	if ( 'auto' === $color ) {
		$colors = array( 'high' => 'green', 'medium' => 'orange', 'low' => 'red' );
		$color = $colors[ strtolower( trim( $value ) ) ] ?? 'gray';
	}
	$color = in_array( $color, array( 'green', 'orange', 'red', 'gray' ), true ) ? $color : 'gray';
	?>
	<span class="post__table-status post__table-status--<?php echo esc_attr( $color ); ?>"><?php echo esc_html( $value ); ?></span>
<?php elseif ( 'mitre' === $args['layout'] && 0 === $args['column'] ) :
	$url = ! empty( $cell['url'] ) ? esc_url( $cell['url'] ) : '';
	$classes = 'post__table-status post__table-status--primary' . ( $url ? ' post__table-status--link' : '' );
	if ( $url && empty( $args['is_preview'] ) ) : ?>
		<a class="<?php echo esc_attr( $classes ); ?>" href="<?php echo $url; ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $value ); ?></a>
	<?php else : ?>
		<span class="<?php echo esc_attr( $classes ); ?>"><?php echo esc_html( $value ); ?></span>
	<?php endif; ?>
<?php else : ?>
	<?php echo nl2br( esc_html( $value ) ); ?>
<?php endif; ?>

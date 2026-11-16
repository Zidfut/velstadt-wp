<?php
/** Code example with a heading and clipboard action. @package Velstadt */
$code = (string) get_field( 'code', false, false );
if ( '' === trim( $code ) ) {
	velstadt_post_block_empty( $is_preview, __( 'Paste a code snippet.', 'velstadt' ) );
	return;
}
$language_field = get_field_object( 'language' );
$language = get_field( 'language' );
$language_label = is_array( $language_field ) && isset( $language_field['choices'][ $language ] ) ? $language_field['choices'][ $language ] : '';
$title = get_field( 'title' );
$heading = $language_label && $title ? $language_label . ' · ' . $title : ( $language_label ?: ( $title ?: __( 'Code', 'velstadt' ) ) );
$id = velstadt_post_block_id( $block, 'code' );
?>
<div id="<?php echo esc_attr( $id ); ?>" class="post__block post__code">
	<div class="post__code-header">
		<span id="<?php echo esc_attr( $id . '-heading' ); ?>" class="post__code-title"><?php echo esc_html( $heading ); ?></span>
		<div class="post__code-actions">
			<span class="post__code-feedback" data-code-status role="status" aria-live="polite"></span>
			<button type="button" class="post__code-copy" data-copy-code data-copy-label="<?php esc_attr_e( 'Copy code', 'velstadt' ); ?>" data-copy-success="<?php esc_attr_e( 'Copied!', 'velstadt' ); ?>" data-copy-error="<?php esc_attr_e( 'Copy failed. Select and copy the code manually.', 'velstadt' ); ?>" aria-label="<?php esc_attr_e( 'Copy code', 'velstadt' ); ?>" title="<?php esc_attr_e( 'Copy code', 'velstadt' ); ?>" aria-controls="<?php echo esc_attr( $id . '-content' ); ?>"><span class="post__code-copy-icon" aria-hidden="true"></span></button>
		</div>
	</div>
	<pre id="<?php echo esc_attr( $id . '-content' ); ?>" class="post__code-content" tabindex="0" aria-labelledby="<?php echo esc_attr( $id . '-heading' ); ?>"><code class="language-<?php echo esc_attr( sanitize_html_class( $language ?: 'text' ) ); ?>"><?php echo esc_html( $code ); ?></code></pre>
</div>

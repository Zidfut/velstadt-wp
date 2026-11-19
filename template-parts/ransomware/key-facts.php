<?php
/** Key facts from the current Ransomware profile. @package Velstadt */
if ( ! function_exists( 'get_field' ) ) {
	return;
}

$profile_id = isset( $args['post_id'] ) ? absint( $args['post_id'] ) : get_the_ID();
$title = get_field( 'ransomware_facts_title', $profile_id );
$facts = get_field( 'ransomware_facts', $profile_id );
$facts = is_array( $facts ) ? array_filter(
	$facts,
	static function ( $fact ) {
		return is_array( $fact ) && ( '' !== trim( (string) ( $fact['label'] ?? '' ) ) || '' !== trim( (string) ( $fact['value'] ?? '' ) ) );
	}
) : array();

if ( ! $facts ) {
	return;
}
?>
<section class="ransomware__facts"<?php if ( $title ) : ?> aria-labelledby="ransomware-facts-title"<?php endif; ?>>
	<?php if ( $title ) : ?><h2 id="ransomware-facts-title" class="ransomware__facts-title"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
	<dl class="ransomware__facts-grid">
		<?php foreach ( $facts as $fact ) : ?>
			<div class="ransomware__fact">
				<dt><?php echo esc_html( $fact['label'] ?? '' ); ?></dt>
				<dd><?php echo esc_html( $fact['value'] ?? '' ); ?></dd>
			</div>
		<?php endforeach; ?>
	</dl>
</section>

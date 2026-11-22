<?php
/** Key Findings block for reports. @package Velstadt */

$heading  = get_field( 'heading' );
$findings = array_filter(
	(array) get_field( 'findings' ),
	static function ( $finding ) {
		return is_array( $finding ) && '' !== trim( (string) ( $finding['text'] ?? '' ) );
	}
);
if ( ! $findings ) {
	velstadt_post_block_empty( $is_preview, __( 'Add at least one finding.', 'velstadt' ) );
	return;
}

$id = velstadt_post_block_id( $block, 'key-findings' );
?>
<section id="<?php echo esc_attr( $id ); ?>" class="post__block report-key-findings"<?php if ( $heading ) : ?> aria-labelledby="<?php echo esc_attr( $id . '-heading' ); ?>"<?php endif; ?>>
	<?php if ( $heading ) : ?>
		<h2 id="<?php echo esc_attr( $id . '-heading' ); ?>" class="report-key-findings__heading"><?php echo esc_html( $heading ); ?></h2>
	<?php endif; ?>
	<ul class="report-key-findings__list" role="list">
		<?php foreach ( $findings as $finding ) : ?>
			<li class="report-key-findings__item">
				<?php if ( ! empty( $finding['icon'] ) ) : ?>
					<?php echo wp_get_attachment_image( (int) $finding['icon'], 'thumbnail', false, array( 'class' => 'report-key-findings__icon', 'alt' => '' ) ); ?>
				<?php endif; ?>
				<p><?php echo esc_html( $finding['text'] ); ?></p>
			</li>
		<?php endforeach; ?>
	</ul>
</section>

<?php
/** Compact footer using the existing site Options. @package Velstadt */
$copyright = str_replace( '{year}', wp_date( 'Y' ), (string) velstadt_get_footer_option( 'footer_copyright' ) );
$legal_links = (array) velstadt_get_footer_option( 'footer_legal_links' );
$compliance_label = velstadt_get_footer_option( 'footer_compliance_label' );
$compliance_items = (array) velstadt_get_footer_option( 'footer_compliance_items' );
$icon_id = function_exists( 'get_field' ) ? (int) get_field( 'demo_compliance_icon' ) : 0;
?>
<footer class="request-demo__footer">
	<div class="container request-demo__footer-container">
		<span><?php echo esc_html( $copyright ); ?></span>
		<?php if ( $legal_links ) : ?>
			<nav aria-label="<?php esc_attr_e( 'Legal navigation', 'velstadt' ); ?>"><ul>
				<?php foreach ( $legal_links as $row ) : $link = velstadt_normalize_footer_link( $row['link'] ?? array() ); ?>
					<li><a href="<?php echo esc_url( $link['url'] ); ?>"<?php if ( $link['target'] ) : ?> target="<?php echo esc_attr( $link['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>><?php echo esc_html( $link['title'] ); ?></a></li>
				<?php endforeach; ?>
			</ul></nav>
		<?php endif; ?>
		<div class="request-demo__compliance">
			<span><?php echo esc_html( $compliance_label ); ?></span>
			<ul><?php foreach ( $compliance_items as $item ) : ?>
				<li><?php if ( $icon_id ) { echo wp_get_attachment_image( $icon_id, 'full', false, array( 'alt' => '' ) ); } ?><?php echo esc_html( $item['label'] ?? '' ); ?></li>
			<?php endforeach; ?></ul>
		</div>
	</div>
</footer>

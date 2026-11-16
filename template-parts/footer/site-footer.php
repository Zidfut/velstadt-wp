<?php
/**
 * Editable site footer.
 *
 * @package Velstadt
 */

$defaults         = velstadt_footer_default_content();
$has_scf          = function_exists( 'get_field' );
$description      = velstadt_get_footer_option( 'footer_description', 'Protecting your digital life with modern cybersecurity solutions.' );
$show_badge       = $has_scf ? (bool) get_field( 'footer_show_badge', 'option' ) : true;
$badge_alt        = velstadt_get_footer_option( 'footer_badge_alt', __( 'Supported by Google', 'velstadt' ) );
$ai_label         = velstadt_get_footer_option( 'footer_ai_label', __( 'Talk to us in', 'velstadt' ) );
$ai_links         = velstadt_get_footer_option( 'footer_ai_links', $has_scf ? array() : $defaults['ai_links'] );
$menu_columns     = velstadt_get_footer_option( 'footer_menu_columns', $has_scf ? array() : $defaults['menu_columns'] );
$locations        = velstadt_get_footer_option( 'footer_locations', $has_scf ? array() : $defaults['locations'] );
$contact_title    = velstadt_get_footer_option( 'footer_contact_title', __( 'Contacts', 'velstadt' ) );
$contact_links    = velstadt_get_footer_option( 'footer_contact_links', $has_scf ? array() : $defaults['contact_links'] );
$socials          = velstadt_get_footer_option( 'footer_socials', $has_scf ? array() : $defaults['socials'] );
$copyright        = velstadt_get_footer_option( 'footer_copyright', '© {year} Velstadt LLC. All rights reserved.' );
$legal_links      = velstadt_get_footer_option( 'footer_legal_links', $has_scf ? array() : $defaults['legal_links'] );
$compliance_label = velstadt_get_footer_option( 'footer_compliance_label', __( 'Compliance', 'velstadt' ) );
$compliance_items = velstadt_get_footer_option( 'footer_compliance_items', $has_scf ? array() : $defaults['compliance_items'] );
$footer_logo      = velstadt_get_footer_option( 'footer_logo' );
$logo_url         = velstadt_footer_image_url( $footer_logo );
$badge_url        = velstadt_footer_image_url( velstadt_get_footer_option( 'footer_badge' ) );
$copyright        = str_replace( '{year}', wp_date( 'Y' ), (string) $copyright );
$ai_links         = is_array( $ai_links ) ? $ai_links : array();
$menu_columns     = is_array( $menu_columns ) ? $menu_columns : array();
$locations        = is_array( $locations ) ? $locations : array();
$contact_links    = is_array( $contact_links ) ? $contact_links : array();
$socials          = is_array( $socials ) ? $socials : array();
$legal_links      = is_array( $legal_links ) ? $legal_links : array();
$compliance_items = is_array( $compliance_items ) ? $compliance_items : array();

/**
 * Build escaped target attributes for an SCF link.
 *
 * @param array $link Normalized link.
 * @return string
 */
$target_attributes = static function ( $link ) {
	return ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : '';
};
?>
<footer id="colophon" class="footer">
	<div class="container footer__container section__lines">
		<div class="footer__top">
			<div class="footer__top-left">
				<div class="footer__top-col">
					<?php if ( $logo_url ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer__logo" rel="home">
							<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
						</a>
					<?php endif; ?>
					<?php if ( $description ) : ?>
						<p><?php echo esc_html( $description ); ?></p>
					<?php endif; ?>
				</div>
				<?php if ( $show_badge && $badge_url ) : ?>
					<img src="<?php echo esc_url( $badge_url ); ?>" alt="<?php echo esc_attr( $badge_alt ); ?>" class="footer__top-badge">
				<?php endif; ?>
			</div>

			<?php if ( $ai_label || $ai_links ) : ?>
				<div class="footer__top-right">
					<?php if ( $ai_label ) : ?>
						<span class="footer__top-text"><?php echo esc_html( $ai_label ); ?></span>
					<?php endif; ?>
					<?php if ( $ai_links ) : ?>
						<div class="footer__top-buttons">
							<?php foreach ( $ai_links as $ai_item ) : ?>
								<?php
								$ai_link = velstadt_normalize_footer_link( isset( $ai_item['link'] ) ? $ai_item['link'] : array() );
								$ai_icon = velstadt_footer_image_url( isset( $ai_item['icon'] ) ? $ai_item['icon'] : null );
								?>
								<a href="<?php echo esc_url( $ai_link['url'] ); ?>" class="btn btn--icon"<?php echo $target_attributes( $ai_link ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
									<?php if ( $ai_icon ) : ?>
										<span class="icon" style="background-image: url('<?php echo esc_url( $ai_icon ); ?>');"></span>
									<?php endif; ?>
									<?php echo esc_html( $ai_link['title'] ); ?>
								</a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( $menu_columns ) : ?>
			<div class="footer__mid">
				<?php foreach ( $menu_columns as $column ) : ?>
					<?php $heading_link = velstadt_normalize_footer_link( isset( $column['heading_link'] ) ? $column['heading_link'] : array() ); ?>
					<div class="footer__mid-item">
						<a href="<?php echo esc_url( $heading_link['url'] ); ?>" class="footer__link"<?php echo $target_attributes( $heading_link ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $heading_link['title'] ); ?></a>
						<?php if ( ! empty( $column['links'] ) ) : ?>
							<ul>
								<?php foreach ( $column['links'] as $link_row ) : ?>
									<?php $item_link = velstadt_normalize_footer_link( isset( $link_row['link'] ) ? $link_row['link'] : array() ); ?>
									<li><a href="<?php echo esc_url( $item_link['url'] ); ?>"<?php echo $target_attributes( $item_link ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $item_link['title'] ); ?></a></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( $locations || $contact_links || $socials ) : ?>
			<div class="footer__bot">
				<?php foreach ( $locations as $location ) : ?>
					<div class="footer__bot-item">
						<h3 class="h3 footer__bot-title"><?php echo esc_html( isset( $location['title'] ) ? $location['title'] : '' ); ?></h3>
						<ul>
							<?php if ( ! empty( $location['address_link'] ) ) : ?>
								<?php $address_link = velstadt_normalize_footer_link( $location['address_link'] ); ?>
								<li><a href="<?php echo esc_url( $address_link['url'] ); ?>" class="footer__bot-link icon icon--pin"<?php echo $target_attributes( $address_link ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $address_link['title'] ); ?></a></li>
							<?php endif; ?>
							<?php if ( ! empty( $location['phone_link'] ) ) : ?>
								<?php $phone_link = velstadt_normalize_footer_link( $location['phone_link'] ); ?>
								<li><a href="<?php echo esc_url( $phone_link['url'] ); ?>" class="footer__bot-link icon icon--phone"<?php echo $target_attributes( $phone_link ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $phone_link['title'] ); ?></a></li>
							<?php endif; ?>
						</ul>
					</div>
				<?php endforeach; ?>

				<?php if ( $contact_links || $socials ) : ?>
					<div class="footer__bot-item">
						<?php if ( $contact_title ) : ?>
							<h3 class="h3 footer__bot-title"><?php echo esc_html( $contact_title ); ?></h3>
						<?php endif; ?>
						<?php if ( $contact_links ) : ?>
							<ul>
								<?php foreach ( $contact_links as $contact ) : ?>
									<?php
									$contact_link = velstadt_normalize_footer_link( isset( $contact['link'] ) ? $contact['link'] : array() );
									$contact_icon = isset( $contact['icon'] ) && in_array( $contact['icon'], array( 'email', 'phone', 'pin' ), true ) ? $contact['icon'] : 'email';
									?>
									<li><a href="<?php echo esc_url( $contact_link['url'] ); ?>" class="footer__bot-link icon icon--<?php echo esc_attr( $contact_icon ); ?>"<?php echo $target_attributes( $contact_link ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $contact_link['title'] ); ?></a></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>

						<?php if ( $socials ) : ?>
							<div class="footer__socials">
								<ul>
									<?php foreach ( $socials as $social ) : ?>
										<?php
										$social_link = velstadt_normalize_footer_link( isset( $social['link'] ) ? $social['link'] : array() );
										$social_icon = velstadt_footer_image_url( isset( $social['icon'] ) ? $social['icon'] : null );
										?>
										<li>
											<a href="<?php echo esc_url( $social_link['url'] ); ?>" class="social__link" aria-label="<?php echo esc_attr( $social_link['title'] ); ?>"<?php echo $target_attributes( $social_link ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
												<?php if ( $social_icon ) : ?>
													<span style="mask-image: url('<?php echo esc_url( $social_icon ); ?>'); -webkit-mask-image: url('<?php echo esc_url( $social_icon ); ?>');"></span>
												<?php endif; ?>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="footer__copyright">
			<?php if ( $copyright ) : ?>
				<span class="copyright"><?php echo esc_html( $copyright ); ?></span>
			<?php endif; ?>
			<?php if ( $legal_links ) : ?>
				<nav class="copyright__nav" aria-label="<?php esc_attr_e( 'Legal navigation', 'velstadt' ); ?>">
					<ul>
						<?php foreach ( $legal_links as $legal_row ) : ?>
							<?php $legal_link = velstadt_normalize_footer_link( isset( $legal_row['link'] ) ? $legal_row['link'] : array() ); ?>
							<li><a href="<?php echo esc_url( $legal_link['url'] ); ?>"<?php echo $target_attributes( $legal_link ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $legal_link['title'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php endif; ?>
			<?php if ( $compliance_label || $compliance_items ) : ?>
				<div class="compliance">
					<?php if ( $compliance_label ) : ?>
						<span><?php echo esc_html( $compliance_label ); ?></span>
					<?php endif; ?>
					<?php if ( $compliance_items ) : ?>
						<ul>
							<?php foreach ( $compliance_items as $item ) : ?>
								<li><?php echo esc_html( isset( $item['label'] ) ? $item['label'] : '' ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</footer>

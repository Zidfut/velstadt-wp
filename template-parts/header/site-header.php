<?php
/**
 * Editable site header.
 *
 * @package Velstadt
 */

$navigation    = velstadt_get_header_option( 'header_navigation', function_exists( 'get_field' ) ? array() : velstadt_header_default_navigation() );
$incident_link = velstadt_normalize_header_link( velstadt_get_header_option( 'header_incident_link', velstadt_header_default_link( 'Active incident?' ) ), __( 'Active incident?', 'velstadt' ) );
$sign_in_link  = velstadt_normalize_header_link( velstadt_get_header_option( 'header_sign_in_link', velstadt_header_default_link( 'Sign in' ) ), __( 'Sign in', 'velstadt' ) );
$demo_link     = velstadt_normalize_header_link( velstadt_get_header_option( 'header_demo_link', velstadt_header_default_link( 'Request a demo' ) ), __( 'Request a demo', 'velstadt' ) );
$header_logo   = velstadt_get_header_option( 'header_logo' );
$logo_url      = velstadt_header_image_url( $header_logo );

/**
 * Render a feature card used in a mega menu.
 *
 * @param array $item Navigation item data.
 */
$render_feature = static function ( $item ) {
	$type      = ! empty( $item['feature_type'] ) ? $item['feature_type'] : 'none';
	$image_url = velstadt_header_image_url( isset( $item['feature_image'] ) ? $item['feature_image'] : null, isset( $item['feature_asset'] ) ? $item['feature_asset'] : '' );
	$link      = velstadt_normalize_header_link( isset( $item['feature_link'] ) ? $item['feature_link'] : array(), isset( $item['feature_title'] ) ? $item['feature_title'] : '' );
	$target    = $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : '';

	if ( 'ranking' === $type ) {
		?>
		<div class="award__card">
			<?php if ( $image_url ) : ?>
				<img src="<?php echo esc_url( $image_url ); ?>" alt="" class="award__card-img">
			<?php endif; ?>
			<?php if ( ! empty( $item['feature_eyebrow'] ) ) : ?>
				<span class="award__card-name"><?php echo esc_html( $item['feature_eyebrow'] ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $item['feature_number'] ) ) : ?>
				<span class="award__card-number"><?php echo esc_html( $item['feature_number'] ); ?></span>
			<?php endif; ?>
			<div class="award__card-footer">
				<div class="award__card-info">
					<?php if ( ! empty( $item['feature_title'] ) ) : ?>
						<span class="award__card-title"><?php echo esc_html( $item['feature_title'] ); ?></span>
					<?php endif; ?>
					<?php if ( ! empty( $item['feature_meta'] ) ) : ?>
						<span class="award__card-details"><?php echo esc_html( $item['feature_meta'] ); ?></span>
					<?php endif; ?>
				</div>
				<?php if ( $link['title'] ) : ?>
					<a href="<?php echo esc_url( $link['url'] ); ?>" class="link--arrow award__card-link"<?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $link['title'] ); ?></a>
				<?php endif; ?>
			</div>
		</div>
		<?php
	} elseif ( 'recognition' === $type ) {
		?>
		<div class="award__card">
			<?php if ( $image_url ) : ?>
				<img src="<?php echo esc_url( $image_url ); ?>" alt="">
			<?php endif; ?>
			<div class="award__card-description">
				<?php if ( ! empty( $item['feature_title'] ) ) : ?>
					<span class="award__card-title"><?php echo esc_html( $item['feature_title'] ); ?></span>
				<?php endif; ?>
				<?php if ( ! empty( $item['feature_meta'] ) ) : ?>
					<span class="award__card-subtitle"><?php echo esc_html( $item['feature_meta'] ); ?></span>
				<?php endif; ?>
			</div>
		</div>
		<?php
	} elseif ( 'customer' === $type ) {
		?>
		<a href="<?php echo esc_url( $link['url'] ); ?>" class="customer__card"<?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php if ( ! empty( $item['feature_quote'] ) ) : ?>
				<p class="customer__card-quote"><?php echo esc_html( $item['feature_quote'] ); ?></p>
			<?php endif; ?>
			<div class="customer__card-info">
				<?php if ( ! empty( $item['feature_stat'] ) ) : ?>
					<span class="customer__card-issue"><?php echo esc_html( $item['feature_stat'] ); ?></span>
				<?php endif; ?>
				<?php if ( ! empty( $item['feature_stat_label'] ) ) : ?>
					<span class="customer__card-service"><?php echo esc_html( $item['feature_stat_label'] ); ?></span>
				<?php endif; ?>
			</div>
			<?php if ( $image_url ) : ?>
				<div class="customer__card-footer"><span class="link--arrow"><img src="<?php echo esc_url( $image_url ); ?>" alt="" class="customer__card-logo"></span></div>
			<?php endif; ?>
		</a>
		<?php
	}
};
?>
<header id="masthead" class="header">
	<div class="container header__container">
		<div class="header__menu">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header__logo" rel="home">
				<?php
				if ( $logo_url ) {
					printf( '<img src="%1$s" alt="%2$s">', esc_url( $logo_url ), esc_attr( get_bloginfo( 'name' ) ) );
				} elseif ( has_custom_logo() ) {
					echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'full', false, array( 'alt' => get_bloginfo( 'name' ) ) );
				} else {
					printf( '<img src="%1$s" alt="%2$s">', esc_url( get_template_directory_uri() . '/markup/images/logo.svg' ), esc_attr( get_bloginfo( 'name' ) ) );
				}
				?>
			</a>

			<div id="header-navigation" class="header__nav-wrap">
				<div class="header__nav-top"></div>
				<nav class="header__nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'velstadt' ); ?>">
					<ul>
						<?php foreach ( $navigation as $nav_item ) : ?>
							<?php
							$label         = ! empty( $nav_item['label'] ) ? $nav_item['label'] : '';
							$link          = velstadt_normalize_header_link( isset( $nav_item['link'] ) ? $nav_item['link'] : array(), $label );
							$dropdown_type = ! empty( $nav_item['dropdown_type'] ) ? $nav_item['dropdown_type'] : 'none';
							$panels        = ! empty( $nav_item['panels'] ) && is_array( $nav_item['panels'] ) ? $nav_item['panels'] : array();
							$has_dropdown  = 'none' !== $dropdown_type && ! empty( $panels );
							$link_target   = $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : '';
							?>
							<li<?php echo $has_dropdown ? ' class="dropdown"' : ''; ?>>
								<a href="<?php echo esc_url( $link['url'] ); ?>" class="header__nav-link"<?php echo $link_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
									<?php if ( $has_dropdown ) : ?>
										<span><?php echo esc_html( $label ); ?></span>
										<button class="dropdown__btn" type="button" aria-label="<?php echo esc_attr( sprintf( __( 'Toggle %s menu', 'velstadt' ), $label ) ); ?>" aria-expanded="false"></button>
									<?php else : ?>
										<?php echo esc_html( $label ); ?>
									<?php endif; ?>
								</a>

								<?php if ( $has_dropdown ) : ?>
									<div class="dropdown__list-wrap">
										<div class="dropdown__list">
											<?php if ( 'tabs' === $dropdown_type ) : ?>
												<div class="dropdown__tabs">
													<div class="dropdown__tabs-list">
														<span class="dropdown__tabs-title"><?php echo esc_html( $label ); ?></span>
														<ul>
															<?php foreach ( $panels as $panel_index => $panel ) : ?>
																<li><button class="dropdown__link<?php echo 0 === $panel_index ? ' active' : ''; ?>" type="button"><span class="dropdown__link-title"><?php echo esc_html( isset( $panel['tab_label'] ) ? $panel['tab_label'] : '' ); ?></span></button></li>
															<?php endforeach; ?>
														</ul>
													</div>
													<?php $render_feature( $nav_item ); ?>
												</div>
											<?php else : ?>
												<?php $render_feature( $nav_item ); ?>
											<?php endif; ?>

											<?php foreach ( $panels as $panel_index => $panel ) : ?>
												<div class="dropdown__nav<?php echo 'tabs' === $dropdown_type && 0 === $panel_index ? ' active' : ''; ?>">
													<?php foreach ( isset( $panel['columns'] ) && is_array( $panel['columns'] ) ? $panel['columns'] : array() as $column ) : ?>
														<div class="dropdown__nav-item">
															<?php if ( ! empty( $column['title'] ) ) : ?>
																<span class="dropdown__nav-title"><?php echo esc_html( $column['title'] ); ?></span>
															<?php endif; ?>
															<ul>
																<?php foreach ( isset( $column['links'] ) && is_array( $column['links'] ) ? $column['links'] : array() as $menu_link ) : ?>
																	<?php
																	$item_link   = velstadt_normalize_header_link( isset( $menu_link['link'] ) ? $menu_link['link'] : array() );
																	$item_target = $item_link['target'] ? ' target="' . esc_attr( $item_link['target'] ) . '" rel="noopener noreferrer"' : '';
																	?>
																	<li>
																		<a href="<?php echo esc_url( $item_link['url'] ); ?>" class="dropdown__link link--arrow arrow--center"<?php echo $item_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
																			<span class="dropdown__link-title"><?php echo esc_html( $item_link['title'] ); ?></span>
																			<?php if ( ! empty( $menu_link['description'] ) ) : ?>
																				<span class="dropdown__link-description"><?php echo esc_html( $menu_link['description'] ); ?></span>
																			<?php endif; ?>
																		</a>
																	</li>
																<?php endforeach; ?>
															</ul>
														</div>
													<?php endforeach; ?>
												</div>
											<?php endforeach; ?>
										</div>
									</div>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>

				<div class="header__nav-footer">
					<a href="<?php echo esc_url( $incident_link['url'] ); ?>" class="header__link header__link-mobile icon icon--alert"<?php echo $incident_link['target'] ? ' target="' . esc_attr( $incident_link['target'] ) . '" rel="noopener noreferrer"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $incident_link['title'] ); ?></a>
					<div class="header__buttons header__buttons--mobile">
						<a href="<?php echo esc_url( $sign_in_link['url'] ); ?>" class="btn"<?php echo $sign_in_link['target'] ? ' target="' . esc_attr( $sign_in_link['target'] ) . '" rel="noopener noreferrer"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $sign_in_link['title'] ); ?></a>
						<a href="<?php echo esc_url( $demo_link['url'] ); ?>" class="btn btn--primary"<?php echo $demo_link['target'] ? ' target="' . esc_attr( $demo_link['target'] ) . '" rel="noopener noreferrer"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $demo_link['title'] ); ?></a>
					</div>
				</div>
			</div>

			<a href="<?php echo esc_url( $incident_link['url'] ); ?>" class="header__link header__link-desktop icon icon--alert"<?php echo $incident_link['target'] ? ' target="' . esc_attr( $incident_link['target'] ) . '" rel="noopener noreferrer"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $incident_link['title'] ); ?></a>
			<div class="header__buttons header__buttons--desktop">
				<a href="<?php echo esc_url( $sign_in_link['url'] ); ?>" class="btn"<?php echo $sign_in_link['target'] ? ' target="' . esc_attr( $sign_in_link['target'] ) . '" rel="noopener noreferrer"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $sign_in_link['title'] ); ?></a>
				<a href="<?php echo esc_url( $demo_link['url'] ); ?>" class="btn btn--primary"<?php echo $demo_link['target'] ? ' target="' . esc_attr( $demo_link['target'] ) . '" rel="noopener noreferrer"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $demo_link['title'] ); ?></a>
			</div>

			<button class="header__mobile-btn" type="button" aria-controls="header-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'velstadt' ); ?>">
				<span></span><span></span><span></span>
			</button>
		</div>
	</div>
</header>

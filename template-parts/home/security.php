<?php
/**
 * Home security section.
 *
 * @package Velstadt
 */

$has_scf     = function_exists( 'get_field' );
$show        = $has_scf ? (bool) get_field( 'home_security_show' ) : true;
$subtitle    = velstadt_get_home_field( 'home_security_subtitle', 'A new security reality' );
$title       = velstadt_get_home_field( 'home_security_title', 'Threats move faster.' );
$highlight   = velstadt_get_home_field( 'home_security_title_highlight', 'Your intelligence should too' );
$description = velstadt_get_home_field( 'home_security_description', 'Velstadt connects threat signals to your business context and validates critical findings before they reach your team.' );
$steps       = velstadt_get_home_field( 'home_security_steps', velstadt_home_default_security_steps() );
$cards       = velstadt_get_home_field( 'home_security_cards', velstadt_home_default_security_cards() );
$steps       = is_array( $steps ) ? $steps : array();
$cards       = is_array( $cards ) ? $cards : array();

if ( ! $show ) {
	return;
}
?>
<section class="section security">
	<div class="container security__container section__lines section__lines-white">
		<div class="security__content">
			<div class="security__header">
				<?php if ( $subtitle ) : ?><h3 class="h3 section__subtitle"><?php echo esc_html( $subtitle ); ?></h3><?php endif; ?>
				<?php if ( $title || $highlight ) : ?>
					<h2 class="h2 section__title"><?php echo esc_html( $title ); ?><?php if ( $highlight ) : ?><br><span><?php echo esc_html( $highlight ); ?></span><?php endif; ?></h2>
				<?php endif; ?>
				<?php if ( $description ) : ?><p><?php echo esc_html( $description ); ?></p><?php endif; ?>
			</div>

			<?php if ( $steps ) : ?>
				<div class="security__steps">
					<?php foreach ( $steps as $step ) : ?>
						<div class="security__steps-item">
							<div class="security__steps-content">
								<div class="security__steps-text">
									<?php if ( ! empty( $step['title'] ) ) : ?><h3 class="h3 security__steps-title"><?php echo esc_html( $step['title'] ); ?></h3><?php endif; ?>
									<?php if ( ! empty( $step['description'] ) ) : ?><span class="security__steps-description"><?php echo esc_html( $step['description'] ); ?></span><?php endif; ?>
								</div>
								<?php if ( ! empty( $step['number'] ) ) : ?><span class="security__steps-number"><?php echo esc_html( $step['number'] ); ?></span><?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
					<div class="security__steps-line"><span class="security__steps-dot"></span></div>
				</div>
			<?php endif; ?>

			<?php if ( $cards ) : ?>
				<div class="security__cards">
					<?php foreach ( $cards as $card ) : ?>
						<?php
						$style       = isset( $card['style'] ) && in_array( (string) $card['style'], array( '1', '2', '3' ), true ) ? (string) $card['style'] : '3';
						$label_class = isset( $card['label_class'] ) && in_array( $card['label_class'], array( 'primary', 'blue', 'green', 'purple' ), true ) ? $card['label_class'] : 'primary';
						$footer      = ! empty( $card['footer_items'] ) && is_array( $card['footer_items'] ) ? $card['footer_items'] : array();
						$image_url   = velstadt_header_image_url( isset( $card['image'] ) ? $card['image'] : null );
						?>
						<div class="security__card security__card-<?php echo esc_attr( $style ); ?>">
							<?php if ( ! empty( $card['label'] ) ) : ?><span class="security__card-label label-<?php echo esc_attr( $label_class ); ?>"><?php echo esc_html( $card['label'] ); ?></span><?php endif; ?>
							<div class="security__card-content">
								<?php if ( ! empty( $card['value'] ) ) : ?><h3 class="h3 security__card-title"><?php echo esc_html( $card['value'] ); ?></h3><?php endif; ?>
								<?php if ( ! empty( $card['subtitle'] ) ) : ?><span class="security__card-subtitle"><?php echo esc_html( $card['subtitle'] ); ?></span><?php endif; ?>
							</div>
							<?php if ( $footer || $image_url || ! empty( $card['footer_text'] ) ) : ?>
								<div class="security__card-footer">
									<?php if ( $footer ) : ?>
										<ul><?php foreach ( $footer as $item ) : ?><?php if ( ! empty( $item['label'] ) ) : ?><li><?php echo esc_html( $item['label'] ); ?></li><?php endif; ?><?php endforeach; ?></ul>
									<?php else : ?>
										<?php if ( $image_url ) : ?><img src="<?php echo esc_url( $image_url ); ?>" alt=""><?php endif; ?>
										<?php if ( ! empty( $card['footer_text'] ) ) : ?><p><?php echo esc_html( $card['footer_text'] ); ?></p><?php endif; ?>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

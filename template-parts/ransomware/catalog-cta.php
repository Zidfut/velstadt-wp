<?php
/** Catalog exposure guidance. @package Velstadt */
$page_id = (int) $args['page_id'];
$cards = get_field( 'ransomware_cta_cards', $page_id ) ?: array();
$title = get_field( 'ransomware_cta_title', $page_id );
if ( ! $title && ! $cards ) { return; }
?>
<section class="ransomware__cta" aria-labelledby="ransomware-cta-title">
	<div class="container section__lines ransomware__cta-container">
		<div class="ransomware__cta-intro">
			<div class="ransomware__cta-heading">
				<?php if ( get_field( 'ransomware_cta_eyebrow', $page_id ) ) : ?><span><?php echo esc_html( get_field( 'ransomware_cta_eyebrow', $page_id ) ); ?></span><?php endif; ?>
				<h2 id="ransomware-cta-title"><?php echo esc_html( $title ); ?></h2>
			</div>
			<?php if ( get_field( 'ransomware_cta_description', $page_id ) ) : ?><p><?php echo esc_html( get_field( 'ransomware_cta_description', $page_id ) ); ?></p><?php endif; ?>
		</div>
		<?php if ( $cards ) : ?>
			<div class="ransomware__cta-cards">
				<?php foreach ( $cards as $card ) : ?>
					<div class="ransomware__cta-card">
						<div><h3><?php echo esc_html( $card['title'] ); ?></h3><p><?php echo esc_html( $card['description'] ); ?></p></div>
						<?php if ( ! empty( $card['tags'] ) ) : ?><ul><?php foreach ( $card['tags'] as $tag ) : ?><li><?php echo esc_html( $tag['text'] ); ?></li><?php endforeach; ?></ul><?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

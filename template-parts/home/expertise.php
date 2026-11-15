<?php
/**
 * Home expertise section.
 *
 * @package Velstadt
 */

$has_scf  = function_exists( 'get_field' );
$show     = $has_scf ? (bool) get_field( 'home_expertise_show' ) : true;
$subtitle = velstadt_get_home_field( 'home_expertise_subtitle', 'Team expertise' );
$title    = velstadt_get_home_field( 'home_expertise_title', 'Hands-on credentials' );
$items    = velstadt_get_home_field( 'home_expertise_items', velstadt_home_default_expertise_items() );
$items    = is_array( $items ) ? $items : array();

if ( ! $show ) {
	return;
}
?>
<section class="section expertise">
	<div class="section__header">
		<div class="container section__header-container section__lines">
			<div class="section__header-left">
				<?php if ( $subtitle ) : ?><h3 class="h3 section__subtitle"><?php echo esc_html( $subtitle ); ?></h3><?php endif; ?>
				<?php if ( $title ) : ?><h2 class="h2 section__title"><?php echo esc_html( $title ); ?></h2><?php endif; ?>
			</div>

			<?php if ( $items ) : ?>
				<div class="section__header-right">
					<?php foreach ( $items as $item ) : ?>
						<?php
						$link   = ! empty( $item['link'] ) ? velstadt_normalize_header_link( $item['link'] ) : null;
						$tag    = $link ? 'a' : 'div';
						$class  = 'expertise__card' . ( $link ? ' link--arrow arrow--center' : '' );
						$target = $link && $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : '';
						?>
						<<?php echo tag_escape( $tag ); ?> class="<?php echo esc_attr( $class ); ?>"<?php if ( $link ) : ?> href="<?php echo esc_url( $link['url'] ); ?>"<?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php endif; ?>>
							<?php if ( ! empty( $item['title'] ) ) : ?><h3 class="h3 expertise__card-title"><?php echo esc_html( $item['title'] ); ?></h3><?php endif; ?>
							<?php if ( ! empty( $item['description'] ) ) : ?><span class="expertise__card-description"><?php echo esc_html( $item['description'] ); ?></span><?php endif; ?>
						</<?php echo tag_escape( $tag ); ?>>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

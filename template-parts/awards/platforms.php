<?php
/**
 * Featured award platforms.
 *
 * @package Velstadt
 */

$show_section = function_exists( 'get_field' ) ? get_field( 'awards_platforms_show' ) : true;
if ( false === $show_section || 0 === $show_section || '0' === $show_section ) {
	return;
}

$platforms     = array();
$platform_rows = function_exists( 'get_field' ) ? get_field( 'awards_platform_cards', get_queried_object_id() ) : array();

if ( is_array( $platform_rows ) ) {
	foreach ( $platform_rows as $row ) {
		$value   = isset( $row['platform'] ) ? $row['platform'] : 0;
		$term_id = is_object( $value ) && isset( $value->term_id ) ? (int) $value->term_id : (int) $value;
		$term    = $term_id ? get_term( $term_id, 'award_platform' ) : null;

		if ( $term && ! is_wp_error( $term ) ) {
			$platforms[ $term->term_id ] = $term;
		}
	}
}

// Preserve the existing featured-platform setup until a manual selection is saved.
if ( ! $platforms ) {
	$featured_platforms = get_terms( array( 'taxonomy' => 'award_platform', 'hide_empty' => false ) );
	$featured_platforms = is_wp_error( $featured_platforms ) ? array() : $featured_platforms;
	foreach ( $featured_platforms as $platform ) {
		if ( get_field( 'platform_featured', 'award_platform_' . $platform->term_id ) ) {
			$platforms[ $platform->term_id ] = $platform;
		}
	}
}

if ( ! $platforms ) {
	return;
}
?>
<section class="section awards__cards">
	<div class="container awards__cards-container section__lines">
		<?php foreach ( $platforms as $platform ) : ?>
			<?php
			$context     = 'award_platform_' . $platform->term_id;
			$logo        = get_field( 'platform_logo', $context );
			$logo_asset  = get_field( 'platform_logo_asset', $context );
			$logo_url    = velstadt_header_image_url( $logo, $logo_asset );
			$rating      = get_field( 'platform_rating', $context );
			$headline    = get_field( 'platform_headline', $context );
			$description = get_field( 'platform_description', $context );
			$link         = velstadt_normalize_header_link( get_field( 'platform_link', $context ), $platform->name );
			$target       = $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : '';
			?>
			<div class="awards__cards-item">
				<a href="<?php echo esc_url( $link['url'] ); ?>" class="awards__cards-top link--arrow"<?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
					<div class="awards__cards-header">
						<?php if ( $logo_url ) : ?>
							<span class="awards__cards-icon"><img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $platform->name ); ?>"></span>
						<?php endif; ?>
						<span class="awards__cards-name"><?php echo esc_html( $platform->name ); ?></span>
					</div>
				</a>
				<?php if ( $rating ) : ?><div class="awards__cards-mid"><span class="awards__cards-rating"><?php echo esc_html( $rating ); ?></span></div><?php endif; ?>
				<div class="awards__cards-bot">
					<?php if ( $headline ) : ?><h3 class="h3 awards__cards-title"><?php echo esc_html( $headline ); ?></h3><?php endif; ?>
					<?php if ( $description ) : ?><p><?php echo esc_html( $description ); ?></p><?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

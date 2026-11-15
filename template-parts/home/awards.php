<?php
/**
 * Home awards section populated by the manual SCF relationship field.
 *
 * @package Velstadt
 */

$front_page_id = get_queried_object_id();
$show_value    = get_post_meta( $front_page_id, 'home_awards_show', true );
$show_section  = metadata_exists( 'post', $front_page_id, 'home_awards_show' ) ? (bool) $show_value : true;
$subtitle      = get_field( 'home_awards_subtitle', $front_page_id ) ?: 'Independent recognition';
$title         = get_field( 'home_awards_title', $front_page_id ) ?: 'Proof that speaks for itself';
$description   = get_field( 'home_awards_description', $front_page_id ) ?: "Independent rating platforms recognize Velstadt's expertise in cybersecurity, threat monitoring, and technology consulting.";
$selected      = get_field( 'home_awards_selected', $front_page_id );
$selected      = is_array( $selected ) ? array_values(
	array_filter(
		array_map(
			static function ( $award ) {
				return is_object( $award ) && isset( $award->ID ) ? (int) $award->ID : (int) $award;
			},
			$selected
		)
	)
) : array();
$selected      = array_slice( $selected, 0, 5 );

if ( ! $show_section || ! $selected ) {
	return;
}

$render_award = static function ( $award_id, $show_link = false ) {
	$platforms = get_the_terms( $award_id, 'award_platform' );
	$platform  = $platforms && ! is_wp_error( $platforms ) ? reset( $platforms ) : null;
	$badge_url = velstadt_get_award_badge_url( $award_id );
	$year      = get_field( 'award_year', $award_id );
	$position  = get_field( 'award_ranking_position', $award_id );
	$number    = $position ? '№' . absint( $position ) : $year;
	$details   = get_field( 'award_details', $award_id ) ?: sprintf( '%s recognition', $year );
	$link      = get_field( 'award_external_link', $award_id );
	?>
	<div class="awards__card">
		<?php if ( $badge_url ) : ?><img src="<?php echo esc_url( $badge_url ); ?>" alt="" class="awards__card-img"><?php endif; ?>
		<?php if ( $platform ) : ?><span class="awards__card-name"><?php echo esc_html( $platform->name ); ?></span><?php endif; ?>
		<?php if ( $number ) : ?><span class="awards__card-number"><?php echo esc_html( $number ); ?></span><?php endif; ?>
		<div class="awards__card-footer">
			<div class="awards__card-info">
				<span class="awards__card-title"><?php echo esc_html( get_the_title( $award_id ) ); ?></span>
				<?php if ( $details ) : ?><span class="awards__card-details"><?php echo esc_html( $details ); ?></span><?php endif; ?>
			</div>
			<?php if ( $show_link && is_array( $link ) && ! empty( $link['url'] ) ) : ?>
				<a href="<?php echo esc_url( $link['url'] ); ?>" class="link--arrow awards__card-link"<?php echo ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $link['title'] ?: __( 'View ranking', 'velstadt' ) ); ?></a>
			<?php endif; ?>
		</div>
	</div>
	<?php
};
?>
<section class="section awards">
	<div class="section__header">
		<div class="container section__header-container section__lines">
			<div class="section__header-left">
				<h3 class="h3 section__subtitle"><?php echo esc_html( $subtitle ); ?></h3>
				<h2 class="h2 section__title"><?php echo esc_html( $title ); ?></h2>
			</div>
			<div class="section__header-right"><p><?php echo esc_html( $description ); ?></p></div>
		</div>
	</div>
	<div class="container awards__container section__lines">
		<div class="awards__main"><?php $render_award( $selected[0], true ); ?></div>
		<?php if ( count( $selected ) > 1 ) : ?>
			<div class="awards__grid">
				<?php foreach ( array_slice( $selected, 1 ) as $award_id ) : ?><?php $render_award( $award_id ); ?><?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php
/** Blog empty search/filter results. @package Velstadt */
$search = isset( $args['search'] ) ? (string) $args['search'] : '';
$reset_url = isset( $args['reset_url'] ) ? $args['reset_url'] : home_url( '/blog/' );
?>
<section class="blog__empty" aria-labelledby="blog-empty-title">
	<div class="blog__empty-content">
		<span class="blog__empty-icon"><img src="<?php echo esc_url( get_template_directory_uri() . '/markup/images/icons/blog-empty-search.svg' ); ?>" width="20" height="20" alt=""></span>
		<div class="blog__empty-text">
			<h1 id="blog-empty-title"><?php esc_html_e( 'No articles found', 'velstadt' ); ?></h1>
			<p><?php
			if ( '' !== $search ) {
				printf(
					/* translators: %s: search text, highlighted in bold. */
					esc_html__( 'No results for “%s”. Try a different search or reset your filters.', 'velstadt' ),
					'<strong>' . esc_html( $search ) . '</strong>'
				);
			} else {
				esc_html_e( 'Try a different search or reset your filters.', 'velstadt' );
			}
			?></p>
		</div>
	</div>
	<a class="btn" href="<?php echo esc_url( $reset_url ); ?>"><?php esc_html_e( 'Clear all filters', 'velstadt' ); ?></a>
</section>

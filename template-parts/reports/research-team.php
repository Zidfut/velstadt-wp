<?php
/**
 * Credits from the editorial author profiles selected for this report.
 *
 * @package Velstadt
 */

$author_ids = wp_parse_id_list( $args['author_ids'] ?? array() );
if ( ! $author_ids ) {
	return;
}

$authors = get_posts(
	array(
		'post_type'      => 'velstadt_author',
		'post_status'    => 'publish',
		'post__in'       => $author_ids,
		'orderby'        => 'post__in',
		'posts_per_page' => count( $author_ids ),
	)
);
if ( ! $authors ) {
	return;
}
?>
<section class="post__block report-research-team" aria-labelledby="report-research-team-title">
	<p><?php esc_html_e( 'Prepared by', 'velstadt' ); ?></p>
	<h2 id="report-research-team-title"><?php esc_html_e( 'Velstadt Research Team', 'velstadt' ); ?></h2>
	<ul class="report-research-people">
		<?php foreach ( $authors as $author ) : ?>
			<?php
			$name     = get_the_title( $author );
			$position = get_field( 'author_position', $author->ID );
			$avatar   = wp_get_attachment_image( (int) get_field( 'author_avatar', $author->ID ), 'thumbnail', false, array( 'class' => 'report-research-avatar', 'alt' => '' ) );
			?>
			<li class="report-research-person">
				<?php if ( $avatar ) : ?>
					<?php echo $avatar; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php else : ?>
					<span class="report-research-avatar author-initials" aria-hidden="true"><?php echo esc_html( velstadt_blog_author_initials( $name ) ); ?></span>
				<?php endif; ?>
				<div>
					<strong><?php echo esc_html( $name ); ?></strong>
					<?php if ( $position ) : ?><p><?php echo esc_html( $position ); ?></p><?php endif; ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</section>

<?php
/** Editorial author bio, shared by people and teams. @package Velstadt */
$author_id = (int) $args['author_id'];
if ( ! $author_id ) {
	return;
}
$name = get_the_title( $author_id );
$position = get_field( 'author_position', $author_id );
$bio = get_field( 'author_bio', $author_id );
$socials = (array) ( get_field( 'author_socials', $author_id ) ?: array() );
$platforms = array( 'linkedin' => 'LinkedIn', 'x' => 'X', 'instagram' => 'Instagram', 'facebook' => 'Facebook', 'website' => __( 'Website', 'velstadt' ) );
?>
<div class="author">
	<div class="author__header">
		<?php echo velstadt_blog_author_avatar( (int) $args['post_id'], 'author__img' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<div class="author__header-col">
			<h3 class="h3 author__name"><?php echo esc_html( $name ); ?></h3>
			<?php if ( $position ) : ?><span class="author__position"><?php echo esc_html( $position ); ?></span><?php endif; ?>
			<?php if ( $socials ) : ?>
				<ul class="author__socials">
					<?php foreach ( $socials as $social ) : if ( ! is_array( $social ) || empty( $social['url'] ) || empty( $social['platform'] ) || ! isset( $platforms[ $social['platform'] ] ) ) { continue; } ?>
						<li><a href="<?php echo esc_url( $social['url'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $platforms[ $social['platform'] ] ); ?>"<?php if ( empty( $social['icon'] ) ) : ?> class="author__social-text"<?php endif; ?>><?php if ( ! empty( $social['icon'] ) ) { echo wp_get_attachment_image( (int) $social['icon'], 'thumbnail', false, array( 'alt' => '' ) ); } else { echo esc_html( $platforms[ $social['platform'] ] ); } ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
	<?php if ( $bio ) : ?><div class="author__content"><?php echo wpautop( esc_html( $bio ) ); ?></div><?php endif; ?>
</div>

<?php
/** Ransomware catalog card. @package Velstadt */
$profile_id = (int) $args['post_id'];
$status = get_field( 'ransomware_decryptor_status', $profile_id );
$statuses = array( 'available' => __( 'Decryptor available', 'velstadt' ), 'unavailable' => __( 'No public decryptor', 'velstadt' ), 'not_reviewed' => __( 'Status not reviewed', 'velstadt' ) );
$status = isset( $statuses[ $status ] ) ? $status : 'not_reviewed';
$icons_url = get_template_directory_uri() . '/markup/images/ransomware/';
$tags = get_field( 'ransomware_tags', $profile_id ) ?: array();
?>
<article class="ransomware__card" data-profile-id="<?php echo esc_attr( $profile_id ); ?>">
	<div class="ransomware__card-top">
		<div class="ransomware__badge-wrap"><span class="ransomware__badge ransomware__badge--<?php echo esc_attr( $status ); ?>"><?php echo esc_html( $statuses[ $status ] ); ?><img src="<?php echo esc_url( $icons_url . str_replace( '_', '-', $status ) . '.svg' ); ?>" width="12" height="12" alt=""></span></div>
		<div class="ransomware__card-text">
			<h2><?php echo esc_html( get_the_title( $profile_id ) ); ?></h2>
			<p><?php echo esc_html( get_field( 'ransomware_card_description', $profile_id ) ); ?></p>
		</div>
		<?php if ( $tags ) : ?><ul class="ransomware__tags"><?php foreach ( $tags as $tag ) : ?><li><?php echo esc_html( $tag['text'] ); ?></li><?php endforeach; ?></ul><?php endif; ?>
	</div>
	<a class="ransomware__card-link link--arrow" href="<?php echo esc_url( get_permalink( $profile_id ) ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'View %s intelligence profile', 'velstadt' ), get_the_title( $profile_id ) ) ); ?>"><?php esc_html_e( 'View intelligence profile', 'velstadt' ); ?></a>
</article>

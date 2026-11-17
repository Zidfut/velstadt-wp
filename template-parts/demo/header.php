<?php
/** Minimal header for the demo landing page. @package Velstadt */
$logo_id = function_exists( 'get_field' ) ? (int) get_field( 'demo_logo' ) : 0;
?>
<header class="request-demo__header">
	<div class="container request-demo__header-container">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			<?php if ( $logo_id ) : ?>
				<?php echo wp_get_attachment_image( $logo_id, 'full', false, array( 'class' => 'request-demo__logo', 'loading' => 'eager' ) ); ?>
			<?php else : ?>
				<?php bloginfo( 'name' ); ?>
			<?php endif; ?>
		</a>
	</div>
</header>

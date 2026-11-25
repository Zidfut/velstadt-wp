<?php
/**
 * Template Name: Content Page
 * Template Post Type: page
 *
 * Generic template for legal and long-form content pages.
 *
 * @package Velstadt
 */

get_header();

while ( have_posts() ) :
	the_post();

	$page_id          = get_the_ID();
	$has_scf          = function_exists( 'get_field' );
	$eyebrow          = $has_scf ? get_field( 'content_page_eyebrow', $page_id ) : 'Legal';
	$description      = $has_scf ? get_field( 'content_page_description', $page_id ) : '';
	$show_updated     = $has_scf ? (bool) get_field( 'content_page_show_updated', $page_id ) : true;
	$updated_date     = $has_scf ? get_field( 'content_page_updated_date', $page_id ) : '';
	$updated_label    = $has_scf ? get_field( 'content_page_updated_label', $page_id ) : 'Last updated';
	$show_toc         = $has_scf ? (bool) get_field( 'content_page_show_toc', $page_id ) : true;
	$toc_title        = $has_scf ? get_field( 'content_page_toc_title', $page_id ) : __( 'On this page', 'velstadt' );
	$updated_date     = $updated_date ?: get_the_modified_date( 'F Y', $page_id );
	$updated_label    = $updated_label ?: 'Last updated';
	$toc_title        = $toc_title ?: __( 'On this page', 'velstadt' );
	$prepared_content = velstadt_prepare_content_page( apply_filters( 'the_content', get_the_content() ) );
	$toc              = $show_toc ? $prepared_content['toc'] : array();
	?>
	<main id="primary" class="page">
		<div id="top" class="header__duplicate header__duplicate--dark">
			<div class="container header__duplicate-container section__lines"></div>
		</div>

		<div class="section__header">
			<div class="container section__header-container section__lines">
				<div class="section__header-left">
					<?php if ( $eyebrow ) : ?><span class="h3 section__subtitle"><?php echo esc_html( $eyebrow ); ?></span><?php endif; ?>
					<h1 class="h2 section__title"><?php the_title(); ?></h1>
					<?php if ( $description ) : ?><p><?php echo esc_html( $description ); ?></p><?php endif; ?>
					<?php if ( $show_updated && $updated_date ) : ?>
						<div class="section__header-info">
							<span class="date"><?php echo esc_html( $updated_date ); ?></span>
							<span><?php echo esc_html( $updated_label ); ?></span>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="container page__container section__lines<?php echo $toc ? '' : ' page__container--wide'; ?>">
			<article class="page__content">
				<?php echo $prepared_content['content']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'velstadt' ),
						'after'  => '</div>',
					)
				);
				?>
			</article>

			<?php if ( $toc ) : ?>
				<aside class="page__sidebar">
					<?php get_template_part( 'template-parts/common/table-of-contents', null, array( 'toc' => $toc, 'title' => $toc_title ) ); ?>
				</aside>
			<?php endif; ?>
		</div>
	</main>
	<?php
endwhile;

get_footer();

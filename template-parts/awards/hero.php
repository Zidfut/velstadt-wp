<?php
/**
 * Awards page hero section.
 *
 * @package Velstadt
 */

$show_section = function_exists( 'get_field' ) ? get_field( 'awards_hero_show' ) : true;
if ( false === $show_section || 0 === $show_section || '0' === $show_section ) {
	return;
}

$subtitle    = function_exists( 'get_field' ) ? get_field( 'awards_hero_subtitle' ) : '';
$title       = function_exists( 'get_field' ) ? get_field( 'awards_hero_title' ) : '';
$description = function_exists( 'get_field' ) ? get_field( 'awards_hero_description' ) : '';

$subtitle    = $subtitle ?: 'Industry Recognition';
$title       = $title ?: 'Awards & Recognition';
$description = $description ?: 'Independent platforms recognize Velstadt for cybersecurity, cloud, and engineering expertise — reflecting technical quality, disciplined delivery, and client trust.';
?>
<section class="page">
        <div class="header__duplicate header__duplicate--dark">
            <div class="container header__duplicate-container section__lines"></div>
        </div>
        <div class="section__header">
            <div class="container section__header-container section__lines">
                <div class="section__header-left">
                    <?php if ( $subtitle ) : ?><h2 class="h3 section__subtitle"><?php echo esc_html( $subtitle ); ?></h2><?php endif; ?>
                    <?php if ( $title ) : ?><h1 class="h2 section__title"><?php echo esc_html( $title ); ?></h1><?php endif; ?>
                    <?php if ( $description ) : ?><p><?php echo esc_html( $description ); ?></p><?php endif; ?>
                </div>
            </div>
        </div>
    </section>

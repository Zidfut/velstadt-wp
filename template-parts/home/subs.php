<?php
/**
 * Home subscription section.
 *
 * @package Velstadt
 */

$has_scf  = function_exists( 'get_field' );
$show     = $has_scf ? (bool) get_field( 'home_subs_show' ) : true;
$title    = velstadt_get_home_field( 'home_subs_title', 'Velstadt Intelligence Brief' );
$subtitle = velstadt_get_home_field( 'home_subs_subtitle', 'Monthly threat research, practical recommendations, and executive insights.' );
$form     = velstadt_get_home_field( 'home_subs_form_shortcode', '' );

get_template_part(
	'template-parts/common/subscription',
	null,
	array(
		'show'     => $show,
		'title'    => $title,
		'subtitle' => $subtitle,
		'form'     => $form,
	)
);

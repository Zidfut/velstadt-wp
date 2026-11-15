<?php
/**
 * SCF fields and data helpers for the site footer.
 *
 * @package Velstadt
 */

/**
 * Build a link value accepted by the SCF Link field.
 *
 * @param string $title Link label.
 * @param string $url   Link URL.
 * @return array
 */
function velstadt_footer_default_link( $title, $url = '#' ) {
	return array(
		'title'  => $title,
		'url'    => $url,
		'target' => '',
	);
}

/**
 * Return the initial footer content copied from the static markup.
 *
 * @return array
 */
function velstadt_footer_default_content() {
	return array(
		'ai_links' => array(
			array(
				'link'       => velstadt_footer_default_link( 'Claude' ),
				'icon_asset' => 'icons/claude.svg',
			),
			array(
				'link'       => velstadt_footer_default_link( 'GPT' ),
				'icon_asset' => 'icons/gpt.svg',
			),
		),
		'menu_columns' => array(
			array(
				'heading_link' => velstadt_footer_default_link( 'Platform' ),
				'links'        => array(
					array( 'link' => velstadt_footer_default_link( 'Phantom' ) ),
					array( 'link' => velstadt_footer_default_link( 'Attack Surface' ) ),
					array( 'link' => velstadt_footer_default_link( 'Dark Web Monitoring' ) ),
					array( 'link' => velstadt_footer_default_link( 'Executive Reports' ) ),
				),
			),
			array(
				'heading_link' => velstadt_footer_default_link( 'Professional Services' ),
				'links'        => array(
					array( 'link' => velstadt_footer_default_link( 'Penetration Testing' ) ),
					array( 'link' => velstadt_footer_default_link( 'Security Assessments & Hardening' ) ),
					array( 'link' => velstadt_footer_default_link( 'Compliance & Risk Advisory' ) ),
					array( 'link' => velstadt_footer_default_link( 'Security Consulting & vCISO' ) ),
					array( 'link' => velstadt_footer_default_link( 'Threat Intelligence Services' ) ),
				),
			),
			array(
				'heading_link' => velstadt_footer_default_link( 'Managed Security' ),
				'links'        => array(
					array( 'link' => velstadt_footer_default_link( 'Managed Endpoint Security' ) ),
					array( 'link' => velstadt_footer_default_link( 'Managed SIEM' ) ),
					array( 'link' => velstadt_footer_default_link( 'Vulnerability Management' ) ),
					array( 'link' => velstadt_footer_default_link( 'Managed Threat Intelligence' ) ),
					array( 'link' => velstadt_footer_default_link( 'SOC & SOAR Services' ) ),
				),
			),
			array(
				'heading_link' => velstadt_footer_default_link( 'Why Velstadt' ),
				'links'        => array(
					array( 'link' => velstadt_footer_default_link( 'Why Choose Velstadt' ) ),
					array( 'link' => velstadt_footer_default_link( 'Customer Stories' ) ),
					array( 'link' => velstadt_footer_default_link( 'Awards and Recognition' ) ),
					array( 'link' => velstadt_footer_default_link( 'Certifications & Credentials' ) ),
					array( 'link' => velstadt_footer_default_link( 'Trust & Security' ) ),
				),
			),
			array(
				'heading_link' => velstadt_footer_default_link( 'Resources' ),
				'links'        => array(
					array( 'link' => velstadt_footer_default_link( 'Blog' ) ),
					array( 'link' => velstadt_footer_default_link( 'Reports' ) ),
					array( 'link' => velstadt_footer_default_link( 'Ransomware Encyclopedia' ) ),
					array( 'link' => velstadt_footer_default_link( 'Tools & Templates' ) ),
					array( 'link' => velstadt_footer_default_link( 'Learning Center' ) ),
				),
			),
			array(
				'heading_link' => velstadt_footer_default_link( 'Company' ),
				'links'        => array(
					array( 'link' => velstadt_footer_default_link( 'About Velstadt' ) ),
					array( 'link' => velstadt_footer_default_link( 'Partners' ) ),
					array( 'link' => velstadt_footer_default_link( 'Solutions' ) ),
					array( 'link' => velstadt_footer_default_link( 'Contacts' ) ),
				),
			),
		),
		'locations' => array(
			array(
				'title'        => 'USA',
				'address_link' => velstadt_footer_default_link( '230 Park Avenue, 3rd & 4th Floor New York, NY 10169 United States' ),
				'phone_link'   => velstadt_footer_default_link( '+1 585 888 5371', 'tel:+15858885371' ),
			),
			array(
				'title'        => 'Ukraine',
				'address_link' => velstadt_footer_default_link( '3 Dorohozhytska Street Kyiv, 01054 Ukraine' ),
				'phone_link'   => velstadt_footer_default_link( '+38 093 010 10 93', 'tel:+380930101093' ),
			),
			array(
				'title'        => 'Poland',
				'address_link' => velstadt_footer_default_link( 'Marszałkowska St., 126/134 00-008 Warsaw Poland' ),
				'phone_link'   => velstadt_footer_default_link( '+48 576 672 205', 'tel:+48576672205' ),
			),
		),
		'contact_links' => array(
			array(
				'link' => velstadt_footer_default_link( 'hello@velstadt.com', 'mailto:hello@velstadt.com' ),
				'icon' => 'email',
			),
		),
		'socials' => array(
			array( 'link' => velstadt_footer_default_link( 'Facebook' ), 'icon_asset' => 'icons/facebook.svg' ),
			array( 'link' => velstadt_footer_default_link( 'Medium' ), 'icon_asset' => 'icons/medium.svg' ),
			array( 'link' => velstadt_footer_default_link( 'LinkedIn' ), 'icon_asset' => 'icons/linkedin.svg' ),
			array( 'link' => velstadt_footer_default_link( 'X' ), 'icon_asset' => 'icons/twitter.svg' ),
		),
		'legal_links' => array(
			array( 'link' => velstadt_footer_default_link( 'Privacy Policy' ) ),
			array( 'link' => velstadt_footer_default_link( 'Terms & Conditions' ) ),
			array( 'link' => velstadt_footer_default_link( 'Cookie Policy' ) ),
		),
		'compliance_items' => array(
			array( 'label' => 'GDPR' ),
			array( 'label' => 'NIS2' ),
		),
	);
}

/**
 * Seed the footer settings once so the editable footer initially matches the markup.
 */
function velstadt_seed_footer_settings() {
	if ( get_option( 'velstadt_footer_settings_seeded' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$defaults = velstadt_footer_default_content();

	update_field( 'field_velstadt_footer_description', 'Protecting your digital life with modern cybersecurity solutions.', 'option' );
	update_field( 'field_velstadt_footer_show_badge', 1, 'option' );
	update_field( 'field_velstadt_footer_badge_alt', 'Supported by Google', 'option' );
	update_field( 'field_velstadt_footer_ai_label', 'Talk to us in', 'option' );
	update_field( 'field_velstadt_footer_ai_links', $defaults['ai_links'], 'option' );
	update_field( 'field_velstadt_footer_menu_columns', $defaults['menu_columns'], 'option' );
	update_field( 'field_velstadt_footer_locations', $defaults['locations'], 'option' );
	update_field( 'field_velstadt_footer_contact_title', 'Contacts', 'option' );
	update_field( 'field_velstadt_footer_contact_links', $defaults['contact_links'], 'option' );
	update_field( 'field_velstadt_footer_socials', $defaults['socials'], 'option' );
	update_field( 'field_velstadt_footer_copyright', '© {year} Velstadt LLC. All rights reserved.', 'option' );
	update_field( 'field_velstadt_footer_legal_links', $defaults['legal_links'], 'option' );
	update_field( 'field_velstadt_footer_compliance_label', 'Compliance', 'option' );
	update_field( 'field_velstadt_footer_compliance_items', $defaults['compliance_items'], 'option' );
	update_option( 'velstadt_footer_settings_seeded', 1, false );
}
add_action( 'acf/init', 'velstadt_seed_footer_settings', 20 );

/**
 * Get a footer option with a fallback value.
 *
 * @param string $name     SCF field name.
 * @param mixed  $fallback Fallback value.
 * @return mixed
 */
function velstadt_get_footer_option( $name, $fallback = null ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $fallback;
	}

	return get_field( $name, 'option' );
}

/**
 * Normalize an SCF Link field value.
 *
 * @param mixed  $link          Link field value.
 * @param string $fallback_text Fallback label.
 * @return array
 */
function velstadt_normalize_footer_link( $link, $fallback_text = '' ) {
	if ( is_string( $link ) ) {
		return array( 'url' => $link, 'title' => $fallback_text, 'target' => '' );
	}

	return array(
		'url'    => ! empty( $link['url'] ) ? $link['url'] : '#',
		'title'  => ! empty( $link['title'] ) ? $link['title'] : $fallback_text,
		'target' => ! empty( $link['target'] ) ? $link['target'] : '',
	);
}

/**
 * Return an image URL from an SCF image value or bundled asset name.
 *
 * @param mixed  $image SCF image value.
 * @param string $asset Relative bundled asset path.
 * @return string
 */
function velstadt_footer_image_url( $image, $asset = '' ) {
	if ( is_array( $image ) && ! empty( $image['url'] ) ) {
		return $image['url'];
	}

	if ( is_numeric( $image ) ) {
		$url = wp_get_attachment_image_url( (int) $image, 'full' );
		if ( $url ) {
			return $url;
		}
	}

	return $asset ? get_template_directory_uri() . '/markup/images/' . ltrim( $asset, '/' ) : '';
}

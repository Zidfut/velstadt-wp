<?php
/**
 * SCF fields and data helpers for the site header.
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
function velstadt_header_default_link( $title, $url = '#' ) {
	return array(
		'title'  => $title,
		'url'    => $url,
		'target' => '',
	);
}

/**
 * Build a menu link row.
 *
 * @param string $title       Link label.
 * @param string $description Optional description.
 * @return array
 */
function velstadt_header_default_menu_link( $title, $description = '' ) {
	return array(
		'link'        => velstadt_header_default_link( $title ),
		'description' => $description,
	);
}

/**
 * Return the initial header data copied from the static markup.
 *
 * @return array
 */
function velstadt_header_default_navigation() {
	return array(
		array(
			'label'         => 'Platform',
			'link'          => velstadt_header_default_link( 'Platform' ),
			'dropdown_type' => 'none',
			'feature_type'  => 'none',
			'panels'        => array(),
		),
		array(
			'label'          => 'Services',
			'link'           => velstadt_header_default_link( 'Services' ),
			'dropdown_type'  => 'standard',
			'feature_type'   => 'ranking',
			'feature_asset'  => 'award-badge.svg',
			'feature_eyebrow'=> 'Clutch',
			'feature_number' => '#7',
			'feature_title'  => 'Top Managed SIEM Services Company',
			'feature_meta'   => 'New York · 2025 · Top 1.2%',
			'feature_link'   => velstadt_header_default_link( 'View ranking' ),
			'panels'         => array(
				array(
					'tab_label' => '',
					'columns'   => array(
						array(
							'title' => 'Professional Services',
							'links' => array(
								velstadt_header_default_menu_link( 'Penetration Testing' ),
								velstadt_header_default_menu_link( 'Security Assessments & Hardening' ),
								velstadt_header_default_menu_link( 'Compliance & Risk Advisory' ),
								velstadt_header_default_menu_link( 'Security Consulting & vCISO' ),
								velstadt_header_default_menu_link( 'Threat Intelligence Services' ),
								velstadt_header_default_menu_link( 'Incident Response & Readiness' ),
								velstadt_header_default_menu_link( 'AI Security Assessments' ),
							),
						),
						array(
							'title' => 'Managed Security Services',
							'links' => array(
								velstadt_header_default_menu_link( 'Managed Endpoint Security' ),
								velstadt_header_default_menu_link( 'Managed SIEM' ),
								velstadt_header_default_menu_link( 'Managed Vulnerability Management' ),
								velstadt_header_default_menu_link( 'Managed Threat Intelligence' ),
								velstadt_header_default_menu_link( 'External Attack Surface Monitoring' ),
								velstadt_header_default_menu_link( 'Security Automation & SOAR Services' ),
								velstadt_header_default_menu_link( 'SOC as a Service / Co-managed SOC' ),
							),
						),
					),
				),
			),
		),
		array(
			'label'          => 'Solutions',
			'link'           => velstadt_header_default_link( 'Solutions' ),
			'dropdown_type'  => 'tabs',
			'feature_type'   => 'recognition',
			'feature_asset'  => 'awards/g2-high-performer-2026-badge.svg',
			'feature_title'  => 'High Performer',
			'feature_meta'   => 'G2 · 2026',
			'panels'         => array(
				array(
					'tab_label' => 'For Industries',
					'columns'   => array(
						array(
							'title' => 'Explore Velstadt',
							'links' => array(
								velstadt_header_default_menu_link( 'SaaS & Technology', 'Protect products, cloud infrastructure, and customer data.' ),
								velstadt_header_default_menu_link( 'Retail & E-commerce', 'Secure payments, identities, and customer journeys.' ),
								velstadt_header_default_menu_link( 'Financial Services & Fintech', 'Address fraud, regulation, and third-party risk.' ),
								velstadt_header_default_menu_link( 'Government & Public Sector', 'Strengthen public services, controls, and resilience.' ),
								velstadt_header_default_menu_link( 'Healthcare', 'Secure patient data, clinical systems, and suppliers.' ),
								velstadt_header_default_menu_link( 'Defense & Military Technology', 'Protect sensitive technology and mission-critical environments.' ),
								velstadt_header_default_menu_link( 'Transportation and Logistics', 'Protect distributed operations and digital supply chains.' ),
							),
						),
					),
				),
				array(
					'tab_label' => 'For Roles',
					'columns'   => array(
						array(
							'title' => 'Explore Velstadt',
							'links' => array(
								velstadt_header_default_menu_link( 'For CISOs & Security Leaders', 'Prioritize risk and build an executable security roadmap.' ),
								velstadt_header_default_menu_link( 'For CEOs & Business Owners', 'Understand material risk and investment priorities.' ),
								velstadt_header_default_menu_link( 'For CTOs & Engineering Leaders', 'Embed security without slowing product and cloud delivery.' ),
								velstadt_header_default_menu_link( 'For Compliance & Risk Teams', 'Connect requirements with controls and technical evidence.' ),
								velstadt_header_default_menu_link( 'For SOC & Threat Intelligence Teams', 'Turn external signals into investigations and response priorities.' ),
							),
						),
					),
				),
			),
		),
		array(
			'label'              => 'Why Velstadt',
			'link'               => velstadt_header_default_link( 'Why Velstadt' ),
			'dropdown_type'      => 'standard',
			'feature_type'       => 'customer',
			'feature_asset'      => 'partners/Nova-post.svg',
			'feature_quote'      => '“Velstadt helps us understand external risks earlier and respond faster.”',
			'feature_stat'       => '11,000+',
			'feature_stat_label' => 'Sources monitored 24/7',
			'feature_link'       => velstadt_header_default_link( 'Customer story' ),
			'panels'             => array(
				array(
					'tab_label' => '',
					'columns'   => array(
						array(
							'title' => 'Why Velstadt',
							'links' => array(
								velstadt_header_default_menu_link( 'Why Choose Velstadt', 'See what makes our security expertise, technology, and delivery approach different.' ),
								velstadt_header_default_menu_link( 'Customer Stories', 'Explore how organizations solve real security challenges with Velstadt.' ),
								velstadt_header_default_menu_link( 'Compare', 'Compare Velstadt with other cybersecurity solutions and delivery models.' ),
							),
						),
						array(
							'title' => 'Proof & Trust',
							'links' => array(
								velstadt_header_default_menu_link( 'Industry Expertise', 'Explore our experience across regulated and security-critical industries.' ),
								velstadt_header_default_menu_link( 'Awards & Recognition', 'View independent awards and rankings recognizing our expertise.' ),
								velstadt_header_default_menu_link( 'Certifications & Credentials', 'Review the professional and company credentials behind our work.' ),
								velstadt_header_default_menu_link( 'Trust & Security', 'Learn how Velstadt protects data, manages risk, and supports compliance.' ),
							),
						),
					),
				),
			),
		),
		array(
			'label'          => 'Resources',
			'link'           => velstadt_header_default_link( 'Resources' ),
			'dropdown_type'  => 'standard',
			'feature_type'   => 'ranking',
			'feature_asset'  => 'awards/clutch-top-dark-web-2025-badge.svg',
			'feature_eyebrow'=> 'Clutch',
			'feature_number' => '#2',
			'feature_title'  => 'Dark Web Monitoring',
			'feature_meta'   => 'New York · 2025 · Top 1.3%',
			'feature_link'   => velstadt_header_default_link( 'View ranking' ),
			'panels'         => array(
				array(
					'tab_label' => '',
					'columns'   => array(
						array(
							'title' => 'Resources',
							'links' => array(
								velstadt_header_default_menu_link( 'Blog', 'Insights and perspectives from Velstadt experts' ),
								velstadt_header_default_menu_link( 'Ransomware Encyclopedia', 'Profiles of ransomware groups, tactics, and business impact.' ),
								velstadt_header_default_menu_link( 'Tools & Templates', 'Practical resources for security planning and operations.' ),
								velstadt_header_default_menu_link( 'Reports', 'Research and guidance for security decisions' ),
								velstadt_header_default_menu_link( 'Case Studies', 'Real-world examples of security challenges and outcomes.' ),
								velstadt_header_default_menu_link( 'Cybersecurity Learning Center', 'Clear explanations of essential cybersecurity topics.' ),
							),
						),
					),
				),
			),
		),
		array(
			'label'         => 'Partners',
			'link'          => velstadt_header_default_link( 'Partners' ),
			'dropdown_type' => 'none',
			'feature_type'  => 'none',
			'panels'        => array(),
		),
	);
}

/**
 * Seed the SCF options once so the editable header initially matches the markup.
 */
function velstadt_seed_header_settings() {
	if ( get_option( 'velstadt_header_settings_seeded' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	update_field( 'field_velstadt_header_navigation', velstadt_header_default_navigation(), 'option' );
	update_field( 'field_velstadt_header_incident_link', velstadt_header_default_link( 'Active incident?' ), 'option' );
	update_field( 'field_velstadt_header_sign_in_link', velstadt_header_default_link( 'Sign in' ), 'option' );
	update_field( 'field_velstadt_header_demo_link', velstadt_header_default_link( 'Request a demo' ), 'option' );
	update_option( 'velstadt_header_settings_seeded', 1, false );
}
add_action( 'acf/init', 'velstadt_seed_header_settings', 20 );

/**
 * Get a header option with a fallback value.
 *
 * @param string $name     SCF field name.
 * @param mixed  $fallback Fallback value.
 * @return mixed
 */
function velstadt_get_header_option( $name, $fallback = null ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $fallback;
	}

	$value = get_field( $name, 'option' );

	return false === $value || null === $value ? $fallback : $value;
}

/**
 * Normalize an SCF link value for the header templates.
 *
 * @param mixed  $link          Link field value.
 * @param string $fallback_text Fallback label.
 * @return array
 */
function velstadt_normalize_header_link( $link, $fallback_text = '' ) {
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
 * Return the image URL from an SCF image value or bundled asset name.
 *
 * @param mixed  $image SCF image value.
 * @param string $asset Relative bundled asset path.
 * @return string
 */
function velstadt_header_image_url( $image, $asset = '' ) {
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

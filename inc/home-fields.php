<?php
/**
 * SCF fields and helpers for the front page.
 *
 * @package Velstadt
 */

/**
 * Seed the Hero fields for the selected front page once.
 */
function velstadt_seed_home_hero_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$front_page_id = (int) get_option( 'page_on_front' );
	if ( ! $front_page_id || get_option( 'velstadt_home_hero_seeded_' . $front_page_id ) ) {
		return;
	}

	update_field( 'field_velstadt_home_hero_show', 1, $front_page_id );
	update_field( 'field_velstadt_home_hero_subtitle', 'Threat intelligence built for action', $front_page_id );
	update_field( 'field_velstadt_home_hero_title', 'Threats become visible', $front_page_id );
	update_field( 'field_velstadt_home_hero_highlight', 'before the incident', $front_page_id );
	update_field( 'field_velstadt_home_hero_description', 'The Velstadt platform and experts help uncover critical risks before they become incidents', $front_page_id );
	update_field( 'field_velstadt_home_hero_expert_link', velstadt_header_default_link( 'Talk to an expert' ), $front_page_id );
	update_field( 'field_velstadt_home_hero_demo_link', velstadt_header_default_link( 'Request a demo' ), $front_page_id );
	update_option( 'velstadt_home_hero_seeded_' . $front_page_id, 1, false );
}
add_action( 'acf/init', 'velstadt_seed_home_hero_fields', 20 );

/**
 * Return the complete Partners list from the original markup.
 *
 * @return array<int,array<string,string>>
 */
function velstadt_home_default_partners() {
	return array(
		array( 'asset' => 'partners/Nova-post.svg', 'alt' => 'Nova Post' ),
		array( 'asset' => 'partners/Splunk.svg', 'alt' => 'Splunk' ),
		array( 'asset' => 'partners/Universal Bank.svg', 'alt' => 'Universal Bank' ),
		array( 'asset' => 'partners/Devlight.svg', 'alt' => 'Devlight' ),
		array( 'asset' => 'partners/Diia.svg', 'alt' => 'Diia' ),
		array( 'asset' => 'partners/Netcracker.svg', 'alt' => 'Netcracker' ),
		array( 'asset' => 'partners/UPG.svg', 'alt' => 'UPG' ),
		array( 'asset' => 'partners/IT-Ukraine-Association.svg', 'alt' => 'IT Ukraine Association' ),
		array( 'asset' => 'partners/ING.svg', 'alt' => 'ING' ),
		array( 'asset' => 'partners/Stfalcon.svg', 'alt' => 'Stfalcon' ),
		array( 'asset' => 'partners/NP-Shopping.svg', 'alt' => 'NP Shopping' ),
		array( 'asset' => 'partners/Snt.svg', 'alt' => 'SNT' ),
		array( 'asset' => 'partners/UGB.svg', 'alt' => 'UGB' ),
		array( 'asset' => 'partners/LemonOne.svg', 'alt' => 'LemonOne' ),
		array( 'asset' => 'partners/IITD.svg', 'alt' => 'IITD' ),
	);
}

/**
 * Import a bundled SVG into the WordPress Media Library once.
 *
 * @param string $asset         Relative asset path inside markup/images.
 * @param string $name          Attachment title and alt text.
 * @param int    $front_page_id Front page ID used as the attachment parent.
 * @param string $source_meta   Meta key used to identify the imported source.
 * @return int Attachment ID, or 0 when the import failed.
 */
function velstadt_import_home_media_asset( $asset, $name, $front_page_id, $source_meta ) {
	$existing = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => $source_meta,
			'meta_value'     => $asset,
		)
	);

	if ( $existing ) {
		return (int) $existing[0];
	}

	$source = get_template_directory() . '/markup/images/' . ltrim( $asset, '/' );
	if ( ! is_readable( $source ) ) {
		return 0;
	}

	$uploads = wp_upload_dir();
	if ( ! empty( $uploads['error'] ) || ! wp_mkdir_p( $uploads['path'] ) ) {
		return 0;
	}

	$filename = wp_unique_filename( $uploads['path'], sanitize_file_name( basename( $source ) ) );
	$target   = trailingslashit( $uploads['path'] ) . $filename;

	if ( ! copy( $source, $target ) ) {
		return 0;
	}

	$attachment_id = wp_insert_attachment(
		array(
			'guid'           => trailingslashit( $uploads['url'] ) . $filename,
			'post_mime_type' => 'image/svg+xml',
			'post_title'     => $name,
			'post_content'   => '',
			'post_status'    => 'inherit',
		),
		$target,
		$front_page_id,
		true
	);

	if ( is_wp_error( $attachment_id ) ) {
		wp_delete_file( $target );
		return 0;
	}

	update_post_meta( $attachment_id, '_wp_attachment_image_alt', $name );
	update_post_meta( $attachment_id, $source_meta, $asset );

	$svg = file_get_contents( $target );
	if (
		false !== $svg
		&& preg_match( '/\bwidth=["\']([\d.]+)["\']/i', $svg, $width )
		&& preg_match( '/\bheight=["\']([\d.]+)["\']/i', $svg, $height )
	) {
		wp_update_attachment_metadata(
			$attachment_id,
			array(
				'width'  => (int) round( (float) $width[1] ),
				'height' => (int) round( (float) $height[1] ),
				'file'   => _wp_relative_upload_path( $target ),
				'sizes'  => array(),
			)
		);
	}

	return (int) $attachment_id;
}

/**
 * Import a bundled partner logo while retaining the original migration key.
 *
 * @param string $asset         Relative asset path.
 * @param string $name          Partner name.
 * @param int    $front_page_id Front page ID.
 * @return int
 */
function velstadt_import_home_partner_logo( $asset, $name, $front_page_id ) {
	return velstadt_import_home_media_asset( $asset, $name, $front_page_id, '_velstadt_partner_source_asset' );
}

/**
 * Build editable SCF repeater rows backed by Media Library attachments.
 *
 * @param int $front_page_id Front page ID.
 * @return array<int,array<string,mixed>>
 */
function velstadt_home_default_partner_rows( $front_page_id ) {
	$rows = array();

	foreach ( velstadt_home_default_partners() as $partner ) {
		$logo_id = velstadt_import_home_partner_logo( $partner['asset'], $partner['alt'], $front_page_id );
		if ( ! $logo_id ) {
			continue;
		}

		$rows[] = array(
			'logo' => $logo_id,
			'alt'  => $partner['alt'],
		);
	}

	return $rows;
}

/**
 * Seed the Partners fields for the selected front page once.
 */
function velstadt_seed_home_partners_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$front_page_id = (int) get_option( 'page_on_front' );
	if ( ! $front_page_id || get_option( 'velstadt_home_partners_seeded_' . $front_page_id ) ) {
		return;
	}

	update_field( 'field_velstadt_home_partners_show', 1, $front_page_id );
	update_field( 'field_velstadt_home_partners_text', 'Chosen by teams that take security seriously', $front_page_id );
	update_field( 'field_velstadt_home_partners_link', velstadt_header_default_link( 'Explore client stories' ), $front_page_id );
	update_field( 'field_velstadt_home_partners_items', velstadt_home_default_partner_rows( $front_page_id ), $front_page_id );
	update_option( 'velstadt_home_partners_seeded_' . $front_page_id, 1, false );
}
add_action( 'acf/init', 'velstadt_seed_home_partners_fields', 20 );

/**
 * Migrate bundled partner paths to Media Library images.
 * Existing custom images and links are preserved.
 */
function velstadt_expand_home_partners_fields() {
	if ( ! function_exists( 'get_field' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$front_page_id = (int) get_option( 'page_on_front' );
	$migration_key = 'velstadt_home_partners_media_v2_' . $front_page_id;

	if ( ! $front_page_id || get_option( $migration_key ) ) {
		return;
	}

	$partners = get_field( 'home_partners_items', $front_page_id );
	$partners = is_array( $partners ) ? $partners : array();
	$changed  = false;
	$complete = true;
	$by_name  = array();

	foreach ( $partners as $index => $partner ) {
		if ( ! empty( $partner['alt'] ) ) {
			$by_name[ sanitize_title( $partner['alt'] ) ] = $index;
		}
	}

	foreach ( velstadt_home_default_partners() as $default_partner ) {
		$name_key = sanitize_title( $default_partner['alt'] );
		$logo_id  = velstadt_import_home_partner_logo( $default_partner['asset'], $default_partner['alt'], $front_page_id );

		if ( ! $logo_id ) {
			$complete = false;
			continue;
		}

		if ( isset( $by_name[ $name_key ] ) ) {
			$index = $by_name[ $name_key ];
			if ( empty( $partners[ $index ]['logo'] ) ) {
				$partners[ $index ]['logo'] = $logo_id;
				$changed                      = true;
			}
			continue;
		}

		$partners[]             = array( 'logo' => $logo_id, 'alt' => $default_partner['alt'] );
		$by_name[ $name_key ]   = count( $partners ) - 1;
		$changed                = true;
	}

	if ( $changed ) {
		update_field( 'field_velstadt_home_partners_items', array_values( $partners ), $front_page_id );
	}

	if ( $complete ) {
		update_option( $migration_key, 1, false );
	}
}
add_action( 'acf/init', 'velstadt_expand_home_partners_fields', 25 );

/**
 * Return the Security steps copied from the original markup.
 *
 * @return array<int,array<string,string>>
 */
function velstadt_home_default_security_steps() {
	return array(
		array( 'number' => '01', 'title' => 'Connected intelligence', 'description' => 'Signals become one prioritized view of risk' ),
		array( 'number' => '02', 'title' => 'Business context', 'description' => 'Threats mapped to your business context' ),
		array( 'number' => '03', 'title' => 'Analyst validation', 'description' => 'Critical findings reviewed by experts' ),
		array( 'number' => '04', 'title' => 'Confident action', 'description' => 'Intelligence turned into clear action' ),
	);
}

/**
 * Return the Security metric cards copied from the original markup.
 *
 * @return array<int,array<string,mixed>>
 */
function velstadt_home_default_security_cards() {
	return array(
		array(
			'style'        => '1',
			'label_class'  => 'primary',
			'label'        => 'Threat confidence',
			'value'        => '87%',
			'subtitle'     => 'Relevant threat activity',
			'footer_text'  => 'Sector and geography matched',
			'footer_items' => array(),
			'image_source' => '',
		),
		array(
			'style'        => '2',
			'label_class'  => 'blue',
			'label'        => 'Response ready',
			'value'        => '01',
			'subtitle'     => 'action assigned',
			'footer_text'  => '',
			'footer_items' => array(
				array( 'label' => 'Validated' ),
				array( 'label' => 'Assigned' ),
				array( 'label' => 'Resolved' ),
			),
			'image_source' => '',
		),
		array(
			'style'        => '3',
			'label_class'  => 'green',
			'label'        => 'Signal correlation',
			'value'        => '4',
			'subtitle'     => 'sources',
			'footer_text'  => 'One prioritized finding',
			'footer_items' => array(),
			'image_source' => 'chart.svg',
		),
		array(
			'style'        => '3',
			'label_class'  => 'purple',
			'label'        => 'Operational impact',
			'value'        => '~40%',
			'subtitle'     => 'Faster threat response',
			'footer_text'  => '',
			'footer_items' => array(),
			'image_source' => '',
		),
	);
}

/**
 * Build Security card rows backed only by Media Library images.
 *
 * @param int $front_page_id Front page ID.
 * @return array<int,array<string,mixed>>
 */
function velstadt_home_security_card_rows( $front_page_id ) {
	$rows = velstadt_home_default_security_cards();

	foreach ( $rows as &$row ) {
		$source = isset( $row['image_source'] ) ? $row['image_source'] : '';
		unset( $row['image_source'] );

		if ( $source ) {
			$row['image'] = velstadt_import_home_media_asset( $source, $row['label'], $front_page_id, '_velstadt_security_source_asset' );
		}
	}
	unset( $row );

	return $rows;
}

/**
 * Seed editable Security section data once.
 */
function velstadt_seed_home_security_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$front_page_id = (int) get_option( 'page_on_front' );
	if ( ! $front_page_id || get_option( 'velstadt_home_security_seeded_' . $front_page_id ) ) {
		return;
	}

	update_field( 'field_velstadt_home_security_show', 1, $front_page_id );
	update_field( 'field_velstadt_home_security_subtitle', 'A new security reality', $front_page_id );
	update_field( 'field_velstadt_home_security_title', 'Threats move faster.', $front_page_id );
	update_field( 'field_velstadt_home_security_title_highlight', 'Your intelligence should too', $front_page_id );
	update_field( 'field_velstadt_home_security_description', 'Velstadt connects threat signals to your business context and validates critical findings before they reach your team.', $front_page_id );
	update_field( 'field_velstadt_home_security_steps', velstadt_home_default_security_steps(), $front_page_id );
	update_field( 'field_velstadt_home_security_cards', velstadt_home_security_card_rows( $front_page_id ), $front_page_id );
	update_option( 'velstadt_home_security_seeded_' . $front_page_id, 1, false );
}
add_action( 'acf/init', 'velstadt_seed_home_security_fields', 30 );

/**
 * Migrate the existing Security chart fallback into the Media Library field.
 */
function velstadt_migrate_home_security_images() {
	if ( ! function_exists( 'get_field' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$front_page_id = (int) get_option( 'page_on_front' );
	$migration_key = 'velstadt_home_security_media_v2_' . $front_page_id;

	if ( ! $front_page_id || get_option( $migration_key ) ) {
		return;
	}

	$cards  = get_field( 'home_security_cards', $front_page_id );
	$cards  = is_array( $cards ) ? $cards : array();
	$chart  = velstadt_import_home_media_asset( 'chart.svg', 'Signal correlation', $front_page_id, '_velstadt_security_source_asset' );
	$edited = false;

	foreach ( $cards as &$card ) {
		if ( 'Signal correlation' === ( $card['label'] ?? '' ) && empty( $card['image'] ) && $chart ) {
			$card['image'] = $chart;
			$edited        = true;
		}
	}
	unset( $card );

	if ( $edited ) {
		update_field( 'field_velstadt_home_security_cards', array_values( $cards ), $front_page_id );
	}

	if ( $chart ) {
		update_option( $migration_key, 1, false );
	}
}
add_action( 'acf/init', 'velstadt_migrate_home_security_images', 32 );

/**
 * Return the About cards copied from the original markup.
 *
 * @return array<int,array<string,string>>
 */
function velstadt_home_default_about_cards() {
	return array(
		array(
			'icon_source' => 'icons/dataflow.svg',
			'title'       => 'Intelligence with context',
			'description' => 'We turn signals from multiple sources into clear priorities for security teams.',
		),
		array(
			'icon_source' => 'icons/users-check.svg',
			'title'       => 'Technology and human expertise',
			'description' => 'Automation accelerates analysis, while experts validate the context and severity of threats.',
		),
		array(
			'icon_source' => 'icons/target.svg',
			'title'       => 'Focus on business risk',
			'description' => 'We explain not only the technical issue, but also its potential impact on operations and reputation.',
		),
		array(
			'icon_source' => 'icons/shield-tick.svg',
			'title'       => 'End-to-end protection',
			'description' => 'From risk assessments and audit readiness to threat detection and response.',
		),
	);
}

/**
 * Build About card rows backed only by Media Library icons.
 *
 * @param int $front_page_id Front page ID.
 * @return array<int,array<string,mixed>>
 */
function velstadt_home_about_card_rows( $front_page_id ) {
	$rows = velstadt_home_default_about_cards();

	foreach ( $rows as &$row ) {
		$source = $row['icon_source'];
		unset( $row['icon_source'] );
		$row['icon'] = velstadt_import_home_media_asset( $source, $row['title'], $front_page_id, '_velstadt_about_source_asset' );
	}
	unset( $row );

	return $rows;
}

/**
 * Seed editable About section data once.
 */
function velstadt_seed_home_about_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$front_page_id = (int) get_option( 'page_on_front' );
	if ( ! $front_page_id || get_option( 'velstadt_home_about_seeded_' . $front_page_id ) ) {
		return;
	}

	update_field( 'field_velstadt_home_about_show', 1, $front_page_id );
	update_field( 'field_velstadt_home_about_subtitle', 'Why Velstadt', $front_page_id );
	update_field( 'field_velstadt_home_about_title', 'Intelligence that drives better decisions', $front_page_id );
	update_field( 'field_velstadt_home_about_description', 'Technical depth for security teams. Business clarity for leadership. One trusted partner at every stage.', $front_page_id );
	update_field( 'field_velstadt_home_about_cards', velstadt_home_about_card_rows( $front_page_id ), $front_page_id );
	update_option( 'velstadt_home_about_seeded_' . $front_page_id, 1, false );
}
add_action( 'acf/init', 'velstadt_seed_home_about_fields', 31 );

/**
 * Migrate existing About icon fallbacks into Media Library fields.
 */
function velstadt_migrate_home_about_icons() {
	if ( ! function_exists( 'get_field' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$front_page_id = (int) get_option( 'page_on_front' );
	$migration_key = 'velstadt_home_about_media_v2_' . $front_page_id;

	if ( ! $front_page_id || get_option( $migration_key ) ) {
		return;
	}

	$cards    = get_field( 'home_about_cards', $front_page_id );
	$cards    = is_array( $cards ) ? $cards : array();
	$defaults = velstadt_home_default_about_cards();
	$complete = true;
	$edited   = false;

	foreach ( $cards as &$card ) {
		foreach ( $defaults as $default ) {
			if ( ( $card['title'] ?? '' ) !== $default['title'] || ! empty( $card['icon'] ) ) {
				continue;
			}

			$icon_id = velstadt_import_home_media_asset( $default['icon_source'], $default['title'], $front_page_id, '_velstadt_about_source_asset' );
			if ( $icon_id ) {
				$card['icon'] = $icon_id;
				$edited       = true;
			} else {
				$complete = false;
			}
			break;
		}
	}
	unset( $card );

	if ( $edited ) {
		update_field( 'field_velstadt_home_about_cards', array_values( $cards ), $front_page_id );
	}

	if ( $complete ) {
		update_option( $migration_key, 1, false );
	}
}
add_action( 'acf/init', 'velstadt_migrate_home_about_icons', 33 );

/**
 * Return the Services items copied from the original markup.
 *
 * @return array<int,array<string,mixed>>
 */
function velstadt_home_default_services() {
	$shared_bullets = array(
		array( 'label' => 'Security strategy' ),
		array( 'label' => 'Virtual CISO' ),
		array( 'label' => 'Threat modeling' ),
	);

	return array(
		array(
			'number'       => '01',
			'title'        => 'Penetration Testing',
			'description'  => 'Real-world attack simulations to uncover vulnerabilities before attackers do',
			'bullets'      => array(
				array( 'label' => 'Real attacker techniques' ),
				array( 'label' => 'Exploit-path mapping' ),
				array( 'label' => 'Prioritized remediation' ),
			),
			'link'         => velstadt_header_default_link( 'Learn more' ),
			'image_source' => 'accardion1.svg',
		),
		array(
			'number'       => '02',
			'title'        => 'Compliance Services',
			'description'  => 'Prioritize investment according to real risk.',
			'bullets'      => $shared_bullets,
			'link'         => velstadt_header_default_link( 'Learn more' ),
			'image_source' => 'accardion1.svg',
		),
		array(
			'number'       => '03',
			'title'        => 'Security Consulting',
			'description'  => 'Prioritize investment according to real risk.',
			'bullets'      => $shared_bullets,
			'link'         => velstadt_header_default_link( 'Learn more' ),
			'image_source' => 'accardion1.svg',
		),
		array(
			'number'       => '04',
			'title'        => 'Infrastructure Hardening',
			'description'  => 'Prioritize investment according to real risk.',
			'bullets'      => $shared_bullets,
			'link'         => velstadt_header_default_link( 'Learn more' ),
			'image_source' => 'accardion1.svg',
		),
		array(
			'number'       => '05',
			'title'        => 'Threat Intelligence',
			'description'  => 'Prioritize investment according to real risk.',
			'bullets'      => $shared_bullets,
			'link'         => velstadt_header_default_link( 'Learn more' ),
			'image_source' => 'accardion1.svg',
		),
	);
}

/**
 * Build Services rows backed only by Media Library images.
 *
 * @param int $front_page_id Front page ID.
 * @return array<int,array<string,mixed>>
 */
function velstadt_home_services_rows( $front_page_id ) {
	$rows = velstadt_home_default_services();

	foreach ( $rows as &$row ) {
		$source = $row['image_source'];
		unset( $row['image_source'] );
		$row['image'] = velstadt_import_home_media_asset( $source, $row['title'], $front_page_id, '_velstadt_services_source_asset' );
	}
	unset( $row );

	return $rows;
}

/**
 * Seed editable Services section data once.
 */
function velstadt_seed_home_services_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$front_page_id = (int) get_option( 'page_on_front' );
	if ( ! $front_page_id || get_option( 'velstadt_home_services_seeded_' . $front_page_id ) ) {
		return;
	}

	update_field( 'field_velstadt_home_services_show', 1, $front_page_id );
	update_field( 'field_velstadt_home_services_subtitle', 'Services', $front_page_id );
	update_field( 'field_velstadt_home_services_title', 'Security built around your risks', $front_page_id );
	update_field( 'field_velstadt_home_services_description', 'Every engagement is focused on measurable outcomes: reduced risk, audit readiness, protected business continuity, or a stronger security model.', $front_page_id );
	update_field( 'field_velstadt_home_services_items', velstadt_home_services_rows( $front_page_id ), $front_page_id );
	update_option( 'velstadt_home_services_seeded_' . $front_page_id, 1, false );
}
add_action( 'acf/init', 'velstadt_seed_home_services_fields', 34 );

/**
 * Return the Phantom tabs copied from the original markup.
 *
 * @return array<int,array<string,mixed>>
 */
function velstadt_home_default_phantom_items() {
	$demo_link   = velstadt_header_default_link( 'Request a demo' );
	$expert_link = velstadt_header_default_link( 'Talk to an expert' );

	return array(
		array(
			'title' => 'External Attack Surface',
			'description' => 'See exposed assets, impersonating domains, and external risks before attackers can use them.',
			'bullets' => array( array( 'label' => 'Internet-facing exposure' ), array( 'label' => 'Risk-based prioritization' ), array( 'label' => 'Evidence and recommended actions' ) ),
			'demo_link' => $demo_link, 'expert_link' => $expert_link, 'image' => 0,
		),
		array(
			'title' => 'Dark Web Monitoring',
			'description' => 'Monitor hidden sources, criminal communities, and marketplaces for activity linked to your organization.',
			'bullets' => array( array( 'label' => 'Brand and executive mentions' ), array( 'label' => 'Initial-access activity' ), array( 'label' => 'Analyst-validated alerts' ) ),
			'demo_link' => $demo_link, 'expert_link' => $expert_link, 'image' => 0,
		),
		array(
			'title' => 'Data and Credential Exposure',
			'description' => 'Detect exposed credentials and sensitive data across stealer logs, leaked datasets, and underground sources.',
			'bullets' => array( array( 'label' => 'Credential leak detection' ), array( 'label' => 'Stealer log visibility' ), array( 'label' => 'Validation and remediation' ) ),
			'demo_link' => $demo_link, 'expert_link' => $expert_link, 'image' => 0,
		),
		array(
			'title' => 'Adversary Monitoring',
			'description' => 'Track actors, campaigns, and vulnerabilities relevant to your sector, geography, and technology stack.',
			'bullets' => array( array( 'label' => 'Actor and campaign profiles' ), array( 'label' => 'IoC and CVE context' ), array( 'label' => 'Sector-specific intelligence' ) ),
			'demo_link' => $demo_link, 'expert_link' => $expert_link, 'image' => 0,
		),
		array(
			'title' => 'Ransomware Intelligence',
			'description' => 'Turn ransomware and data-extortion activity into earlier warning, stronger threat hunting, and faster response.',
			'bullets' => array( array( 'label' => 'Group and victim monitoring' ), array( 'label' => 'Sector and regional trends' ), array( 'label' => 'Actionable early warnings' ) ),
			'demo_link' => $demo_link, 'expert_link' => $expert_link, 'image' => 0,
		),
		array(
			'title' => 'Executive Reports',
			'description' => 'Translate complex threat data into clear business impact, priorities, and next actions for leadership.',
			'bullets' => array( array( 'label' => 'Executive risk summaries' ), array( 'label' => 'Exposure and threat trends' ), array( 'label' => 'Decision-ready recommendations' ) ),
			'demo_link' => $demo_link, 'expert_link' => $expert_link, 'image' => 0,
		),
	);
}

/** Seed editable Phantom section data once. */
function velstadt_seed_home_phantom_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$front_page_id = (int) get_option( 'page_on_front' );
	if ( ! $front_page_id || get_option( 'velstadt_home_phantom_seeded_' . $front_page_id ) ) {
		return;
	}

	update_field( 'field_velstadt_home_phantom_show', 1, $front_page_id );
	update_field( 'field_velstadt_home_phantom_subtitle', 'Phantom by Velstadt', $front_page_id );
	update_field( 'field_velstadt_home_phantom_title', 'One view of external threats', $front_page_id );
	update_field( 'field_velstadt_home_phantom_description', 'The platform collects, enriches, and prioritizes data so your team sees the risks that truly matter.', $front_page_id );
	update_field( 'field_velstadt_home_phantom_items', velstadt_home_default_phantom_items(), $front_page_id );
	update_option( 'velstadt_home_phantom_seeded_' . $front_page_id, 1, false );
}
add_action( 'acf/init', 'velstadt_seed_home_phantom_fields', 35 );

/**
 * Return the Advantages statistic cards copied from the original markup.
 *
 * @return array<int,array<string,string>>
 */
function velstadt_home_default_advantages_cards() {
	return array(
		array(
			'value'       => '100+',
			'title'       => 'Customers protected',
			'description' => 'Comprehensive security for organizations of any scale.',
		),
		array(
			'value'       => '20',
			'title'       => 'Countries covered',
			'description' => 'Operations across regions and threat surfaces.',
		),
		array(
			'value'       => '50 TB+',
			'title'       => 'Daily log monitoring',
			'description' => 'High data volumes for more accurate detection.',
		),
		array(
			'value'       => '10 000+',
			'title'       => 'Communities monitored',
			'description' => 'Early signal detection across closed communities.',
		),
	);
}

/**
 * Seed editable Advantages section data once.
 */
function velstadt_seed_home_advantages_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$front_page_id = (int) get_option( 'page_on_front' );
	if ( ! $front_page_id || get_option( 'velstadt_home_advantages_seeded_' . $front_page_id ) ) {
		return;
	}

	update_field( 'field_velstadt_home_advantages_show', 1, $front_page_id );
	update_field( 'field_velstadt_home_advantages_subtitle', 'Velstadt in numbers', $front_page_id );
	update_field( 'field_velstadt_home_advantages_title', 'Security at scale. Proven in practice', $front_page_id );
	update_field( 'field_velstadt_home_advantages_description', 'A snapshot of the coverage, data volume, and intelligence behind our operations.', $front_page_id );
	update_field( 'field_velstadt_home_advantages_feature_value', '~40%', $front_page_id );
	update_field( 'field_velstadt_home_advantages_feature_title', 'Faster threat response', $front_page_id );
	update_field( 'field_velstadt_home_advantages_feature_description', 'Reduced response time through mature workflows, analysts, and automation.', $front_page_id );
	update_field( 'field_velstadt_home_advantages_cards', velstadt_home_default_advantages_cards(), $front_page_id );
	update_option( 'velstadt_home_advantages_seeded_' . $front_page_id, 1, false );
}
add_action( 'acf/init', 'velstadt_seed_home_advantages_fields', 36 );

/**
 * Return the Expertise credentials copied from the original markup.
 *
 * @return array<int,array<string,mixed>>
 */
function velstadt_home_default_expertise_items() {
	return array(
		array(
			'title'       => 'OSCP',
			'description' => 'Offensive Security',
			'link'        => velstadt_header_default_link( 'OSCP' ),
		),
		array(
			'title'       => 'OSWE',
			'description' => 'Web exploitation',
			'link'        => velstadt_header_default_link( 'OSWE' ),
		),
		array(
			'title'       => 'OSCE',
			'description' => 'Advanced offensive security',
			'link'        => velstadt_header_default_link( 'OSCE' ),
		),
		array(
			'title'       => 'CREST',
			'description' => 'Penetration testing',
			'link'        => velstadt_header_default_link( 'CREST' ),
		),
	);
}

/**
 * Seed editable Expertise section data once.
 */
function velstadt_seed_home_expertise_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$front_page_id = (int) get_option( 'page_on_front' );
	if ( ! $front_page_id || get_option( 'velstadt_home_expertise_seeded_' . $front_page_id ) ) {
		return;
	}

	update_field( 'field_velstadt_home_expertise_show', 1, $front_page_id );
	update_field( 'field_velstadt_home_expertise_subtitle', 'Team expertise', $front_page_id );
	update_field( 'field_velstadt_home_expertise_title', 'Hands-on credentials', $front_page_id );
	update_field( 'field_velstadt_home_expertise_items', velstadt_home_default_expertise_items(), $front_page_id );
	update_option( 'velstadt_home_expertise_seeded_' . $front_page_id, 1, false );
}
add_action( 'acf/init', 'velstadt_seed_home_expertise_fields', 37 );

/**
 * Return the Customer stories copied from the original markup.
 *
 * @return array<int,array<string,mixed>>
 */
function velstadt_home_default_customer_items() {
	return array(
		array(
			'quote'       => '“Velstadt helps us understand external risks earlier and respond faster.”',
			'stat'        => '11,000+',
			'stat_label'  => 'Sources monitored 24/7',
			'logo_source' => 'partners/Nova-post.svg',
			'logo_name'   => 'Nova Post',
			'link'        => velstadt_header_default_link( 'Nova Post customer story' ),
		),
		array(
			'quote'       => '“Security is not just a technical requirement, but part of the trust we build between brands and their users.”',
			'stat'        => '2 reports',
			'stat_label'  => 'Technical and executive',
			'logo_source' => 'partners/Devlight.svg',
			'logo_name'   => 'Devlight',
			'link'        => velstadt_header_default_link( 'Devlight customer story' ),
		),
		array(
			'quote'       => '“Velstadt helped our team identify critical risks earlier and turn complex findings into clear remediation priorities.”',
			'stat'        => '40% faster',
			'stat_label'  => 'Critical risk remediation',
			'logo_source' => 'partners/Stfalcon.svg',
			'logo_name'   => 'Stfalcon',
			'link'        => velstadt_header_default_link( 'Stfalcon customer story' ),
		),
	);
}

/**
 * Build Customer story rows backed only by Media Library logos.
 *
 * @param int $front_page_id Front page ID.
 * @return array<int,array<string,mixed>>
 */
function velstadt_home_customer_rows( $front_page_id ) {
	$rows = velstadt_home_default_customer_items();

	foreach ( $rows as &$row ) {
		$source = $row['logo_source'];
		$name   = $row['logo_name'];
		unset( $row['logo_source'], $row['logo_name'] );
		$row['logo'] = velstadt_import_home_partner_logo( $source, $name, $front_page_id );
	}
	unset( $row );

	return $rows;
}

/**
 * Seed editable Customer stories section data once.
 */
function velstadt_seed_home_customer_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$front_page_id = (int) get_option( 'page_on_front' );
	if ( ! $front_page_id || get_option( 'velstadt_home_customer_seeded_' . $front_page_id ) ) {
		return;
	}

	update_field( 'field_velstadt_home_customer_show', 1, $front_page_id );
	update_field( 'field_velstadt_home_customer_subtitle', 'Customer Stories', $front_page_id );
	update_field( 'field_velstadt_home_customer_title', 'From signal to measurable impact', $front_page_id );
	update_field( 'field_velstadt_home_customer_archive_link', velstadt_header_default_link( 'View customer stories' ), $front_page_id );
	update_field( 'field_velstadt_home_customer_items', velstadt_home_customer_rows( $front_page_id ), $front_page_id );
	update_option( 'velstadt_home_customer_seeded_' . $front_page_id, 1, false );
}
add_action( 'acf/init', 'velstadt_seed_home_customer_fields', 38 );

/**
 * Return the Resources cards copied from the original markup.
 *
 * These rows can later be replaced by a Resource custom post type without
 * changing the section markup.
 *
 * @return array<int,array<string,mixed>>
 */
function velstadt_home_default_resources_items() {
	return array(
		array(
			'badge'        => 'Threat Research',
			'image_source' => 'book-cover-alt.svg',
			'title'        => 'APT Threat Assessment',
			'description'  => 'Assessment of active groups’ tactics, infrastructure, and objectives.',
			'author'       => 'Velstadt Research',
			'date'         => 'September 30, 2026',
			'link'         => velstadt_header_default_link( 'APT Threat Assessment' ),
		),
		array(
			'badge'        => 'Threat Research',
			'image_source' => 'book-cover-alt-2.svg',
			'title'        => 'Ransomware Threat Landscape',
			'description'  => 'Key changes in the ransomware ecosystem and their business impact.',
			'author'       => 'Velstadt Research',
			'date'         => 'September 30, 2026',
			'link'         => velstadt_header_default_link( 'Ransomware Threat Landscape' ),
		),
		array(
			'badge'        => 'Threat Research',
			'image_source' => 'book-cover-alt-3.svg',
			'title'        => 'Compliance Checklist',
			'description'  => 'A practical readiness checklist for security control assessments.',
			'author'       => 'Velstadt Research',
			'date'         => 'September 30, 2026',
			'link'         => velstadt_header_default_link( 'Compliance Checklist' ),
		),
	);
}

/**
 * Build Resources rows backed only by Media Library images.
 *
 * @param int $front_page_id Front page ID.
 * @return array<int,array<string,mixed>>
 */
function velstadt_home_resources_rows( $front_page_id ) {
	$rows = velstadt_home_default_resources_items();

	foreach ( $rows as &$row ) {
		$source = $row['image_source'];
		unset( $row['image_source'] );
		$row['image'] = velstadt_import_home_media_asset( $source, $row['title'], $front_page_id, '_velstadt_resources_source_asset' );
	}
	unset( $row );

	return $rows;
}

/**
 * Seed editable Resources section data once.
 */
function velstadt_seed_home_resources_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$front_page_id = (int) get_option( 'page_on_front' );
	if ( ! $front_page_id || get_option( 'velstadt_home_resources_seeded_' . $front_page_id ) ) {
		return;
	}

	update_field( 'field_velstadt_home_resources_show', 1, $front_page_id );
	update_field( 'field_velstadt_home_resources_subtitle', 'Reports and Research', $front_page_id );
	update_field( 'field_velstadt_home_resources_title', 'Intelligence for your next decision', $front_page_id );
	update_field( 'field_velstadt_home_resources_description', 'Proprietary intelligence for security leaders, technical teams, and executives—based on what Velstadt observes in real-world operations.', $front_page_id );
	update_field( 'field_velstadt_home_resources_items', velstadt_home_resources_rows( $front_page_id ), $front_page_id );
	update_option( 'velstadt_home_resources_seeded_' . $front_page_id, 1, false );
}
add_action( 'acf/init', 'velstadt_seed_home_resources_fields', 39 );

/**
 * Seed editable Blog section settings once.
 *
 * Post cards are populated automatically from the five latest posts.
 */
function velstadt_seed_home_blog_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$front_page_id = (int) get_option( 'page_on_front' );
	if ( ! $front_page_id || get_option( 'velstadt_home_blog_seeded_' . $front_page_id ) ) {
		return;
	}

	$blog_page_id = (int) get_option( 'page_for_posts' );
	$blog_url     = $blog_page_id ? get_permalink( $blog_page_id ) : home_url( '/blog/' );

	update_field( 'field_velstadt_home_blog_show', 1, $front_page_id );
	update_field( 'field_velstadt_home_blog_subtitle', 'Blog and Insights', $front_page_id );
	update_field( 'field_velstadt_home_blog_title', 'Practical insight into cyber threats', $front_page_id );
	update_field( 'field_velstadt_home_blog_archive_link', velstadt_header_default_link( 'All posts', $blog_url ), $front_page_id );
	update_option( 'velstadt_home_blog_seeded_' . $front_page_id, 1, false );
}
add_action( 'acf/init', 'velstadt_seed_home_blog_fields', 40 );

/**
 * Seed editable Subscribe section settings once.
 *
 * The actual form is managed by Contact Form 7 and selected with a shortcode.
 */
function velstadt_seed_home_subs_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$front_page_id = (int) get_option( 'page_on_front' );
	if ( ! $front_page_id || get_option( 'velstadt_home_subs_seeded_' . $front_page_id ) ) {
		return;
	}

	update_field( 'field_velstadt_home_subs_show', 1, $front_page_id );
	update_field( 'field_velstadt_home_subs_title', 'Velstadt Intelligence Brief', $front_page_id );
	update_field( 'field_velstadt_home_subs_subtitle', 'Monthly threat research, practical recommendations, and executive insights.', $front_page_id );
	update_option( 'velstadt_home_subs_seeded_' . $front_page_id, 1, false );
}
add_action( 'acf/init', 'velstadt_seed_home_subs_fields', 41 );

/**
 * Seed editable CTA section data once.
 */
function velstadt_seed_home_cta_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$front_page_id = (int) get_option( 'page_on_front' );
	if ( ! $front_page_id || get_option( 'velstadt_home_cta_seeded_' . $front_page_id ) ) {
		return;
	}

	update_field( 'field_velstadt_home_cta_show', 1, $front_page_id );
	update_field( 'field_velstadt_home_cta_eyebrow', 'Next step', $front_page_id );
	update_field( 'field_velstadt_home_cta_title', 'See the threats that matter to your organization', $front_page_id );
	update_field( 'field_velstadt_home_cta_subtitle', 'Get a platform demo or discuss current risks with a Velstadt expert.', $front_page_id );
	update_field( 'field_velstadt_home_cta_demo_link', velstadt_header_default_link( 'Request a demo' ), $front_page_id );
	update_field( 'field_velstadt_home_cta_expert_link', velstadt_header_default_link( 'Talk to an expert' ), $front_page_id );
	update_option( 'velstadt_home_cta_seeded_' . $front_page_id, 1, false );
}
add_action( 'acf/init', 'velstadt_seed_home_cta_fields', 42 );

/**
 * Get a front page field with a fallback when SCF is unavailable.
 *
 * @param string $name     Field name.
 * @param mixed  $fallback Fallback value.
 * @return mixed
 */
function velstadt_get_home_field( $name, $fallback = null ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $fallback;
	}

	return get_field( $name );
}

<?php
/**
 * SCF fields and initial values for the Services page.
 *
 * @package Velstadt
 */

/**
 * Get a Services page field.
 *
 * @param string $name     Field name.
 * @param mixed  $fallback Fallback used when SCF is unavailable.
 * @param int    $page_id  Services page ID.
 * @return mixed
 */
function velstadt_get_services_field( $name, $fallback, $page_id ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $fallback;
	}

	return get_field( $name, $page_id );
}

/**
 * Seed the Services Hero fields once.
 */
function velstadt_seed_services_hero_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = get_page_by_path( 'services', OBJECT, 'page' );
	if ( ! $page || get_option( 'velstadt_services_hero_seeded_' . $page->ID ) ) {
		return;
	}

	$image_id = velstadt_import_home_media_asset(
		'services.svg',
		'Offensive security services',
		(int) $page->ID,
		'_velstadt_services_page_source_asset'
	);

	update_field( 'field_velstadt_services_hero_show', 1, $page->ID );
	update_field( 'field_velstadt_services_hero_eyebrow', 'Offensive security services', $page->ID );
	update_field( 'field_velstadt_services_hero_title', 'Find the paths attackers would take-before they do', $page->ID );
	update_field( 'field_velstadt_services_hero_description', 'Expert-led penetration testing combines real-world attack techniques, threat intelligence, and manual validation to expose exploitable risk and give your team a clear remediation path.', $page->ID );
	update_field( 'field_velstadt_services_hero_expert_link', velstadt_header_default_link( 'Talk to an expert' ), $page->ID );
	update_field( 'field_velstadt_services_hero_demo_link', velstadt_header_default_link( 'Request a demo' ), $page->ID );
	if ( $image_id ) {
		update_field( 'field_velstadt_services_hero_image', $image_id, $page->ID );
		update_option( 'velstadt_services_hero_seeded_' . $page->ID, 1, false );
	}
}
add_action( 'acf/init', 'velstadt_seed_services_hero_fields', 20 );

/**
 * Return the About cards copied from the Services markup.
 *
 * @return array<int,array<string,string>>
 */
function velstadt_services_default_about_cards() {
	return array(
		array( 'icon_source' => 'icons/dataflow.svg', 'title' => 'See real attack paths', 'description' => 'See how weaknesses combine to expose systems, identities, and data' ),
		array( 'icon_source' => 'icons/users-check.svg', 'title' => 'Prioritize by impact', 'description' => 'Focus resources on findings that create the greatest business risk' ),
		array( 'icon_source' => 'icons/target.svg', 'title' => 'Prove the fix', 'description' => 'Retest critical findings and verify the fixes.' ),
		array( 'icon_source' => 'icons/shield-tick.svg', 'title' => 'Move from findings to action', 'description' => 'Turn validated evidence into a clear remediation plan' ),
	);
}

/**
 * Build Services About rows backed only by Media Library icons.
 *
 * @param int $page_id Services page ID.
 * @return array<int,array<string,mixed>>
 */
function velstadt_services_about_rows( $page_id ) {
	$rows = velstadt_services_default_about_cards();

	foreach ( $rows as &$row ) {
		$source = $row['icon_source'];
		unset( $row['icon_source'] );
		$row['icon'] = velstadt_import_home_media_asset( $source, $row['title'], $page_id, '_velstadt_services_about_source_asset' );
	}
	unset( $row );

	return $rows;
}

/**
 * Seed the Services About section once.
 */
function velstadt_seed_services_about_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = get_page_by_path( 'services', OBJECT, 'page' );
	if ( ! $page || get_option( 'velstadt_services_about_seeded_' . $page->ID ) ) {
		return;
	}

	$rows     = velstadt_services_about_rows( (int) $page->ID );
	$complete = ! array_filter( $rows, static function ( $row ) { return empty( $row['icon'] ); } );

	update_field( 'field_velstadt_services_about_show', 1, $page->ID );
	update_field( 'field_velstadt_services_about_eyebrow', 'Security tested in practice', $page->ID );
	update_field( 'field_velstadt_services_about_title', 'Know what attackers can actually exploit', $page->ID );
	update_field( 'field_velstadt_services_about_description', 'Velstadt validates real attack paths, connects technical findings to business impact, and helps your team focus remediation where it reduces risk fastest', $page->ID );
	update_field( 'field_velstadt_services_about_cards', $rows, $page->ID );

	if ( $complete ) {
		update_option( 'velstadt_services_about_seeded_' . $page->ID, 1, false );
	}
}
add_action( 'acf/init', 'velstadt_seed_services_about_fields', 21 );

/**
 * Return the Challenge items copied from the Services markup.
 *
 * @return array<int,array<string,string>>
 */
function velstadt_services_default_challenge_items() {
	return array(
		array( 'title' => 'Unknown exploit paths', 'description' => 'A scanner may find isolated weaknesses but miss how an attacker can chain them into access to critical systems.' ),
		array( 'title' => 'Security blind spots', 'description' => 'Internal teams can overlook assumptions, inherited configurations, and attack techniques outside their daily view.' ),
		array( 'title' => 'Unclear remediation priorities', 'description' => 'Long findings lists make it difficult to decide which fixes reduce material business risk first.' ),
		array( 'title' => 'Untested controls', 'description' => 'Tools and policies may look complete on paper while failing under realistic adversary behavior.' ),
	);
}

/**
 * Seed the Services Challenge section once.
 */
function velstadt_seed_services_challenge_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = get_page_by_path( 'services', OBJECT, 'page' );
	if ( ! $page || get_option( 'velstadt_services_challenge_seeded_' . $page->ID ) ) {
		return;
	}

	update_field( 'field_velstadt_services_challenge_show', 1, $page->ID );
	update_field( 'field_velstadt_services_challenge_eyebrow', 'The challenge', $page->ID );
	update_field( 'field_velstadt_services_challenge_title', 'Risk hides between individual findings', $page->ID );
	update_field( 'field_velstadt_services_challenge_description', 'Modern attacks rarely depend on a single critical vulnerability. They exploit combinations of weaknesses, assumptions, and control gaps.', $page->ID );
	update_field( 'field_velstadt_services_challenge_items', velstadt_services_default_challenge_items(), $page->ID );
	update_option( 'velstadt_services_challenge_seeded_' . $page->ID, 1, false );
}
add_action( 'acf/init', 'velstadt_seed_services_challenge_fields', 22 );

/**
 * Return the Testing cards copied from the Services markup.
 *
 * @return array<int,array<string,string>>
 */
function velstadt_services_default_testing_cards() {
	return array(
		array( 'subtitle' => 'iOS · Android', 'title' => 'Mobile applications', 'description' => 'Assess client-side controls, local storage, network communication, APIs, and platform-specific weaknesses.' ),
		array( 'subtitle' => 'AWS · Azure · GCP', 'title' => 'Cloud environments', 'description' => 'Identify exposed services, risky identities, misconfigurations, and practical privilege-escalation paths.' ),
		array( 'subtitle' => 'Perimeter assessment', 'title' => 'External infrastructure', 'description' => 'Evaluate internet-facing systems from an attacker’s perspective and validate exploitable exposure.' ),
		array( 'subtitle' => 'Assumed-breach testing', 'title' => 'Internal infrastructure', 'description' => 'Model a post-compromise scenario to test segmentation, privilege boundaries, and lateral movement.' ),
	);
}

/**
 * Seed the Services Testing section once.
 */
function velstadt_seed_services_testing_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = get_page_by_path( 'services', OBJECT, 'page' );
	if ( ! $page || get_option( 'velstadt_services_testing_seeded_' . $page->ID ) ) {
		return;
	}

	update_field( 'field_velstadt_services_testing_show', 1, $page->ID );
	update_field( 'field_velstadt_services_testing_eyebrow', 'What’s included', $page->ID );
	update_field( 'field_velstadt_services_testing_title', 'Testing designed around your environment.', $page->ID );
	update_field( 'field_velstadt_services_testing_description', 'Choose a focused assessment or combine multiple surfaces into one coordinated engagement.', $page->ID );
	update_field( 'field_velstadt_services_testing_feature_subtitle', 'OWASP-aligned manual testing', $page->ID );
	update_field( 'field_velstadt_services_testing_feature_title', 'Web applications & APIs', $page->ID );
	update_field( 'field_velstadt_services_testing_feature_description', 'Test authentication, authorization, business logic, sessions, data exposure, and application-specific attack paths.', $page->ID );
	update_field( 'field_velstadt_services_testing_cards', velstadt_services_default_testing_cards(), $page->ID );
	update_option( 'velstadt_services_testing_seeded_' . $page->ID, 1, false );
}
add_action( 'acf/init', 'velstadt_seed_services_testing_fields', 23 );

/**
 * Return the Business outcomes cards copied from the Services markup.
 *
 * @return array<int,array<string,string>>
 */
function velstadt_services_default_outcome_cards() {
	return array(
		array( 'icon_source' => 'icons/dataflow.svg', 'title' => 'Reduced attack surface', 'description' => 'Remove exploitable exposure across applications, identities, cloud, and infrastructure.' ),
		array( 'icon_source' => 'icons/users-check.svg', 'title' => 'Focused investment', 'description' => 'Direct resources toward fixes with the greatest measurable effect on risk.' ),
		array( 'icon_source' => 'icons/target.svg', 'title' => 'Stronger audit evidence', 'description' => 'Demonstrate that controls and remediation have been tested in practice.' ),
		array( 'icon_source' => 'icons/shield-tick.svg', 'title' => 'More resilient delivery', 'description' => 'Give product and operations teams concrete guidance without slowing the business.' ),
	);
}

/**
 * Build Business outcomes rows backed only by Media Library icons.
 *
 * @param int $page_id Services page ID.
 * @return array<int,array<string,mixed>>
 */
function velstadt_services_outcome_rows( $page_id ) {
	$rows = velstadt_services_default_outcome_cards();

	foreach ( $rows as &$row ) {
		$source = $row['icon_source'];
		unset( $row['icon_source'] );
		$row['icon'] = velstadt_import_home_media_asset( $source, $row['title'], $page_id, '_velstadt_services_about_source_asset' );
	}
	unset( $row );

	return $rows;
}

/**
 * Seed the Services Business outcomes section once.
 */
function velstadt_seed_services_outcomes_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = get_page_by_path( 'services', OBJECT, 'page' );
	if ( ! $page || get_option( 'velstadt_services_outcomes_seeded_' . $page->ID ) ) {
		return;
	}

	$rows     = velstadt_services_outcome_rows( (int) $page->ID );
	$complete = ! array_filter( $rows, static function ( $row ) { return empty( $row['icon'] ); } );

	update_field( 'field_velstadt_services_outcomes_show', 1, $page->ID );
	update_field( 'field_velstadt_services_outcomes_eyebrow', 'Business outcomes', $page->ID );
	update_field( 'field_velstadt_services_outcomes_title', 'Close the gaps that matter most', $page->ID );
	update_field( 'field_velstadt_services_outcomes_description', 'Translate offensive-security evidence into confident decisions across security, engineering, risk, and leadership.', $page->ID );
	update_field( 'field_velstadt_services_outcomes_cards', $rows, $page->ID );

	if ( $complete ) {
		update_option( 'velstadt_services_outcomes_seeded_' . $page->ID, 1, false );
	}
}
add_action( 'acf/init', 'velstadt_seed_services_outcomes_fields', 24 );

/** Return the Deliverables copied from the Services markup. */
function velstadt_services_default_deliverables() {
	return array(
		array( 'label' => 'Executive summary with business impact' ),
		array( 'label' => 'Detailed technical findings and proof of concept' ),
		array( 'label' => 'Validated exploit paths and affected assets' ),
		array( 'label' => 'Prioritized remediation roadmap' ),
		array( 'label' => 'Technical walkthrough with your team' ),
		array( 'label' => 'Retest report and residual-risk status' ),
	);
}

/** Seed the Services Deliverables section once. */
function velstadt_seed_services_deliverables_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = get_page_by_path( 'services', OBJECT, 'page' );
	if ( ! $page || get_option( 'velstadt_services_deliverables_seeded_' . $page->ID ) ) {
		return;
	}

	update_field( 'field_velstadt_services_deliverables_show', 1, $page->ID );
	update_field( 'field_velstadt_services_deliverables_eyebrow', 'Deliverables', $page->ID );
	update_field( 'field_velstadt_services_deliverables_title', 'Evidence for engineers. Clarity for leadership', $page->ID );
	update_field( 'field_velstadt_services_deliverables_description', 'Every engagement ends with a practical decision package—not a generic scan export.', $page->ID );
	update_field( 'field_velstadt_services_deliverables_items', velstadt_services_default_deliverables(), $page->ID );
	update_option( 'velstadt_services_deliverables_seeded_' . $page->ID, 1, false );
}
add_action( 'acf/init', 'velstadt_seed_services_deliverables_fields', 25 );

/** Return the standards copied from the Services markup. */
function velstadt_services_default_standards() {
	return array(
		array( 'title' => 'OWASP', 'description' => 'WSTG · ASVS · MASVS' ),
		array( 'title' => 'NIST', 'description' => 'SP 800-115' ),
		array( 'title' => 'PTES', 'description' => 'Penetration Testing Execution Standard' ),
		array( 'title' => 'MITRE', 'description' => 'ATT&CK' ),
		array( 'title' => 'PCI DSS', 'description' => 'Requirement 11' ),
		array( 'title' => 'ISO 27001', 'description' => 'Control validation' ),
	);
}

/** Seed the Services Standards section once. */
function velstadt_seed_services_standards_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = get_page_by_path( 'services', OBJECT, 'page' );
	if ( ! $page || get_option( 'velstadt_services_standards_seeded_' . $page->ID ) ) {
		return;
	}

	update_field( 'field_velstadt_services_standards_show', 1, $page->ID );
	update_field( 'field_velstadt_services_standards_eyebrow', 'Standards & frameworks', $page->ID );
	update_field( 'field_velstadt_services_standards_title', 'Aligned with recognized testing practices', $page->ID );
	update_field( 'field_velstadt_services_standards_description', 'Engagements can be mapped to the frameworks and compliance obligations relevant to your organization.', $page->ID );
	update_field( 'field_velstadt_services_standards_items', velstadt_services_default_standards(), $page->ID );
	update_option( 'velstadt_services_standards_seeded_' . $page->ID, 1, false );
}
add_action( 'acf/init', 'velstadt_seed_services_standards_fields', 26 );

/** Return the Methodology steps copied from the Services markup. */
function velstadt_services_default_methodology() {
	$step = array(
		'step_label'  => 'Step',
		'icon_source' => 'icons/dataflow.svg',
		'title'       => 'Scope',
		'description' => 'Define objectives, critical assets, rules of engagement, and safe testing boundaries.',
	);

	return array( $step, $step, $step, $step, $step );
}

/** Build Methodology rows backed only by Media Library icons. */
function velstadt_services_methodology_rows( $page_id ) {
	$rows = velstadt_services_default_methodology();

	foreach ( $rows as &$row ) {
		$source = $row['icon_source'];
		unset( $row['icon_source'] );
		$row['icon'] = velstadt_import_home_media_asset( $source, $row['title'], $page_id, '_velstadt_services_about_source_asset' );
	}
	unset( $row );

	return $rows;
}

/** Seed the Services Methodology section once. */
function velstadt_seed_services_methodology_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = get_page_by_path( 'services', OBJECT, 'page' );
	if ( ! $page || get_option( 'velstadt_services_methodology_seeded_' . $page->ID ) ) {
		return;
	}

	$rows     = velstadt_services_methodology_rows( (int) $page->ID );
	$complete = ! array_filter( $rows, static function ( $row ) { return empty( $row['icon'] ); } );

	update_field( 'field_velstadt_services_methodology_show', 1, $page->ID );
	update_field( 'field_velstadt_services_methodology_eyebrow', 'Methodology', $page->ID );
	update_field( 'field_velstadt_services_methodology_title', 'Controlled, transparent, and built for action', $page->ID );
	update_field( 'field_velstadt_services_methodology_description', 'A repeatable engagement model keeps testing safe, evidence clear, and remediation connected to the original risk.', $page->ID );
	update_field( 'field_velstadt_services_methodology_items', $rows, $page->ID );

	if ( $complete ) {
		update_option( 'velstadt_services_methodology_seeded_' . $page->ID, 1, false );
	}
}
add_action( 'acf/init', 'velstadt_seed_services_methodology_fields', 27 );

/** Seed the Services Resources section once. */
function velstadt_seed_services_resources_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = get_page_by_path( 'services', OBJECT, 'page' );
	if ( ! $page || get_option( 'velstadt_services_resources_seeded_' . $page->ID ) ) {
		return;
	}

	$rows     = velstadt_home_resources_rows( (int) $page->ID );
	$complete = ! array_filter( $rows, static function ( $row ) { return empty( $row['image'] ); } );

	update_field( 'field_velstadt_services_resources_show', 1, $page->ID );
	update_field( 'field_velstadt_services_resources_eyebrow', 'Reports and Research', $page->ID );
	update_field( 'field_velstadt_services_resources_title', 'Intelligence for your next decision', $page->ID );
	update_field( 'field_velstadt_services_resources_description', 'Proprietary intelligence for security leaders, technical teams, and executives—based on what Velstadt observes in real-world operations.', $page->ID );
	update_field( 'field_velstadt_services_resources_items', $rows, $page->ID );

	if ( $complete ) {
		update_option( 'velstadt_services_resources_seeded_' . $page->ID, 1, false );
	}
}
add_action( 'acf/init', 'velstadt_seed_services_resources_fields', 28 );

/** Seed the Services Customer Stories section once. */
function velstadt_seed_services_customer_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = get_page_by_path( 'services', OBJECT, 'page' );
	if ( ! $page || get_option( 'velstadt_services_customer_seeded_' . $page->ID ) ) {
		return;
	}

	$rows     = velstadt_home_customer_rows( (int) $page->ID );
	$complete = ! array_filter( $rows, static function ( $row ) { return empty( $row['logo'] ); } );

	update_field( 'field_velstadt_services_customer_show', 1, $page->ID );
	update_field( 'field_velstadt_services_customer_eyebrow', 'Customer Stories', $page->ID );
	update_field( 'field_velstadt_services_customer_title', 'From signal to measurable impact', $page->ID );
	update_field( 'field_velstadt_services_customer_archive_link', velstadt_header_default_link( 'View customer stories' ), $page->ID );
	update_field( 'field_velstadt_services_customer_items', $rows, $page->ID );

	if ( $complete ) {
		update_option( 'velstadt_services_customer_seeded_' . $page->ID, 1, false );
	}
}
add_action( 'acf/init', 'velstadt_seed_services_customer_fields', 29 );

/** Return the FAQ items copied from the Services markup. */
function velstadt_services_default_faq_items() {
	$shared = '<ul><li>Security strategy</li><li>Virtual CISO</li><li>Threat modeling</li></ul>';

	return array(
		array( 'question' => 'How long does a penetration test take?', 'content' => '<p>A scanner may find isolated weaknesses but miss how an attacker can chain them into access to critical systems.</p><ul><li>Real attacker techniques</li><li>Exploit-path mapping</li><li>Prioritized remediation</li></ul>' ),
		array( 'question' => 'Will testing disrupt production systems?', 'content' => '<p>Internal teams can overlook assumptions, inherited configurations, and attack techniques outside their daily view.</p>' . $shared ),
		array( 'question' => 'Do you only run automated scanners?', 'content' => '<p>Long findings lists make it difficult to decide which fixes reduce material business risk first.</p>' . $shared ),
		array( 'question' => 'What does the final report include?', 'content' => '<p>Tools and policies may look complete on paper while failing under realistic adversary behavior.</p>' . $shared ),
		array( 'question' => 'Can Velstadt verify the fixes?', 'content' => '<p>Tools and policies may look complete on paper while failing under realistic adversary behavior.</p>' . $shared ),
		array( 'question' => 'Can the engagement support compliance requirements?', 'content' => '<p>Tools and policies may look complete on paper while failing under realistic adversary behavior.</p>' . $shared ),
	);
}

/** Seed the Services FAQ section once. */
function velstadt_seed_services_faq_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = get_page_by_path( 'services', OBJECT, 'page' );
	if ( ! $page || get_option( 'velstadt_services_faq_seeded_' . $page->ID ) ) {
		return;
	}

	update_field( 'field_velstadt_services_faq_show', 1, $page->ID );
	update_field( 'field_velstadt_services_faq_eyebrow', 'FAQ', $page->ID );
	update_field( 'field_velstadt_services_faq_title', 'What security teams ask before testing begins', $page->ID );
	update_field( 'field_velstadt_services_faq_description', 'Need to discuss a specific environment or deadline? Talk directly with a Velstadt specialist.', $page->ID );
	update_field( 'field_velstadt_services_faq_link', velstadt_header_default_link( 'Ask a question' ), $page->ID );
	update_field( 'field_velstadt_services_faq_items', velstadt_services_default_faq_items(), $page->ID );
	update_option( 'velstadt_services_faq_seeded_' . $page->ID, 1, false );
}
add_action( 'acf/init', 'velstadt_seed_services_faq_fields', 30 );

/** Convert the original FAQ answer and bullet fields to the unified editor field. */
function velstadt_migrate_services_faq_content() {
	if ( ! function_exists( 'get_field_object' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = get_page_by_path( 'services', OBJECT, 'page' );
	if ( ! $page || get_option( 'velstadt_services_faq_editor_migrated_' . $page->ID ) ) {
		return;
	}

	// Wait until the updated Services Page field group has been synchronized.
	if ( ! get_field_object( 'field_velstadt_services_faq_items_content', $page->ID ) ) {
		return;
	}

	$row_count = absint( get_post_meta( $page->ID, 'services_faq_items', true ) );
	$items     = array();

	for ( $index = 0; $index < $row_count; $index++ ) {
		$question = (string) get_post_meta( $page->ID, "services_faq_items_{$index}_question", true );
		$content  = (string) get_post_meta( $page->ID, "services_faq_items_{$index}_content", true );

		if ( '' === trim( $content ) ) {
			$answer = (string) get_post_meta( $page->ID, "services_faq_items_{$index}_answer", true );
			if ( '' !== trim( $answer ) ) {
				$content .= '<p>' . esc_html( $answer ) . '</p>';
			}

			$bullet_count = absint( get_post_meta( $page->ID, "services_faq_items_{$index}_bullets", true ) );
			$bullet_html  = '';
			for ( $bullet_index = 0; $bullet_index < $bullet_count; $bullet_index++ ) {
				$label = (string) get_post_meta( $page->ID, "services_faq_items_{$index}_bullets_{$bullet_index}_label", true );
				if ( '' !== trim( $label ) ) {
					$bullet_html .= '<li>' . esc_html( $label ) . '</li>';
				}
			}
			if ( $bullet_html ) {
				$content .= '<ul>' . $bullet_html . '</ul>';
			}
		}

		$items[] = array(
			'question' => $question,
			'content'  => $content,
		);
	}

	if ( ! $items ) {
		$items = velstadt_services_default_faq_items();
	}

	update_field( 'field_velstadt_services_faq_items', $items, $page->ID );
	update_option( 'velstadt_services_faq_editor_migrated_' . $page->ID, 1, false );
}
add_action( 'acf/init', 'velstadt_migrate_services_faq_content', 31 );

/** Seed the Services call-to-action section once. */
function velstadt_seed_services_cta_fields() {
	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	$page = get_page_by_path( 'services', OBJECT, 'page' );
	if ( ! $page || get_option( 'velstadt_services_cta_seeded_' . $page->ID ) ) {
		return;
	}

	update_field( 'field_velstadt_services_cta_show', 1, $page->ID );
	update_field( 'field_velstadt_services_cta_eyebrow', 'Request a proposal', $page->ID );
	update_field( 'field_velstadt_services_cta_title', 'Test what matters before attackers do', $page->ID );
	update_field( 'field_velstadt_services_cta_description', 'Tell us what you need to assess. A Velstadt specialist will help define the right scope, timeline, and deliverables.', $page->ID );
	update_field( 'field_velstadt_services_cta_primary_link', velstadt_header_default_link( 'Request a demo' ), $page->ID );
	update_field( 'field_velstadt_services_cta_secondary_link', velstadt_header_default_link( 'Talk to an expert' ), $page->ID );
	update_option( 'velstadt_services_cta_seeded_' . $page->ID, 1, false );
}
add_action( 'acf/init', 'velstadt_seed_services_cta_fields', 32 );

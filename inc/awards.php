<?php
/**
 * Awards post type, platform taxonomy, and initial content.
 *
 * @package Velstadt
 */

/**
 * Register awards content types.
 */
function velstadt_register_awards_content_types() {
	register_post_type(
		'award',
		array(
			'labels' => array(
				'name'          => __( 'Awards', 'velstadt' ),
				'singular_name' => __( 'Award', 'velstadt' ),
				'add_new_item'  => __( 'Add New Award', 'velstadt' ),
				'edit_item'     => __( 'Edit Award', 'velstadt' ),
			),
			'public'             => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-awards',
			'supports'           => array( 'title', 'thumbnail' ),
			'publicly_queryable' => false,
			'has_archive'        => false,
		)
	);

	register_taxonomy(
		'award_platform',
		array( 'award' ),
		array(
			'labels' => array(
				'name'          => __( 'Award Platforms', 'velstadt' ),
				'singular_name' => __( 'Award Platform', 'velstadt' ),
			),
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'hierarchical'      => false,
		)
	);
}
add_action( 'init', 'velstadt_register_awards_content_types', 5 );

/**
 * Return the award badge URL, preferring the featured image.
 *
 * @param int $award_id Award post ID.
 * @return string
 */
function velstadt_get_award_badge_url( $award_id ) {
	$image = get_the_post_thumbnail_url( $award_id, 'full' );
	if ( $image ) {
		return $image;
	}

	$asset = function_exists( 'get_field' ) ? get_field( 'award_badge_asset', $award_id ) : '';
	return $asset ? get_template_directory_uri() . '/markup/images/' . ltrim( $asset, '/' ) : '';
}

/**
 * Add the awards visible in the static prototype on the first run.
 */
function velstadt_seed_awards() {
	if ( get_option( 'velstadt_awards_seeded' ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$platforms = array(
		'clutch'       => array( 'name' => 'Clutch', 'featured' => 1, 'logo' => 'icons/clutch-logo.svg', 'rating' => '5.0/5', 'headline' => 'Trusted cybersecurity partner', 'description' => 'Recognized across security testing, dark web monitoring, and managed SIEM services.' ),
		'g2'           => array( 'name' => 'G2', 'featured' => 1, 'logo' => 'icons/g2-logo.svg', 'rating' => '5.0/5', 'headline' => 'High Performer on G2', 'description' => 'Recognized across managed security, threat hunting, and managed SIEM services.' ),
		'designrush'   => array( 'name' => 'DesignRush' ),
		'techreviewer' => array( 'name' => 'Techreviewer' ),
		'techbehemoths'=> array( 'name' => 'TechBehemoths' ),
		'the-manifest' => array( 'name' => 'The Manifest' ),
	);
	$term_ids = array();

	foreach ( $platforms as $slug => $platform ) {
		$term = term_exists( $slug, 'award_platform' );
		if ( ! $term ) {
			$term = wp_insert_term( $platform['name'], 'award_platform', array( 'slug' => $slug ) );
		}
		if ( is_wp_error( $term ) ) {
			continue;
		}
		$term_id           = (int) ( is_array( $term ) ? $term['term_id'] : $term );
		$term_ids[ $slug ] = $term_id;
		$context           = 'award_platform_' . $term_id;
		update_field( 'field_velstadt_platform_featured', ! empty( $platform['featured'] ), $context );
		if ( ! empty( $platform['logo'] ) ) {
			update_field( 'field_velstadt_platform_logo_asset', $platform['logo'], $context );
			update_field( 'field_velstadt_platform_rating', $platform['rating'], $context );
			update_field( 'field_velstadt_platform_headline', $platform['headline'], $context );
			update_field( 'field_velstadt_platform_description', $platform['description'], $context );
		}
	}

	$awards = array(
		array( 'title' => 'Top Cybersecurity Companies', 'platform' => 'designrush', 'year' => 2026, 'asset' => 'awards/designrush-top-cybersecurity-companies-2026-badge.svg' ),
		array( 'title' => 'Top Software Testing Company', 'platform' => 'clutch', 'year' => 2026, 'asset' => 'awards/clutch-top-software-testing-company-2026-badge.svg' ),
		array( 'title' => 'High Performer', 'platform' => 'g2', 'year' => 2026, 'asset' => 'awards/g2-high-performer-2026-badge.svg' ),
		array( 'title' => 'High Performer Winter', 'platform' => 'g2', 'year' => 2026, 'asset' => 'awards/g2-high-performer-winter-2026-badge.svg' ),
		array( 'title' => 'Top QA and Software Testing Companies', 'platform' => 'techreviewer', 'year' => 2026, 'asset' => 'awards/techreviewer-top-qa-and-software-testing-companies-2026-badge.svg' ),
		array( 'title' => 'Top Dark Web Monitoring', 'platform' => 'clutch', 'year' => 2025, 'asset' => 'awards/clutch-top-dark-web-2025-badge.svg' ),
	);

	foreach ( $awards as $award ) {
		$existing = get_posts(
			array(
				'post_type'      => 'award',
				'post_status'    => 'any',
				'title'          => $award['title'],
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);
		$post_id = $existing ? (int) $existing[0] : wp_insert_post( array( 'post_type' => 'award', 'post_status' => 'publish', 'post_title' => $award['title'] ) );
		if ( ! $post_id || is_wp_error( $post_id ) ) {
			continue;
		}
		wp_set_object_terms( $post_id, array( $term_ids[ $award['platform'] ] ), 'award_platform' );
		update_field( 'field_velstadt_award_year', $award['year'], $post_id );
		update_field( 'field_velstadt_award_badge_asset', $award['asset'], $post_id );
	}

	update_option( 'velstadt_awards_seeded', 1, false );
}
add_action( 'init', 'velstadt_seed_awards', 30 );

/**
 * Seed the manual Home Page award selection once.
 */
function velstadt_seed_home_awards_selection() {
	$front_page_id = (int) get_option( 'page_on_front' );
	if ( ! $front_page_id || get_option( 'velstadt_home_awards_selection_seeded_' . $front_page_id ) || ! function_exists( 'update_field' ) ) {
		return;
	}

	$award_ids = get_posts(
		array(
			'post_type'      => 'award',
			'post_status'    => 'publish',
			'posts_per_page' => 5,
			'meta_key'       => 'award_year',
			'orderby'        => array( 'meta_value_num' => 'DESC', 'date' => 'DESC' ),
			'fields'         => 'ids',
		)
	);

	update_field( 'field_velstadt_home_awards_selected', $award_ids, $front_page_id );
	update_option( 'velstadt_home_awards_selection_seeded_' . $front_page_id, 1, false );
}
add_action( 'init', 'velstadt_seed_home_awards_selection', 40 );

/**
 * Assign the Awards template and seed editable headings for its year groups.
 */
function velstadt_seed_awards_page_settings() {
	$page = get_page_by_path( 'awards-and-recognition', OBJECT, 'page' );
	if ( ! $page ) {
		return;
	}

	if ( 'page-awards-and-recognition.php' !== get_page_template_slug( $page->ID ) ) {
		update_post_meta( $page->ID, '_wp_page_template', 'page-awards-and-recognition.php' );
	}

	if ( ! function_exists( 'update_field' ) ) {
		return;
	}

	if ( ! get_option( 'velstadt_awards_page_settings_seeded_' . $page->ID ) ) {
		update_field(
			'field_velstadt_awards_year_sections',
			array(
				array( 'year' => 2026, 'heading' => 'Broader security recognition' ),
				array( 'year' => 2025, 'heading' => 'Broader security recognition' ),
			),
			$page->ID
		);
		update_option( 'velstadt_awards_page_settings_seeded_' . $page->ID, 1, false );
	}

	if ( get_option( 'velstadt_awards_page_content_seeded_v2_' . $page->ID ) ) {
		return;
	}

	$platform_rows = array();
	foreach ( array( 'clutch', 'g2' ) as $platform_slug ) {
		$platform = get_term_by( 'slug', $platform_slug, 'award_platform' );
		if ( $platform ) {
			$platform_rows[] = array( 'platform' => $platform->term_id );
		}
	}

	$feedback_items = array(
		array(
			'rating'    => '5.0',
			'stars'     => 5,
			'label'     => 'Application security',
			'quote'     => '“Their deep understanding of API security went beyond standard testing.”',
			'logo_asset'=> 'icons/clutch-logo.svg',
			'name'      => 'Andrii Danylik',
			'position'  => 'CPO · Nova Poshta',
		),
		array(
			'rating'    => '5.0',
			'stars'     => 5,
			'label'     => 'Compliance',
			'quote'     => '“Velstadt’s expertise in compliance and cybersecurity set them apart.”',
			'logo_asset'=> 'icons/clutch-logo.svg',
			'name'      => 'Evgeniy Egorov',
			'position'  => 'Product Owner · Sheriff',
		),
		array(
			'rating'    => '5.0',
			'stars'     => 5,
			'label'     => 'Security consulting',
			'quote'     => '“Their proven technical expertise, business-oriented approach and strong commitment to adapting solutions to each customer’s specific environment.”',
			'logo_asset'=> 'icons/g2-logo.svg',
			'name'      => 'Sergii K.',
			'position'  => 'CEO · Information Technology and Services',
		),
		array(
			'rating'    => '5.0',
			'stars'     => 5,
			'label'     => 'Application security',
			'quote'     => '“Their deep understanding of API security went beyond standard testing.”',
			'logo_asset'=> 'icons/clutch-logo.svg',
			'name'      => 'Andrii Danylik',
			'position'  => 'CPO · Nova Poshta',
		),
		array(
			'rating'    => '5.0',
			'stars'     => 5,
			'label'     => 'Application security',
			'quote'     => '“Their deep understanding of API security went beyond standard testing.”',
			'logo_asset'=> 'icons/clutch-logo.svg',
			'name'      => 'Andrii Danylik',
			'position'  => 'CPO · Nova Poshta',
		),
	);

	update_field( 'field_velstadt_awards_hero_show', 1, $page->ID );
	update_field( 'field_velstadt_awards_hero_subtitle', 'Industry Recognition', $page->ID );
	update_field( 'field_velstadt_awards_hero_title', 'Awards & Recognition', $page->ID );
	update_field( 'field_velstadt_awards_hero_description', 'Independent platforms recognize Velstadt for cybersecurity, cloud, and engineering expertise — reflecting technical quality, disciplined delivery, and client trust.', $page->ID );
	update_field( 'field_velstadt_awards_platforms_show', 1, $page->ID );
	update_field( 'field_velstadt_awards_platform_cards', $platform_rows, $page->ID );
	update_field( 'field_velstadt_awards_rankings_show', 1, $page->ID );
	update_field( 'field_velstadt_awards_rankings_subtitle', 'Independent recognition', $page->ID );
	update_field( 'field_velstadt_awards_rankings_title', 'Awards and rankings', $page->ID );
	update_field( 'field_velstadt_awards_feedback_show', 1, $page->ID );
	update_field( 'field_velstadt_awards_feedback_subtitle', 'Verified customer feedback', $page->ID );
	update_field( 'field_velstadt_awards_feedback_title', 'What our clients say', $page->ID );
	update_field( 'field_velstadt_awards_feedback_items', $feedback_items, $page->ID );
	update_option( 'velstadt_awards_page_content_seeded_v2_' . $page->ID, 1, false );
}
add_action( 'init', 'velstadt_seed_awards_page_settings', 45 );

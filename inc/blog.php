<?php
/**
 * Blog archive helpers and initial settings.
 *
 * @package Velstadt
 */

/**
 * Return a manual reading time or estimate it from rendered article blocks.
 *
 * @param int $post_id Post ID.
 * @return int
 */
function velstadt_blog_reading_time( $post_id ) {
	$manual = function_exists( 'get_field' ) ? (int) get_field( 'post_reading_time', $post_id, false ) : 0;
	if ( $manual > 0 ) {
		return $manual;
	}
	$article = get_post( $post_id );
	if ( ! $article ) {
		return 1;
	}

	static $cache = array();
	static $calculating = array();
	$key = $article->ID . ':' . md5( $article->post_content );
	if ( isset( $cache[ $key ] ) ) {
		return $cache[ $key ];
	}
	if ( isset( $calculating[ $article->ID ] ) ) {
		return 1;
	}

	// Rendering a card must not change the enclosing WordPress loop or author.
	$global_names = array( 'post', 'id', 'authordata', 'currentday', 'currentmonth', 'page', 'pages', 'multipage', 'more', 'numpages' );
	$saved_globals = array();
	foreach ( $global_names as $name ) {
		if ( array_key_exists( $name, $GLOBALS ) ) {
			$saved_globals[ $name ] = $GLOBALS[ $name ];
		}
	}
	$calculating[ $article->ID ] = true;
	try {
		$GLOBALS['post'] = $article;
		$content = do_blocks( $article->post_content );
	} finally {
		foreach ( $global_names as $name ) {
			if ( array_key_exists( $name, $saved_globals ) ) {
				$GLOBALS[ $name ] = $saved_globals[ $name ];
			} else {
				unset( $GLOBALS[ $name ] );
			}
		}
		unset( $calculating[ $article->ID ] );
	}

	// Keep adjacent paragraphs, table cells and captions from merging into words.
	$content = preg_replace( '/<\/(?:p|div|h[1-6]|li|td|th|pre|blockquote|figcaption|figure|section)>|<br\b[^>]*>/i', ' $0 ', $content );
	$text = html_entity_decode( wp_strip_all_tags( strip_shortcodes( $content ) ), ENT_QUOTES | ENT_HTML5, 'UTF-8' );
	$words = preg_split( '/[\s\p{Z}]+/u', trim( $text ), -1, PREG_SPLIT_NO_EMPTY );

	$cache[ $key ] = max( 1, (int) ceil( count( (array) $words ) / 200 ) );
	return $cache[ $key ];
}

/**
 * Return the display name of a post author.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function velstadt_blog_author_name( $post_id ) {
	$author_id = velstadt_blog_author_id( $post_id );

	return $author_id ? get_the_title( $author_id ) : '';
}

/** Resolve a published editorial author, then the shared default. */
function velstadt_blog_author_id( $post_id ) {
	if ( ! function_exists( 'get_field' ) ) {
		return 0;
	}
	$author_id = (int) get_field( 'post_editorial_author', $post_id );
	if ( $author_id && 'velstadt_author' === get_post_type( $author_id ) && 'publish' === get_post_status( $author_id ) ) {
		return $author_id;
	}
	$author_id = (int) get_field( 'default_editorial_author', 'option' );
	return $author_id && 'velstadt_author' === get_post_type( $author_id ) && 'publish' === get_post_status( $author_id ) ? $author_id : 0;
}

/** Render a Media Library avatar or initials using the caller's layout class. */
function velstadt_blog_author_avatar( $post_id, $class ) {
	$author_id = velstadt_blog_author_id( $post_id );
	$name = $author_id ? get_the_title( $author_id ) : '';
	$avatar = $author_id ? (int) get_field( 'author_avatar', $author_id ) : 0;
	if ( $avatar ) {
		$image = wp_get_attachment_image( $avatar, 'thumbnail', false, array( 'class' => $class, 'alt' => $name ) );
		if ( $image ) {
			return $image;
		}
	}
	return $name ? '<span class="' . esc_attr( $class . ' author-initials' ) . '" aria-hidden="true">' . esc_html( velstadt_blog_author_initials( $name ) ) . '</span>' : '';
}

/**
 * Build author initials for the archive cards.
 *
 * @param string $name Author display name.
 * @return string
 */
function velstadt_blog_author_initials( $name ) {
	$parts    = preg_split( '/\s+/u', trim( $name ), -1, PREG_SPLIT_NO_EMPTY );
	$initials = '';

	foreach ( array_slice( $parts, 0, 2 ) as $part ) {
		$initials .= function_exists( 'mb_substr' ) ? mb_substr( $part, 0, 1 ) : substr( $part, 0, 1 );
	}

	return function_exists( 'mb_strtoupper' ) ? mb_strtoupper( $initials ) : strtoupper( $initials );
}

/**
 * Return the first assigned category.
 *
 * @param int $post_id Post ID.
 * @return WP_Term|null
 */
function velstadt_blog_primary_category( $post_id ) {
	$categories = get_the_category( $post_id );

	return $categories ? reset( $categories ) : null;
}

/**
 * Extend the Blog archive search to the selected editorial author or default.
 *
 * @param string   $search Existing search SQL.
 * @param WP_Query $query  Current query.
 * @return string
 */
function velstadt_blog_posts_search( $search, $query ) {
	if ( ! $query->get( 'velstadt_blog_search' ) || ! $query->get( 's' ) ) {
		return $search;
	}

	global $wpdb;

	$like   = '%' . $wpdb->esc_like( trim( (string) $query->get( 's' ) ) ) . '%';
	$default_author = function_exists( 'get_field' ) ? (int) get_field( 'default_editorial_author', 'option' ) : 0;
	$search = $wpdb->prepare(
		" AND (
			{$wpdb->posts}.post_title LIKE %s
			OR {$wpdb->posts}.post_excerpt LIKE %s
			OR {$wpdb->posts}.post_content LIKE %s
			OR EXISTS (
				SELECT 1
				FROM {$wpdb->posts} AS editorial_author
				WHERE editorial_author.post_type = 'velstadt_author'
				AND editorial_author.post_status = 'publish'
				AND editorial_author.post_title LIKE %s
				AND editorial_author.ID = COALESCE((
					SELECT selected_author.ID
					FROM {$wpdb->postmeta} AS author_meta
					INNER JOIN {$wpdb->posts} AS selected_author ON selected_author.ID = CAST(author_meta.meta_value AS UNSIGNED)
					WHERE author_meta.post_id = {$wpdb->posts}.ID
					AND author_meta.meta_key = 'post_editorial_author'
					AND selected_author.post_type = 'velstadt_author'
					AND selected_author.post_status = 'publish'
					LIMIT 1
				), %d)
			)
		)",
		$like,
		$like,
		$like,
		$like,
		$default_author
	);

	if ( ! is_user_logged_in() ) {
		$search .= " AND {$wpdb->posts}.post_password = ''";
	}

	return $search;
}
add_filter( 'posts_search', 'velstadt_blog_posts_search', 10, 2 );

/**
 * Render a post image with a bundled fallback.
 *
 * @param int    $post_id Post ID.
 * @param string $class   CSS class.
 * @param string $size    WordPress image size.
 * @return void
 */
function velstadt_blog_post_image( $post_id, $class = '', $size = 'large' ) {
	if ( has_post_thumbnail( $post_id ) ) {
		echo get_the_post_thumbnail( $post_id, $size, array( 'class' => $class, 'alt' => get_the_title( $post_id ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		return;
	}

	$fallbacks = array( 'post-card1.svg', 'post-card2.svg', 'post-card3.svg' );
	$fallback  = $fallbacks[ absint( $post_id ) % count( $fallbacks ) ];
	printf(
		'<img src="%1$s" alt="%2$s" class="%3$s">',
		esc_url( get_template_directory_uri() . '/markup/images/' . $fallback ),
		esc_attr( get_the_title( $post_id ) ),
		esc_attr( $class )
	);
}

/**
 * Keep WordPress pagination routing in sync with the Blog page setting.
 *
 * @param WP_Query $query Main query.
 */
function velstadt_blog_main_query_settings( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_home() ) {
		return;
	}

	$page_id        = (int) get_option( 'page_for_posts' );
	$posts_per_page = function_exists( 'get_field' ) ? (int) get_field( 'blog_posts_per_page', $page_id ) : 6;
	$query->set( 'posts_per_page', $posts_per_page > 0 ? min( 24, $posts_per_page ) : 6 );
}
add_action( 'pre_get_posts', 'velstadt_blog_main_query_settings' );

/**
 * Build a compact, predictable pagination sequence.
 *
 * @param int $current Current page.
 * @param int $total   Total number of pages.
 * @return array<int|string>
 */
function velstadt_blog_pagination_items( $current, $total ) {
	$total   = max( 1, (int) $total );
	$current = min( $total, max( 1, (int) $current ) );

	if ( $total <= 7 ) {
		return range( 1, $total );
	}

	$pages = array( 1, 2, 3, $current - 1, $current, $current + 1, $total - 2, $total - 1, $total );
	$pages = array_values(
		array_unique(
			array_filter(
				$pages,
				static function ( $page ) use ( $total ) {
					return $page >= 1 && $page <= $total;
				}
			)
		)
	);
	sort( $pages, SORT_NUMERIC );

	$items    = array();
	$previous = 0;
	foreach ( $pages as $page ) {
		$gap = $page - $previous;
		if ( $previous && 2 === $gap ) {
			$items[] = $previous + 1;
		} elseif ( $previous && $gap > 2 ) {
			$items[] = 'ellipsis';
		}

		$items[] = $page;
		$previous = $page;
	}

	return $items;
}

/**
 * Seed editable Blog page settings once.
 */
function velstadt_seed_blog_page_settings() {
	$page_id = (int) get_option( 'page_for_posts' );
	if ( ! $page_id || ! function_exists( 'update_field' ) || get_option( 'velstadt_blog_page_seeded_' . $page_id ) ) {
		return;
	}

	$latest_posts = get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	update_field( 'field_velstadt_blog_hero_show', 1, $page_id );
	update_field( 'field_velstadt_blog_hero_subtitle', 'Velstadt Blog', $page_id );
	update_field( 'field_velstadt_blog_hero_title', 'Cybersecurity insights that matter', $page_id );
	update_field( 'field_velstadt_blog_hero_description', 'Research, threat trends, and practical guidance from specialists who connect technical findings with business context', $page_id );
	update_field( 'field_velstadt_blog_hero_note', 'Research · Analysis · Guidance', $page_id );
	update_field( 'field_velstadt_blog_featured_post', $latest_posts ? (int) $latest_posts[0] : 0, $page_id );
	update_field( 'field_velstadt_blog_posts_per_page', 6, $page_id );
	update_field( 'field_velstadt_blog_show_resources', 1, $page_id );
	update_field( 'field_velstadt_blog_show_subscribe', 1, $page_id );
	update_option( 'velstadt_blog_page_seeded_' . $page_id, 1, false );
}
add_action( 'acf/init', 'velstadt_seed_blog_page_settings', 20 );

/**
 * Create the post categories used by the Blog design once.
 */
function velstadt_seed_blog_categories() {
	if ( get_option( 'velstadt_blog_categories_seeded' ) ) {
		return;
	}

	$categories = array(
		'Threat Research'       => 'threat-research',
		'Threat Intelligence'   => 'threat-intelligence',
		'Penetration Testing'   => 'penetration-testing',
		'Security Operations'   => 'security-operations',
		'Compliance'            => 'compliance',
		'Cybersecurity Strategy'=> 'cybersecurity-strategy',
		'Company News'          => 'company-news',
	);

	foreach ( $categories as $name => $slug ) {
		if ( ! term_exists( $slug, 'category' ) ) {
			wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
		}
	}

	update_option( 'velstadt_blog_categories_seeded', 1, false );
}
add_action( 'init', 'velstadt_seed_blog_categories', 35 );

/**
 * Create temporary posts for checking the Blog grid, filters, and pagination.
 */
function velstadt_seed_blog_test_posts() {
	if ( get_option( 'velstadt_blog_test_posts_seeded' ) ) {
		return;
	}

	$posts = array(
		array( 'Universal OTP to 0-Click Account Takeover', 'How a static verification code bypassed authentication during a real penetration testing engagement.', 'penetration-testing' ),
		array( 'U.S. Ransomware Threat Landscape: H1 2026', 'What observed victim records reveal about exposure, geography, and defensive priorities.', 'threat-research' ),
		array( 'Virtual CISO: Strengthening Cyber Resilience', 'A practical operating model for organizations that need strategic security leadership.', 'cybersecurity-strategy' ),
		array( 'From Exposed File Manager to Remote Code Execution', 'An anonymized case study tracing an exposed file manager to full server compromise.', 'penetration-testing' ),
		array( 'Ransomware Access Brokers: Signals Before the Incident', 'Early indicators that help defenders identify access-for-sale activity before extortion.', 'threat-intelligence' ),
		array( 'Building an Effective Security Operations Program', 'Core processes and metrics for developing a resilient security operations capability.', 'security-operations' ),
		array( 'Cloud Compliance Readiness Checklist', 'A practical checklist for preparing cloud environments for security control assessments.', 'compliance' ),
		array( 'Threat Intelligence Requirements That Drive Action', 'How to define intelligence requirements that support measurable security decisions.', 'threat-intelligence' ),
		array( 'Inside a Modern Phishing Campaign', 'A technical breakdown of infrastructure, delivery methods, and defensive signals.', 'threat-research' ),
		array( 'Preparing for a Penetration Test', 'What engineering and security teams should prepare before an external assessment.', 'penetration-testing' ),
		array( 'Velstadt Expands Its Security Research Practice', 'An update on our growing research capabilities and focus areas.', 'company-news' ),
		array( 'Cybersecurity Priorities for Growing Companies', 'A risk-based roadmap for organizations scaling their technology and operations.', 'cybersecurity-strategy' ),
	);

	foreach ( $posts as $index => $post_data ) {
		$existing = get_posts(
			array(
				'post_type'      => 'post',
				'post_status'    => 'any',
				'title'          => $post_data[0],
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);
		if ( $existing ) {
			continue;
		}

		$category = get_term_by( 'slug', $post_data[2], 'category' );
		$post_id  = wp_insert_post(
			array(
				'post_type'     => 'post',
				'post_status'   => 'publish',
				'post_title'    => $post_data[0],
				'post_excerpt'  => $post_data[1],
				'post_content'  => '<p>' . esc_html( $post_data[1] ) . '</p><p>This temporary article was created to verify the Blog archive layout, category filters, and pagination. Replace it with final editorial content when the Blog is ready.</p>',
				'post_category' => $category ? array( (int) $category->term_id ) : array(),
				'menu_order'    => $index,
			),
			true
		);

		if ( ! is_wp_error( $post_id ) ) {
			update_post_meta( $post_id, '_velstadt_test_blog_post', 1 );
		}
	}

	update_option( 'velstadt_blog_test_posts_seeded', 1, false );
}
add_action( 'init', 'velstadt_seed_blog_test_posts', 36 );

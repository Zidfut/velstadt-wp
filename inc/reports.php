<?php
/**
 * Reports catalog queries and helpers.
 *
 * @package Velstadt
 */

/**
 * Return published reports matching the current catalog category.
 *
 * @return array{query: WP_Query, category: string, page: int}
 */
function velstadt_reports_catalog_query( $page_id = 0 ) {
	$category = isset( $_GET['report_category'] ) && is_string( $_GET['report_category'] ) ? sanitize_title( wp_unslash( $_GET['report_category'] ) ) : '';
	$page     = isset( $_GET['report_page'] ) && is_scalar( $_GET['report_page'] ) ? max( 1, absint( $_GET['report_page'] ) ) : 1;
	$term     = $category ? get_term_by( 'slug', $category, 'report_category' ) : null;
	$per_page = function_exists( 'get_field' ) ? (int) get_field( 'reports_posts_per_page', $page_id ) : 0;
	$per_page = $per_page > 0 ? min( 24, $per_page ) : 9;
	$featured = function_exists( 'get_field' ) ? (int) get_field( 'reports_featured_report', $page_id ) : 0;

	if ( $category && ( ! $term || is_wp_error( $term ) ) ) {
		$category = '';
	}

	$query_args = array(
		'post_type'      => 'velstadt_report',
		'post_status'    => 'publish',
		'posts_per_page' => $per_page,
		'paged'          => $page,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);
	if ( $featured ) {
		$query_args['post__not_in'] = array( $featured );
	}

	if ( $category ) {
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'report_category',
				'field'    => 'slug',
				'terms'    => $category,
			),
		);
	}

	return array(
		'query'    => new WP_Query( $query_args ),
		'category' => $category,
		'page'     => $page,
	);
}

/** Return an editable Reports page value or its fallback. */
function velstadt_get_reports_page_field( $name, $page_id, $fallback = '' ) {
	$value = function_exists( 'get_field' ) ? get_field( $name, $page_id ) : null;

	return null !== $value && false !== $value && '' !== $value ? $value : $fallback;
}

/** Return an editable Reports page toggle while preserving an explicit off value. */
function velstadt_get_reports_page_toggle( $name, $page_id, $fallback = true ) {
	if ( ! function_exists( 'get_field' ) || ! metadata_exists( 'post', $page_id, $name ) ) {
		return $fallback;
	}

	return (bool) get_field( $name, $page_id );
}

/** Return the first assigned report category. */
function velstadt_report_primary_category( $post_id ) {
	$terms = get_the_terms( $post_id, 'report_category' );

	return $terms && ! is_wp_error( $terms ) ? reset( $terms ) : null;
}

/** Return three report IDs, filling unused slots with the latest reports. */
function velstadt_get_related_report_ids( $post_id, $category ) {
	$args = array(
		'post_type'      => 'velstadt_report',
		'post_status'    => 'publish',
		'posts_per_page' => 3,
		'post__not_in'   => array( $post_id ),
		'fields'         => 'ids',
	);
	$related = array();

	if ( $category ) {
		$related = get_posts(
			array_merge(
				$args,
				array( 'tax_query' => array( array( 'taxonomy' => 'report_category', 'field' => 'term_id', 'terms' => $category->term_id ) ) )
			)
		);
	}

	if ( count( $related ) < 3 ) {
		$args['posts_per_page'] -= count( $related );
		$args['post__not_in']    = array_merge( $args['post__not_in'], $related );
		$related                = array_merge( $related, get_posts( $args ) );
	}

	return $related;
}

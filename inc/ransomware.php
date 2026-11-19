<?php
/**
 * Ransomware catalog queries.
 *
 * @package Velstadt
 */

/** Return the published profiles matching the catalog filters. */
function velstadt_ransomware_catalog_query( $page_id ) {
	$category = isset( $_GET['ransomware_category'] ) && is_string( $_GET['ransomware_category'] ) ? sanitize_title( wp_unslash( $_GET['ransomware_category'] ) ) : '';
	$search = isset( $_GET['ransomware_search'] ) && is_string( $_GET['ransomware_search'] ) ? sanitize_text_field( wp_unslash( $_GET['ransomware_search'] ) ) : '';
	$page = isset( $_GET['ransomware_page'] ) && is_scalar( $_GET['ransomware_page'] ) ? max( 1, absint( $_GET['ransomware_page'] ) ) : 1;
	$batch_size = (int) get_field( 'ransomware_posts_per_page', $page_id );
	$batch_size = $batch_size > 0 ? min( 60, $batch_size ) : 15;
	$term = $category ? get_term_by( 'slug', $category, 'ransomware_category' ) : null;
	if ( ! $term || is_wp_error( $term ) ) {
		$category = '';
	}

	$query_args = array(
		'post_type'      => 'velstadt_ransomware',
		'post_status'    => 'publish',
		'posts_per_page' => $batch_size,
		'paged'          => $page,
		'orderby'        => array( 'menu_order' => 'ASC', 'ID' => 'ASC' ),
		// Search the public card text and tags as well as the profile title.
		'velstadt_ransomware_search' => $search,
	);
	if ( $category ) {
		$query_args['tax_query'] = array( array( 'taxonomy' => 'ransomware_category', 'field' => 'slug', 'terms' => $category ) );
	}

	return array( 'query' => new WP_Query( $query_args ), 'category' => $category, 'search' => $search, 'page' => $page );
}

/** Scope search to the catalog query, including repeater tag values. */
function velstadt_ransomware_search_where( $where, $query ) {
	$search = $query->get( 'velstadt_ransomware_search' );
	if ( ! is_string( $search ) || '' === $search ) {
		return $where;
	}
	global $wpdb;
	$like = '%' . $wpdb->esc_like( $search ) . '%';
	$where .= $wpdb->prepare(
		" AND ( {$wpdb->posts}.post_title LIKE %s OR EXISTS ( SELECT 1 FROM {$wpdb->postmeta} AS ransomware_search WHERE ransomware_search.post_id = {$wpdb->posts}.ID AND (ransomware_search.meta_key = 'ransomware_card_description' OR ransomware_search.meta_key LIKE %s) AND ransomware_search.meta_value LIKE %s ) )",
		$like,
		$wpdb->esc_like( 'ransomware_tags_' ) . '%' . $wpdb->esc_like( '_text' ),
		$like
	);
	return $where;
}
add_filter( 'posts_where', 'velstadt_ransomware_search_where', 10, 2 );

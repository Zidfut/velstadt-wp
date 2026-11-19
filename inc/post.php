<?php
/**
 * Single post helpers and SCF block registration.
 *
 * @package Velstadt
 */

/** Return related posts, preferring the current post category. */
function velstadt_post_related_posts( $post_id, $count = 3 ) {
	$category = velstadt_blog_primary_category( $post_id );
	$args     = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => absint( $count ),
		'post__not_in'        => array( absint( $post_id ) ),
		'ignore_sticky_posts' => true,
	);

	if ( $category ) {
		$args['category__in'] = array( (int) $category->term_id );
	}

	$query = new WP_Query( $args );
	if ( $query->post_count < $count && isset( $args['category__in'] ) ) {
		unset( $args['category__in'] );
		$query = new WP_Query( $args );
	}

	return $query;
}

/** Add a dedicated inserter category for editorial blocks. */
function velstadt_post_block_categories( $categories ) {
	array_unshift( $categories, array( 'slug' => 'velstadt-post', 'title' => __( 'Velstadt Post', 'velstadt' ) ) );
	return $categories;
}
add_filter( 'block_categories_all', 'velstadt_post_block_categories' );

/** Register the custom SCF blocks used by posts. */
function velstadt_register_post_blocks() {
	if ( ! function_exists( 'acf_register_block_type' ) ) {
		return;
	}

	$blocks = array(
		'key-takeaways' => array( 'title' => __( 'Key Takeaways', 'velstadt' ), 'icon' => 'lightbulb' ),
		'details'       => array( 'title' => __( 'Details', 'velstadt' ), 'icon' => 'media-text' ),
		'points'        => array( 'title' => __( 'Points', 'velstadt' ), 'icon' => 'grid-view' ),
		'action-rows'   => array( 'title' => __( 'Action Rows', 'velstadt' ), 'icon' => 'editor-ol' ),
		'quote'         => array( 'title' => __( 'Quote', 'velstadt' ), 'icon' => 'format-quote' ),
		'note'          => array( 'title' => __( 'Note', 'velstadt' ), 'icon' => 'info-outline' ),
		'metrics'       => array( 'title' => __( 'Metrics', 'velstadt' ), 'icon' => 'chart-bar' ),
		'faq'           => array( 'title' => __( 'FAQ', 'velstadt' ), 'icon' => 'editor-help' ),
		'sources'       => array( 'title' => __( 'Sources', 'velstadt' ), 'icon' => 'book-alt' ),
		'related'       => array( 'title' => __( 'Related Reading', 'velstadt' ), 'icon' => 'external' ),
		'download'      => array( 'title' => __( 'Download', 'velstadt' ), 'icon' => 'download' ),
		'share'         => array( 'title' => __( 'Share / CTA', 'velstadt' ), 'icon' => 'share' ),
		'table'         => array( 'title' => __( 'Table', 'velstadt' ), 'icon' => 'editor-table' ),
		'media'         => array( 'title' => __( 'Image / Gallery', 'velstadt' ), 'icon' => 'format-gallery' ),
		'code'          => array( 'title' => __( 'Code', 'velstadt' ), 'icon' => 'editor-code' ),
	);

	foreach ( $blocks as $slug => $settings ) {
		$title = $settings['title'];
		acf_register_block_type(
			array(
				'name'            => 'velstadt-' . $slug,
				'title'           => $title,
				'description'     => sprintf( __( '%s editorial block.', 'velstadt' ), $title ),
				'category'        => 'velstadt-post',
				'icon'            => $settings['icon'],
				'mode'            => 'preview',
				'post_types'      => in_array( $slug, array( 'faq', 'share' ), true ) ? array( 'post', 'velstadt_ransomware' ) : array( 'post' ),
				'render_template' => get_theme_file_path( '/template-parts/post/blocks/' . $slug . '.php' ),
				'supports'        => array( 'align' => false, 'anchor' => true, 'jsx' => true ),
			)
		);
	}
}
add_action( 'acf/init', 'velstadt_register_post_blocks' );

/** Return a safe HTML id for an SCF block. */
function velstadt_post_block_id( $block, $prefix ) {
	if ( ! empty( $block['anchor'] ) ) {
		return sanitize_title( $block['anchor'] );
	}

	return sanitize_html_class( $prefix . '-' . ( isset( $block['id'] ) ? $block['id'] : wp_unique_id() ) );
}

/** Display a small editor-only hint when a new block has no content yet. */
function velstadt_post_block_empty( $is_preview, $message ) {
	if ( $is_preview ) {
		printf( '<div class="post__block"><p>%s</p></div>', esc_html( $message ) );
	}
}

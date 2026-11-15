<?php
/**
 * Helpers for the generic content page template.
 *
 * @package Velstadt
 */

/**
 * Add stable anchors to H2 headings and build a table of contents.
 *
 * @param string $content Rendered page content.
 * @return array{content:string,toc:array<int,array<string,string>>}
 */
function velstadt_prepare_content_page( $content ) {
	$toc  = array();
	$used = array();

	$content = preg_replace_callback(
		'/<h2([^>]*)>(.*?)<\/h2>/is',
		static function ( $matches ) use ( &$toc, &$used ) {
			$attributes   = $matches[1];
			$heading_html = $matches[2];
			$label        = trim( wp_strip_all_tags( html_entity_decode( $heading_html, ENT_QUOTES, get_bloginfo( 'charset' ) ) ) );
			$id           = '';

			if ( preg_match( '/\sid=(?:"([^"]+)"|\'([^\']+)\')/i', $attributes, $id_match ) ) {
				$id = ! empty( $id_match[1] ) ? $id_match[1] : $id_match[2];
			} else {
				$base = sanitize_title( $label );
				$base = $base ?: 'section-' . ( count( $toc ) + 1 );
				$id   = $base;
				$next = 2;

				while ( isset( $used[ $id ] ) ) {
					$id = $base . '-' . $next;
					++$next;
				}

				$attributes .= ' id="' . esc_attr( $id ) . '"';
			}

			$used[ $id ] = true;
			if ( $label ) {
				$toc[] = array(
					'id'    => $id,
					'label' => $label,
				);
			}

			return '<h2' . $attributes . '>' . $heading_html . '</h2>';
		},
		$content
	);

	return array(
		'content' => $content,
		'toc'     => $toc,
	);
}

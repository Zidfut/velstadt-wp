<?php
/** Author bio at an editorially chosen position. @package Velstadt */
$article_id = isset( $post_id ) && is_numeric( $post_id ) ? (int) $post_id : get_the_ID();
$article_id = wp_is_post_revision( $article_id ) ?: $article_id;
$author_id = velstadt_blog_author_id( $article_id );
if ( ! $author_id ) {
	velstadt_post_block_empty( $is_preview, __( 'Select an article author.', 'velstadt' ) );
	return;
}
get_template_part( 'template-parts/post/author', null, array( 'post_id' => $article_id, 'author_id' => $author_id ) );

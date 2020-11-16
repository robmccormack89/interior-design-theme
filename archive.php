<?php
/**
 * The template for displaying general archive pages
 *
 * @package Shanley_Theme
 */

$templates = array( 'archive.twig', 'index.twig' );

$context = Timber::context();

$context['pagination'] = Timber::get_pagination();
$context['paged'] = $paged;

$context['title'] = 'Archive';

if ( is_category() ) {
	
	global $paged;
	if (!isset($paged) || !$paged){
		$paged = 1;
	}
	
	$category_id = get_cat_ID(single_cat_title('', false));
	$category = get_category($category_id);
	$context['is_parent'] = $category->category_parent;
	
	$context['title'] = single_cat_title( '', false );
	array_unshift( $templates, 'archive-' . get_query_var( 'cat' ) . '.twig' );
	
	$sticky_data = get_option( 'sticky_posts' );
	$sticky = is_sticky();
	$context['sticky'] = is_sticky();
	
	if (!empty($sticky)) {
		
		$first_sticky = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'post__in'   => $sticky_data,
			'posts_per_page'=> 1,
			'cat' => get_query_var( 'cat' ),
			'orderby' => 'date',
			'order'   => 'DESC',
		);
		$context['first_sticky'] = new Timber\PostQuery( $first_sticky );
		
		$sec_sticky = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page'=> 4,
			'cat' => get_query_var( 'cat' ),
			'offset' => 1,
			'post__in'   => $sticky_data,
			'orderby' => 'date',
			'order'   => 'DESC',
		);
		$context['sec_sticky'] = new Timber\PostQuery( $sec_sticky );
		
		$posts_args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'post__not_in'   => $sticky_data,
			'posts_per_page'=> 9,
			'cat' => $category_id,
			'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1 ),
			'ignore_sticky_posts' => 1,
			'orderby' => 'date',
			'order'   => 'DESC',
		);
		$context['the_posts'] = new Timber\PostQuery($posts_args);
		
	} else {
		
		$one_posts_args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page'=> 1,
			'cat' => $category_id,
			'orderby' => 'date',
			'order'   => 'DESC',
		);
		$context['one_posts'] = new Timber\PostQuery($one_posts_args);
		
		$posts_args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page'=> 9,
			'offset' => 1,
			'cat' => $category_id,
			'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1 ),
			'orderby' => 'date',
			'order'   => 'DESC',
		);
		$context['the_posts'] = new Timber\PostQuery($posts_args);

	}
	
} else if ( is_post_type_archive() ) {
	$context['title'] = post_type_archive_title( '', false );
	array_unshift( $templates, 'archive-' . get_post_type() . '.twig' );
}

Timber::render( $templates, $context );
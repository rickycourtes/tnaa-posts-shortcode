<?php
/**
 * Plugin Name: TNAA Posts
 * Plugin URI: https://tnaa.com/
 * Description: Display a listing of TNSS posts using the [tnaa-posts] shortcode
 * Version: 1.0.0
 * Author: Ricky Courtes
 * Author URI: https://www.github.com/rickycourtes
 */

function tnna_posts_attachments() {
    wp_register_style('tnna_posts_style', plugins_url('css/style.css',__FILE__ ));
    wp_register_script( 'imagesloaded', plugins_url('js/imagesloaded.pkgd.min.js',__FILE__ ));
    wp_register_script( 'tnna_posts_script', plugins_url('js/script.js',__FILE__ ));
}

add_action( 'wp_enqueue_scripts','tnna_posts_attachments');

function tnna_posts_shortcode($atts) {
	$args = shortcode_atts( array(
		'limit' => '5',
		'sort' => 'asc',
		'sortby' => 'date',
		'categories' => ''
 	), $atts );
		
	$url = "http://tnaaphptest.wpengine.com/wp-json/wp/v2/posts";

	$query = array(
		'per_page' => $args['limit'],
		'order' => $args['sort'],
		'orderby' => $args['sortby'],
		'_embed' => ''
	);
	
	if( !empty($args['categories']) ) { $query['categories'] = $args['categories']; }
	
	$query_url = $url .'?'. http_build_query($query);
	$request = wp_remote_get($query_url);

	if( is_wp_error( $request ) ) { return false; }

	$body = wp_remote_retrieve_body( $request );
	$data = json_decode( $body );
	
	$content = '<div class="tnaa-posts auto-grid">';
		
	if( !empty( $data ) ) {		
		foreach( $data as $item ) {
			$content .= '<div class="grid-item">';
			$content .= '<div class="tnaa-post">';

			$image = $item->_embedded->{"wp:featuredmedia"}[0]->media_details->sizes->{"post-grid"};
			$image_url = $image->source_url;
			$image_width = $image->width;
			$image_height = $image->height;
			
			$content .= '<div class="tnaa-post-image">';

			if (!empty($image_url)) {
				$content .= '<img src="'. $image_url .'" width="'. $image_width .'" height="'. $image_height .'" alt="" />';
			} else {
				$content .= '<img src="https://tnaaphptest.wpengine.com/wp-content/uploads/2020/10/header-image-final-01-820x620-1.jpg" width="820" height="620" alt="" />';
			}

			$content .= '</div>';
						
			$content .= '<div class="tnaa-post-content">';
			$content .= '<div class="tnaa-post-date">' . date("F j, Y", strtotime($item->date)) . '</div>';
			$content .= '<div class="tnaa-post-title"><a href="' . esc_url( $item->link ) . '">' . $item->title->rendered . '</a></div>';
			$content .= '<div class="tnaa-post-desc">' . strip_tags($item->excerpt->rendered) . '</div>';
			$content .= '</div>';
			
			$content .= '</div>';
			$content .= '</div>';
		}
		
		wp_enqueue_style('tnna_posts_style');
		wp_enqueue_script('imagesloaded');
		wp_enqueue_script('tnna_posts_script');
	}
	
	$content .= '</div>';
	 
	return $content;
}

add_shortcode( 'tnaa-posts', 'tnna_posts_shortcode' );
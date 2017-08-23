<?php
/*
Plugin Name: resu_ME
Plugin URI: 
Description: TO help a wordpress reusme site
Version: 1
Author: Andrew White
Author URI: 
License: MIT
*/
$plugin_path = plugin_dir_path(__file__);
require_once ($plugin_path . "/inc/class/m2m_resu_ME.php");

$resu_ME = new m2m_resu_ME($plugin_path);


// Add Shortcode


/***helpers***/
function template_trace($file){
	$filePathParts = pathinfo($file);
	$trace = $filePathParts["dirname"] . "/" . $filePathParts["basename"];
	echo "<pre>",$trace, "</pre>";
}

function m2m_render_part($id, $cust_feild_name, $custom_array = ['default']){
	$custom_array = ['default'] ? get_post_custom($id) : $custom_array;
	$terms = explode(',', $custom_array[$cust_feild_name][0]);
	$args = array(
		'post_type' => 'skill',
		'tax_query' => array(
			array(
				'taxonomy' => $cust_feild_name,
				'field'    => 'slug',
				'terms'    => $terms,
				)
		 	)
			);
	$query_parts = new WP_Query( $args );
	if ( $query_parts->have_posts() ) {
		while ( $query_parts->have_posts() ) : $query_parts->the_post();
		the_excerpt();
        
    endwhile;
		wp_reset_postdata();
	}
}
?>

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
if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

define ('M2M_PLUGINROOT', plugin_dir_path(__file__));
define ('M2M_CLASS', M2M_PLUGINROOT . 'inc/class/');
define ('M2M_VIWES', M2M_PLUGINROOT . 'views/');
define ('M2M_SCRIPTS', M2M_PLUGINROOT . 'inc/scripts/');
define ('M2M_LIB', M2M_PLUGINROOT . 'inc/lib/');
define ('M2M_CONFIG', M2M_PLUGINROOT . 'config/');
				
require_once (M2M_CLASS . "M2M_Resu_ME.php");

$resu_ME = new M2M_Resu_ME();

// Add Shortcode




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

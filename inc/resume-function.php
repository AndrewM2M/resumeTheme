<?php
if ( ! function_exists('m2m_resume_post_type') ) {

// Register Custom Post Type
function m2m_resume_post_type() {

	$labels = array(
		'name'                  => 'Resumes',
		'singular_name'         => 'Resume',
		'archives'              => 'Item Archives',
		'attributes'            => 'Item Attributes',
		'parent_item_colon'     => 'Parent Item:',
		'all_items'             => 'All Items',
		'add_new_item'          => 'Add New Item',
		'add_new'               => 'Add New',
		'new_item'              => 'New Item',
		'edit_item'             => 'Edit Item',
		'update_item'           => 'Update Item',
		'view_item'             => 'View Item',
		'view_items'            => 'View Items',
		'search_items'          => 'Search Item',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into item',
		'uploaded_to_this_item' => 'Uploaded to this item',
		'items_list'            => 'Items list',
		'items_list_navigation' => 'Items list navigation',
		'filter_items_list'     => 'Filter items list',
	);
	$args = array(
		'label'                 => 'Resume',
		'description'           => 'Master Post to hold the Resume together',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', 'wpcom-markdown'),
		'taxonomies'            => array( 'Resumes' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'							=> 'dashicons-format-aside',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'resume', $args );

}
add_action( 'init', 'm2m_resume_post_type', 0 );

}

if ( ! function_exists('m2m_skill_post_type') ) {

// Register Custom Post Type
function m2m_skill_post_type() {

	$labels = array(
		'name'                  => 'Skills',
		'singular_name'         => 'Skill',
		'attributes'            => 'Item Attributes',
		'parent_item_colon'     => 'Skills:',
		'all_items'             => 'All Skills',
		'add_new_item'          => 'Add New Skill',
		'add_new'               => 'Add Skill',
		'new_item'              => 'New Skill',
		'edit_item'             => 'Edit Skill',
		'update_item'           => 'Update Skill',
		'view_item'             => 'View Skill',
		'view_items'            => 'View Skills',
		'search_items'          => 'Search Skill',
		'items_list'            => 'Skills list',
		'items_list_navigation' => 'Skills list navigation',
		'filter_items_list'     => 'Filter Skills list',
	);
	$args = array(
		'label'                 => 'Skill',
		'description'           => 'A Skill to be displaied on resumes',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'revisions', 'custom-fields', 'wpcom-markdown'),
		'taxonomies'            => array( 'Skills' ),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 6,
		'menu_icon'							=> 'dashicons-editor-ul',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'page',
	);
	register_post_type( 'skill', $args );

}
add_action( 'init', 'm2m_skill_post_type', 0 );

}
function m2m_taxonomy_skillList()
{
    $labels = [
        'name'              => _x('Skill lists', 'taxonomy general name'),
'singular_name'     => _x('Skill list', 'taxonomy singular name'),
'search_items'      => __('Search Skill lists'),
'all_items'         => __('All Skill lists'),
'parent_item'       => __('Parent Skill list'),
'parent_item_colon' => __('Parent Skill list:'),
'edit_item'         => __('Edit Skill list'),
'update_item'       => __('Update Skill list'),
'add_new_item'      => __('Add New Skill list'),
'new_item_name'     => __('New Skill list Name'),
];
$args = [
'hierarchical'      => true, // make it hierarchical (like categories)
'labels'            => $labels,
'show_ui'           => true,
'show_admin_column' => true,
'query_var'         => true,
'rewrite'           => ['slug' => 'skill_list'],
];
register_taxonomy('skillList', ['skill'], $args);
}
add_action('init', 'm2m_taxonomy_skillList');

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
	} else 
		echo "nope";
	
	
	
}
?>
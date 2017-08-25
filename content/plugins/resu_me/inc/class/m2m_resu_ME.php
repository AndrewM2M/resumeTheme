<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
require_once ("m2m_cust_posts.php");
class m2m_resu_ME {
  
  protected $path;
  /*protected $labels = array(
      'singular_name' => 'Resume'
    
      );
     protected $args = array(
        'description'           => 'Master Post to hold the Resume together',
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
      );*/
  protected $specs = array ();
  
  function __construct($plugin_path) {
    
    $this->plugin_path = $plugin_path;
    $cpt = "resumes";
    /*$this->specs = array (
    $cpt => array('labels' =>$this->labels,
                       'args' => $this->args,
                      'hook' => "init")
     );*/
    //file_put_contents(__dir__."/cpt_".$cpt."_specs.json",json_encode($this->specs));
    $this->specs = json_decode(file_get_contents(__dir__."/cpt_".$cpt."_specs.json"),true);
    m2m_cust_posts::build_cpt($this->specs);
    
    add_action( 'init', array($this, 'm2m_resume_post_type'), 0 );
    add_action( 'init', array($this,'m2m_skill_post_type'), 0 );
    add_action('init', array($this, 'm2m_taxonomy_skillList'));

   } //__constuctor
  //TODO: build a "add_action privte methiod"
  
 
  
  //TODO: build a "post_type facotry (maybe a different class file)  
  
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
  function m2m_taxonomy_skillList(){
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
}
?>
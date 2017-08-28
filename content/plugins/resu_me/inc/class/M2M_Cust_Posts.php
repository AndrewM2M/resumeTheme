<?php
if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
include_once ("M2M_Helpers.php");
class M2M_Cust_Posts
{
    public $good_specs;
    protected $specs_by_hook = array();

    public function __construct($specs)
    { //do not pass the lables array in the args array
        /* TODO: autobuild taxonomy option
        */
        $raw_specs = $specs;

        function proccess_spec($raw)
        {
            foreach ($raw as $cpt_name => $details) {
                $has_labels = 0;
                foreach ($details as $key => $setting) {
                        switch ($key) {
                          case 'raw_labels'://process labels
                            $has_labels = 1;
                            
                            $plural = isset($details['args']['label']) ? $details['args']['label'] : $cpt_name;   //check and fix plurization
                            $singular = isset($setting['singular_name']) ? $setting['singular_name'] : $cpt_name;

                            $m2m_post_label_defauts = array(   //set label defaults and enforce capitolization
                              'name'                  => $singular,
                              'singular_name'         => ucfirst($singular),
                              'archives'              => ucfirst($singular) .' Archives',
                              'attributes'            => ucfirst($singular) . ' Attributes',
                              'parent_item_colon'     => 'Parent '.ucfirst($singular).':',
                              'all_items'             => 'All '.ucfirst($plural),
                              'add_new_item'          => 'Add New '.ucfirst($singular),
                              'new_item'              => 'New '.ucfirst($singular),
                              'edit_item'             => 'Edit '.ucfirst($singular),
                              'update_item'           => 'Update '.ucfirst($singular),
                              'view_item'             => 'View '.ucfirst($singular),
                              'view_items'            => 'View '.ucfirst($plural),
                              'search_items'          => 'Search '.ucfirst($plural),
                              'insert_into_item'      => 'Insert into '.lcfirst($singular),
                              'uploaded_to_this_item' => 'Uploaded to this '.lcfirst($singular),
                              'items_list'            => ucfirst($plural).' list',
                              'items_list_navigation' => ucfirst($plural).' list navigation',
                              'filter_items_list'     => 'Filter '.lcfirst($plural).' list',
                            );

                             $details['labels'] = $setting + $m2m_post_label_defauts;  //update labels after processing
                            break;
                          case 'args': //process args
                              
                              $setting['lable'] = isset($details['labels']['name']) ? $details['labels']['name'] : $cpt_name; //resolve and set 'label'/'name'
                              if ($has_labels && is_array($setting)) { //grab processed lables
                                $setting['labels'] = $details['labels'];
                              }
                                $raw[$cpt_name]['args'] = $setting;
                            break;
                          case 'hook': break;
                          default: error_log("err: no vaid settings");
                        }
                }
            }
            return $raw;
        }// end process_spec
        $this->good_specs = proccess_spec($raw_specs);
        $this->m2m_add_actions();
    }

    protected function m2m_add_actions($actions="")
    {
        if ($actions === "") {
            if ($this->good_specs) {
                $resuffle = array();
                foreach ($this->good_specs as $cpt_name => $feilds) { //gather hooks
                  $current_hook = $feilds['hook'];
                  $current_args = $feilds['args'];
                  $this->specs_by_hook[$current_hook][$cpt_name]['args'] = $current_args;
                }
            } else {
                $err = "no good_specs";
            };
            foreach ($this->specs_by_hook as $hook_to_process => $cpts){
              add_action($hook_to_process,array($this, 'm2m_actions_responder'));
              
            }
          
        };
    }

    public function m2m_actions_responder()
    {
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
        $testargs = array(
        'description'           => 'Master Post to hold the Resume together',
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', 'wpcom-markdown'),
        'taxonomies'            => array( 'Resumes' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-format-aside',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'label'                 => 'Resume',
      );
      $running_hook =  current_filter();
      $doings = $this->specs_by_hook[$running_hook];      
      M2M_Helpers::showShit($doings);
      foreach ($doings as $tag => $args){
        //M2M_Helpers::showShit($tag);
        $reg = $args['args'];
        register_post_type($tag, $reg);
      }
      /*$tag = 'resumes';
      $args = $doings[$tag]['args'];
      //M2m_Helpers::showShit($doings[$tag]['args']);
      register_post_type($tag, $args);
     
      //register_post_type($tag, $testargs);
        */
    }
}

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
      $running_hook =  current_filter();
      $doings = $this->specs_by_hook[$running_hook];      
      foreach ($doings as $tag => $args){
        $reg = $args['args'];
        register_post_type($tag, $reg);
      }
    }
}

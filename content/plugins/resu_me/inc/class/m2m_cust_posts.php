<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class m2m_cust_posts {
  
  protected $action_callbacks = array(); 
  
  static function build_cpt($specs){ //do not pass the lables array in the args array
    /* TODO: autobuild taxonomy option
    */
    $raw_specs = $specs;
    
    function proccess_spec($raw){
    foreach ($raw as $cpt_name => $details){
      $has_labels = 0;
      foreach ($details as $key => $setting){
        if (is_array($setting)){        
          switch ($key){
            case 'labels'://process labels
              $has_labels = 1;
              
              $plural = isset($details['args']['label']) ? $details['args']['label'] : $cpt_name;   //check and fix plurization
              $singular = isset($setting['singular_name']) ? $setting['singular_name'] : $cpt_name;

              $m2m_post_label_defauts = array (   //set label defaults and enforce capitolization
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
                if ($has_labels && is_array($setting)){ //grab processed lables
                  $setting['labels'] = $details['labels'];
                }
                  $details['args'] = $setting;
              break;
          default: echo "err: no settings";
          }
          return $raw;
        }else{
          return FALSE;
        }//end if
        
      }
    }
   }// end process_spec
    $good_specs = proccess_spec($raw_specs);
    print_r($good_specs);
  }
  
}

?>
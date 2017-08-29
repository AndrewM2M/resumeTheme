<?php
if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
include_once(M2M_CLASS . 'M2M_Helpers.php');


class M2M_Resu_ME_Admin{  
   public function __construct(){
     add_action('add_meta_boxes',array($this, 'm2m_add_custom_box'));
  }

  public function m2m_add_custom_box()
      {   
          $current_screen = get_current_screen()->post_type;
          $screen_labels = get_post_type_object($current_screen)->labels;
          $box_types = array(
            'm2m_resumes_box' => array(
              'title'     =>  $screen_labels->singular_name. ' Componates',
              'callback'  =>  array($this,'m2m_custom_box_html'),
              'screens'   =>  array($current_screen),
              'context'   =>  'side',
              'priority'  =>  'default',
              )
            );
          foreach ($box_types as $ids => $boxes){            
            foreach ($boxes['screens'] as $screen) {
              if (function_exists('add_meta_box')){
                add_meta_box(
                    $ids,
                    $boxes['title'],
                    $boxes['callback'],
                    $screen,
                    $boxes['context'],
                    $boxes['priority']
                );
              }// end if
            }
        };
    
  }
    public function m2m_custom_box_html($post){
     echo '<h2>Admin Test Page</h2>';
     $this->m2m_load_admin_view($post->post_type);
    }

     function m2m_load_admin_view($part){    
      include (M2M_VIWES ."admin/meta-$part.php");
  }
}
?>
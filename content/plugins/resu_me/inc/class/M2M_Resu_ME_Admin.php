<?php
if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
include_once("M2M_Helpers.php");
  define ('ADMINVIEWS', PLUGINPATH ."/views/admin");
class M2M_Resu_ME_Admin{  
  public function __constuctor(){
  
  }
  public function m2m_add_admin_actions(){
    add_action('add_meta_boxes',array($this, 'm2m_add_custom_box'));
  }
  public function m2m_add_custom_box()
      {
          echo "yo;";
          $screens = ['resumes'];
          foreach ($screens as $screen) {
            if (function_exists('add_meta_box')){
              add_meta_box(
                  'm2m_resumes_box',           // Unique ID
                  'Resume Meta',  // Box title
                  array($this,'m2m_custom_box_html'),  // Content callback, must be of type callable
                  $screen                   // Post type
              );
            }
          }
      }
    public function m2m_custom_box_html(){
     echo '<h2>Admin Test Page</h2>';
     $this->m2m_load_admin_view('resumes');
    }

     function m2m_load_admin_view($part){    
      include (ADMINVIEWS."meta-".$part);
  }
}
?>
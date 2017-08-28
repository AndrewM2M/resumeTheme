<?php
if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class M2M_Helpers {
        
  static function write_cpt_specs($spec_name, $singular_name, $description) //utility fuction not for production
    {
        $file = __dir__.'/cpt_'.$spec_name.'_specs.json';
        $labels = array(
            'singular_name'         => $singular_name,
        );
        $args = array(
            'description'           => $description,
            'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'revisions', 'custom-fields', 'wpcom-markdown'),
            'taxonomies'            => array( 'Skills' ),
            'hierarchical'          => false,
            'public'                => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 6,
            'menu_icon'                            => 'dashicons-editor-ul',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => false,
            'capability_type'       => 'page',
        );
        $specs = array(
            $spec_name => array(
                    'labels' => $labels,
                    'args'    => $args,
                    'hook'    => 'init'
            )
        );
        if (!file_exists($file)) {
            $toWrite = json_encode($specs, JSON_PRETTY_PRINT);
            file_put_contents($file, $toWrite);
        } else {
            error_log($file.' already exists');
        }
    }
  
   static function showShit($shit){
      if (!is_admin() && isset($shit)){
        echo "<pre>";
        print_r($shit);
        echo "</pre>";
      }
    }
  static function showWPError($result){
     if ( is_wp_error( $result ) ) {
        $error_string = $result->get_error_message();
        echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
      }else{
        echo '<div id="message" class="error"><p> sill nothing </p></div>';
      }
  }
  
}// end of class

?>
<?php
if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
class M2M_Helpers {
		protected static  $savedMessages = array();
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
  
		static private function message_logger(){
			/*to gather messages to be displayed via various WP compatiable output methods
			will need to store:
				index
				the message
				where to be displayed (screen, post, debug.log)
				how to be displayed (admin_notices, shortcode, written to log, other???)			
			*/
		}
	
		static function showShit($shit){
			if (!has_action('admin_notices','showShit')){
            add_action( 'admin_notices', array('M2M_Helpers', 'showShit'),10);
        }
        $hook = current_filter();
				if (did_action('init')){
				if (function_exists('get_current_screen')){
					if ($hook === 'admin_notices'){
							$class ='notice notice-warning';
						if (array_key_exists(get_current_screen()->post_type,self::$savedShit)){
							$adminShit = self::$savedShit[get_current_screen()->post_type];
							switch (gettype($adminShit)){
									case 'string':
									$message = $adminShit;
									break;
									default:
									$message = wp_json_encode($adminShit);
									break;
							}
							printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
						}
					}else{
						self::$savedShit[get_current_screen()->post_type] = $shit;
					}
				}
				if (!is_admin()){
					echo '<pre>' . print_r($shit) . '</pre>';
        }
				}else{
					echo '<pre>' . print_r($shit) . '</pre>';
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
    static function template_trace($file){
        $filePathParts = pathinfo($file);
        $trace = $filePathParts["dirname"] . "/" . $filePathParts["basename"];
        echo "<pre>",$trace, "</pre>";
    }
}// end of class
?>
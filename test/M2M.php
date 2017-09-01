<?php namespace M2M;
ini_set('error_log', 'debug.log');

class M2M {
  
  //invoker that kicks us off **it all starts here baby***
  public static function start(){
    $settings = func_get_args();
    $wp_dir = null;
    if (array_key_exists('fakeWP',$settings)){
      $wp_dir = rtrim ($settings['fakeWP'],'/');     
    }elseif (in_array ('fakeWP', $settings)){
      $wp_dir = dirname(__FILE__) . '/';
    }
    if (empty($wp_dir)){
      define('ABSPATH', $wp_dir. '/');
    };
    if (self::isWP()){
      self::run_wp_config();
    }
  }
  
  static private function isWP(){
    return (defined ('ABSPATH'));
  }
  
static private function  whatami(){
  $trace = debug_backtrace();
        foreach ($trace as $level){
          $file = pathinfo($level['file'],PATHINFO_FILENAME);
          $type = explode('-',$file)[0] ;
          switch ($type){
            case 'plugin':
            case 'theme':
              break;
            default: $type = 'unknown';
          }
        }
  return $type;
}
  
  static private function  plugin_config(){
    echo "I'll conifg the plugins";
  }
  
  static private function run_wp_config(){
    $config_type = self::whatami();
      switch ($config_type) {
        case 'plugin':
          self::plugin_config();
          break;
          
        default: 
          error_log("M2M Error: 'Crisis of Identity' - Apparently Im a $config_type, but I don't now what that is!");
          break;
      }
    ?>
      <ul>
        <li>Identify what we are (plugin/theme/other??)</li>
        <li>Find what we are called.</li>
        <li>look for config.</li>
        <li>look for load config</li>
        <li>run config handler</li>
</ul>
    <?php
  }
    
}



?>
<?php namespace M2M;
define ('ABSPATH', TRUE);
class M2M {
  
  //invoker that kicks us off **it all starts here baby***
  public static function start(){
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
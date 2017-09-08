<?php
use M2M\M2M;

if (M2M::isWP()) {
    M2M::WP_safety();
}
;
class M2M_MESSAGE_QUE
{
    public static $instance;
    private static $messages = array();

    public function __construct()
    {
        self::$instance = $this;
    }
    
    public static function get_que(){
      if (self::$instance === null) {
            self::$instance = new self;
        }
      return self::$instance;
    }
  
    public function add($message)
    {
      array_push(self::$messages,$message);
      var_dump(self::$messages);
    }
}
?>
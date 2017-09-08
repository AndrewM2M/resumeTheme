<?php
use M2M\M2M;
require_once BASE . 'M2M_MESSAGE_QUE.php';
if (M2M::isWP()) {
    M2M::WP_safety();
}
;
class M2M_MESSAGES
{

    private $settings = array();
    public $type;
    public $text;
    private $que;
  
  public function check_que(){
    var_dump ($this->que);
  }
  
  private function isGood(){
        return (!empty($this->type) && !empty($this->text)) ? TRUE:FALSE;
  }
  
  private function add(){
    if ($this->isGood()) {
    echo 'is good';
    $this->que->add($this);
  }  
  }
  public function __construct($message = '')
    {
        if (array_key_exists('M2M_MESSAGES', M2M::$M2M_settings)) {
            $def_set = M2M::$M2M_settings['M2M_MESSAGES'];

            if (is_array($def_set)) {
                foreach ($def_set as $opt => $value) {
                    $this->settings[$opt] = ($value);
                }
            } else {
                array_push($this->settings, $def_set);
            }
        }
      $this->que = M2M_MESSAGE_QUE::get_que();
      if ($message !== ''){
        $this->set($message);
      }
  }
  public function set($message){
      if (is_array($message)){
        foreach ($message as $key => $value){
          switch ($key){
            case 'type':
              $this -> type = $value;
              break;
            case 'text':
              $this -> text = $value;
              break;
            default:
              error_log($key . 'is unknown message property');
          }
        }
      }else{
          error_log('bad message');
      }
    $this -> add();
    }
  
    } // end __construct

<?php
use M2M\M2M;

if (M2M::isWP()) {
    M2M::WP_safety();
}
;
class M2M_MESSAGES
{

    private $settings = array();

    public function __construct($param = null)
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
    } // end __construct

    private function set_message($message)
    {

    }

}
class M2M_MESSAGE_QUE
{
    public static $instance;
    private static $messages = array();
    public function __construct()
    {
        if ($instance === null) {
            self::$instance = $this;
        }
        return self::$instance;
    }

    public function add($message)
    {
    	self::$messages += $message;
    }
}

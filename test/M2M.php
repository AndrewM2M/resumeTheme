<?php namespace M2M;

//print posix_getpwuid(posix_geteuid())['name'];
class M2M
{

    static $M2M_settings = array(
        'isfakeWP'    => FALSE,
        'M2M_MESSAGES'      =>      array(
            'option1'   =>    'thing',

            )        
    );

    public static function WP_safety()
    {
        if (!defined('ABSPATH')) {
            trigger_error('NOPE!');
            exit;
        }
    }

    private static function grok_settings($settings)
    {
        foreach ($settings as $value) {
            if (is_array($value)) {
                foreach ($value as $option => $val) {
                    self::$M2M_settings[$option] = $val;
                }
            } else {
                array_push(self::$M2M_settings, $value);
            }
        }
    }

    //invoker that kicks us off **it all starts here baby**
    public static function start()
    {
        self::set_consts();
        self::grok_settings(func_get_args());
        self::do_requires();

        if (self::isWP()) {
            echo 'runing conifg';
            self::run_wp_config();
        } else {echo 'not WP';}
    }

    private static function isWP()
    {
        if (defined('ABSPATH')) {
            return true;
        } else {
            $wp_dir = null;
            if (array_key_exists('fakeWP', self::$M2M_settings)) {
                echo "Fake WP key detected, ";
                $wp_dir = rtrim(self::$M2M_settings['fakeWP'], '/');
            } elseif (in_array('fakeWP', self::$M2M_settings)) {
                echo "Fake WP option detected, ";
                $wp_dir = dirname(__FILE__);
                self::$M2M_settings['isfakeWP']   =   TRUE;
            } else {
                echo 'oops ';

            }
            if ($wp_dir) {
                echo "setting ABSPATH to $wp_dir" . '/';
                define('ABSPATH', $wp_dir . '/');
            };
            return (defined('ABSPATH'));
        }
    }

    private static function whatami()
    {
        $trace = debug_backtrace();
        foreach ($trace as $level) {
            $file  = pathinfo($level['file'], PATHINFO_FILENAME);
            $parts = explode('-', $file);
            if (sizeof($parts) >= 3) {
                $type = $parts[0];
                define('ME', $parts[2]);
                switch ($type) {
                    case 'plugin':
                    case 'theme':
                        return $type;
                        break;
                    default:$type = 'unknown';
                }}
        }
        return $type;
    }

    private static function plugin_config()
    {
        echo "I'll conifg the plugin called " . ME;
        include CONFIG . ME . '-config.php';
    }

    private static function run_wp_config()
    {
        $config_type = self::whatami();
        switch ($config_type) {
            case 'plugin':
                self::plugin_config();
                break;

            default:
                error_log("M2M Error: 'Crisis of Identity' - Apparently I'm a $config_type, but I don't now what that is!");
                break;
        }

    }
    private static function set_consts(){
        define('ROOT', dirname(__FILE__) . '/');
        define('BASE', ROOT . 'base/');
        define('CONFIG', ROOT . 'config/');
        //if (self::$M2M_settings['isfakeWP']){
          define('WP_PLUGIN_DIR', '../content/plugins' );
        //}
    }
    private static function do_requires(){
        require_once BASE . 'M2M_MESSAGES.php';
    }

    /*public static function getsettings($modual)
    {
        $class_name = get_class($modual);
        if (array_key_exists($class_name , self::$M2M_settings)) {
            $def_set = self::$M2M_settings[$class_name];

            if (is_array($def_set)) {
                foreach ($def_set as $opt => $value) {
                    $modual->settings[$opt] = ($value);
                }
            } else {
                array_push($modual->settings, $def_set);
            }
        }
    }*/

}

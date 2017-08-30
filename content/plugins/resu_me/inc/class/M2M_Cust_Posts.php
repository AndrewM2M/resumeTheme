<?php
if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

define ('M2M_CPT_CONFIG', M2M_CONFIG . 'cpt');
require_once (M2M_LIB . 'vendor/autoload.php');
include_once(M2M_CLASS . 'M2M_Helpers.php');


use PostTypes\PostType;

/*
make of list of CPT names
look for config files
if config exisits
  load config
else
  pass name
  
return array('[cpt_name]':config(
        'raw_labels' => array(),
        'args'      => array(),
        
*/

function m2m_get_cpts(){
  $cpt_files = array();
  $m2m_cpt_dir = new DirectoryIterator(M2M_CPT_CONFIG);
  foreach ($m2m_cpt_dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        array_push($cpt_files,$fileinfo->getFilename());
    };
  }
  $cpt_files = preg_grep('/cpt_.*_specs.json/',$cpt_files);
  
  
  
  return $cpts;
}
$m2m_cpts = m2m_get_cpts();



M2M_Helpers::showShit($m2m_cpts);

$resusme = new PostType('resume');

?>
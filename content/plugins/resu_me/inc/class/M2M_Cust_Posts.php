<?php
if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

define ('M2M_CPT_CONFIG', M2M_CONFIG . 'cpt/');
require_once (M2M_LIB . 'vendor/autoload.php');
include_once(M2M_CLASS . 'M2M_Helpers.php');


use PostTypes\PostType;

  $cpts = array(); // array of CPT Objects
  $cpt_files = array(); // array of CPT configs loaded from files
  
  $m2m_cpt_names = array('resume','achivement','experience','skill','qulifiction'); // the CPT to use
  
  function m2m_get_cpts($names){
  $cpt_files = array(); // array of CPT configs loaded from files
  //$m2m_cpt_dir = new DirectoryIterator(M2M_CPT_CONFIG);
  $m2m_specs_mask = M2M_CPT_CONFIG ."cpt_%s_specs.json";
     foreach ($names as $value) { //load the specs from the files
        $file = sprintf($m2m_specs_mask, $value);
        if (file_exists($file)) {
            $rFile = json_decode(file_get_contents($file), true);
            $cpt_files = array_merge($cpt_files, $rFile);
        } else {
            error_log('no JSON file: "' . $file . '"');
            $cpt_files[$value] = '';
        }
      }
  return $cpt_files;
}

$m2m_cpt_specs = m2m_get_cpts($m2m_cpt_names);

foreach ($m2m_cpt_specs as $name => $specs){
  $cpts[$name] = new PostType($name);
  if ($specs != ''){
      /*$cpt_taxes = $specs['args']['taxonomies'];
      foreach ($cpt_taxes as $tax_names){
        $cpts[$name]->taxonomy($tax_names);
      }*/
    foreach ($specs as $key => $details){
      switch ($key){
        case 'raw_labels':
            
          break;
      }
    }
  }
}



?>
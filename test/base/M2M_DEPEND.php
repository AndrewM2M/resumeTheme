<?php 
use M2M\M2M;
//require_once BASE . 'M2M_MESSAGES.php';
if (M2M::isWP()) {
    M2M::WP_safety();
}
;
// reads component dependencies and checks for them

class M2M_DEPEND{
	static public function check($dependencies = ''){
		$check_list = new M2M_MESSAGES;
		if ($dependencies == ''){
			if (array_key_exists('dependencies', M2M::settings)){
				$dependencies = M2M::$settings['dependencies'];
			}else{
			$list = FALSE;
			}
		}

		foreach ($dependencies as $path) {
			$file = pathinfo($path , PATHINFO_BASENAME);
			if (file_exists($path)){
				$list = array(
					'type'	=>	'notice',
					'text'	=>	$file . ' found',
				);
			
			}else{
				$list = array(
					'type'	=>	'error',
					'text'	=>	$file . ' missing',
				);
			}	
		}
		$check_list->set($list);
		$check_list->check_que();
	}
}

?>
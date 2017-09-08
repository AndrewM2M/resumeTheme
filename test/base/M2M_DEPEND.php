<?php 
use M2M\M2M;

if (M2M::isWP()) {
    M2M::WP_safety();
}
;
// reads component dependencies and checks for them

class M2M_DEPEND{
	static public function check($dependencies = ''){
		$list = array();
		if ($dependencies == ''){
			if (array_key_exists('dependencies', M2M::settings)){
				$dependencies = M2M::settings['dependencies'];
			}else{
			$list = FALSE;
			}
		}

		foreach ($dependencies as $path) {
			$file = pathinfo($path,PATHINFO_BASENAME);
			echo $path;
			if (file_exists($path)){
				$list[$file] = 'found';
			}else{
				$list[$file] = 'missing';
			}	
		}
		return $list;
	}
}

?>
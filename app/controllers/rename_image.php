<?php 
if(!empty($_POST['name']) && !empty($_POST['user'])) {
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$name = $_POST['name'] .'.png';
		$defaultName = $_POST['user'] .'.png';
		$dir = '../../public/uploads/';

		if (exif_imagetype($dir . $name) == IMAGETYPE_PNG) {
			try {
				unlink($dir . $defaultName);
			} catch(Exeption $e){ }
			try {
				copy($dir . $name,$dir . $defaultName);
			} catch(Exeption $e){ }
		}
	}
}
?>
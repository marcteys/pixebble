<?php
	$imageFolder = "../../public/uploads/";

	if(!empty($_GET['user'])) {
		$user = $_GET['user'];

		$cdir = scandir($imageFolder); 
		$files = null;
		foreach ($cdir as $key => $filename) 
		{ 
		  if (!in_array($filename,array(".",".."))) 
		  {

		  	try {
				$withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
				$timestamp =  substr($withoutExt, -10);
				$filenameSimple = trim($withoutExt, "-".$timestamp);
				if($filenameSimple == $user)
			    	$files[] = array("name" => $withoutExt, "user" => $user, "timestamp" => $timestamp);
			} catch (Exception $e) {
				 $files[] = array("name" => "404.png", "user" => $user, "timestamp" => "error");
			}
		  }
		}

		if($files == null ) $files[] = array("name" => null, "user" => $user, "timestamp" => null);
		sort($files);
		echo json_encode ($files);
	}
?>
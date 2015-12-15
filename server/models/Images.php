<?php

class Images{

/*
    function getImages(){
        return self::makeData();
    }*/

	 function getImages(){
	 		$cdir = scandir(UPLOAD_DIR);
			$files = null;
			foreach ($cdir as $key => $filename) 
			{ 
			  if (!in_array($filename,array(".",".."))) 
			  {
					$withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
					$timestamp =  substr($withoutExt, -10);
					$user = trim($withoutExt, "-".$timestamp);
				    $files[] = array("name" => $filename,  "user"=> $user, "timestamp" => $timestamp, "uploadDir" => UPLOAD_DIR);
			  }
			}
			if($files == null)  $files[] = array("files" => null);
			sort($files);
			return $files;
	 }

	 function getImage($user) {
	 		$cdir = scandir(UPLOAD_DIR);
			$files = null;
			foreach ($cdir as $key => $filename) 
			{ 
			  if (!in_array($filename,array(".",".."))) 
			  {
					$withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
					$timestamp =  substr($withoutExt, -10);
					$filenameSimple = trim($withoutExt, "-".$timestamp);
					if($filenameSimple == $user)
				    	$files[] = array("name" => $withoutExt, "user" => $user, "timestamp" => $timestamp);
			  }
			}

			sort($files);
			return $files;
	 }

	 function postImage($data) {
	 	if (!empty($data['imgBase64']) && !empty($data['userId'])) {
			
			$id = $data['userId'];
			$img = $data['imgBase64'];
			$width = $data['width'];
			$height = $data['height'];

			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace('data:image/jpg;base64,', '', $img);
			$img = str_replace('data:image/jpeg;base64,', '', $img);
			$img = str_replace('data:image/gif;base64,', '', $img);
			$img = str_replace(' ', '+', $img);

			$imgData = base64_decode($img);

			$destination = UPLOAD_DIR . $id. '.png';
			uploadImageAs8BitPNG($imgData, $destination, $width, $height);

			$timestamp = time();
			$timeId = $id.'-' .$timestamp ;
		    $destination = UPLOAD_DIR . $timeId . '.png';
		    uploadImageAs8BitPNG($imgData, $destination, $width, $height);

		   	return array("name" => $timeId,  "user"=> $id, "timestamp" => $timestamp, "uploadDir" => UPLOAD_DIR);

		}

	 }

}
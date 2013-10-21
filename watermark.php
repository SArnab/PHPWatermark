<?php

class watermark {

	//Variables//
	var $ext;

	//Load The Image//
	public function __construct() {
		//Image Path//
		$imgPath = $_FILES['img']['tmp_name'];
		$imgName = $_FILES['img']['name'];
		$imgSize = $_FILES['img']['size'];
		//If Larger Than 2MB//
		if($imgSize > 2097152) {
			echo 'The image must be less than 2MB';
			return;
		}
		//Get The Extension//
		$this->ext = str_replace('.','',strstr($imgName, '.'));
		//Now Depending On The Extension, Create The Image Data
		switch($this->ext) {
			//Jpeg//
			case 'jpeg': $im = imagecreatefromjpeg($imgPath); break;
			//Gif//
			case 'gif': $im2 = imagecreatefromgif($imgPath); 
						$im = imagecreatetruecolor(imagesx($im2),imagesy($im2));
						imagecopymerge($im,$im2,0,0,0,0,imagesx($im2),imagesy($im2),100);
						imagedestroy($im2);
			break;
			//Png//
			case 'png': $im = imagecreatefrompng($imgPath); break;
			//Jpg//
			case 'jpg': $im = imagecreatefromjpeg($imgPath); break;
			//Return False
			default: $im = false; break;
		}
		//If The Image Is False//
		if($im == FALSE) {
			echo 'Invalid File Type';
			return;
		}
		// Create some colors
		$white = imagecolorallocate($im, 255, 255, 255);
		$grey = imagecolorallocate($im, 128, 128, 128);
		$black = imagecolorallocatealpha($im, 200, 200, 200,110);
		
		// The text to draw
		$text = (empty($_POST['text'])) ? 'SAMPLE' : $_POST['text'];
		// Replace path by your own font path
		$font = 'arial.ttf';
		
		//Get The Size//
		$box = imagettfbbox(72,45,$font,$text);
		
		$h = intval(abs(abs($box[5]) - abs($box[1])));
		$w = intval(abs(abs($box[3]) - abs($box[7])));
		
		//Get Rows//
		$rows = ceil(imagesy($im) / $h);
		$columns = ceil(imagesx($im) / $w);
		
		for($i = 0; $i <= $rows; $i++) {
		
			for($c = 0; $c <= $columns; $c++) {
				//Render Each Columns//
				imagettftext($im,50,45,45 + ($c * $w), 100 + ($i * $h),$black,$font,$text);
			}
		
		}
		
		//Rand Number//
		$rand = substr(md5(time() * rand()),0,10);
	
		//Save Images//
		imagepng($im,'results/'.$rand.'.png');
		
		//Print Link To Image//
		echo '<img src="results/'.$rand.'.png" />';
		return;

	}
}
?>
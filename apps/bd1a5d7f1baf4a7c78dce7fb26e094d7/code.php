<?php
if(isset($_POST['file_path']) && file_exists($_SETTINGS['home_path'].urldecode($_POST['file_path'])))
{
	function base64_image($img)
	{
		$imageSize = getimagesize($img);
		$imageData = base64_encode(file_get_contents($img));
		$imageHTML = "<img style=\"max-width:930px;margin-top:10px;height:auto;\" src='data:{$imageSize['mime']};base64,{$imageData}' {$imageSize[3]} />";
		return $imageHTML;
	}

	$html = '<center>'.base64_image($_SETTINGS['home_path'].urldecode($_POST['file_path'])).'</center>';
}else
{
	$html = '<center style="padding-top:125px;">Такого изображения несуществует</center>';
}

return array('html' => $html, 'title' => 'Обозреватель картинок');
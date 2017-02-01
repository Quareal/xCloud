<?php

$_way = str_replace('../', '', urldecode($_GET['file']));
$file_d = $_SETTINGS['home_path'].(($_way[0] == '/') ? $_way : '/'.$_way);
$file_e = $_SETTINGS['home_path'].(($_GET['file'][0] == '/') ? $_GET['file'] : '/'.$_GET['file']);
$file_f = (file_exists($file_d)) ? $file_d : $file_e;
$file_d = (is_dir($file_d)) ? $file_d : $file_e;

if(is_file($file_f)) 
{
	if(isset($_GET['download']))
	{
		if(ob_get_level()) 
			ob_end_clean();
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . basename($file_f));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file_f));
		readfile($file_f);
		exit;
	}else
	{
		$array = Project::about_doc($file_f);
		$tmp->set('title', 'файле '.basename($file_f));
		$tmp->set('name', basename($file_f));
		$tmp->set('way', str_replace(basename($file_f), '', $file_f));
		$tmp->set('size', $array['size']);
		$tmp->set('type', 1);
		$tmp->set('time', $array['time']);
		$tmp->set('rules', $array['rules']);
		$tmp->set('url_dwnld', Project::url().'/?path=get&file='.$_GET['file'].'&download');
		$tmp->display('fileinfo.tmp');
	}
}elseif(is_dir($file_d))
{
	$array = Project::about_doc($file_d);
	$name = explode('/', $file_d);
	$tmp->set('title', 'каталоге '.basename($file_d));
	$tmp->set('name', $name[count($name) - 1]);
	$tmp->set('way', $file_d);
	$tmp->set('size', $array['empty']);
	$tmp->set('type', 2);
	$tmp->set('time', $array['time']);
	$tmp->set('rules', $array['rules']);
	$tmp->set('url_dwnld', Project::url().'/?path=get&file='.$_GET['file'].'&download');
	$tmp->display('fileinfo.tmp');
}

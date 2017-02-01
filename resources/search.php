<?php
$html = '
<input type="text" id="search_block" placeholder="Введите имя объекта ...">
<div id="search_rezult"><span id="inf">Нет результатов</span></div>';

$dir = $_SETTINGS['home_path'].'/*{*.txt, */}';  
foreach(glob($dir, GLOB_BRACE) as $file)  
{ 
    $html .= "filename: $file : filetype: " . filetype($file) . "<br>";  
} 

return array(
	'content' 	=> $html, 
	'title' 	=> 'xCloud: Поиск', 
	'app' 		=> false, 
	'redirect' 	=> false, 
	'error' 	=> '', 
	'css' 		=> '',
	'menu'		=> array('home' => false, 'notice' => false, 'search' => true)
);
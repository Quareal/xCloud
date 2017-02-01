<?php
$html = '';

if(isset($_COOKIE['miniapp']) && !empty($_COOKIE['miniapp']))
{
	$array = json_decode($_COOKIE['miniapp']);
	$tmp->set('content', $array->content);
	$html .= $tmp->display('miniapp.tmp', true);
}

$q = mysql_query("SELECT * FROM `notices`");
if(mysql_num_rows($q) > 0)
{

}else
{
	$html .= '<h2 style="text-align:center;padding-top:70px;color:rgb(215, 215, 215);">Уведомлений нет</h2>';
}

return array(
	'content' 	=> $html, 
	'title' 	=> 'xCloud: Уведомления', 
	'app' 		=> false, 
	'redirect' 	=> false, 
	'error' 	=> '', 
	'css' 		=> '',
	'menu'		=> array('home' => false, 'notice' => true, 'search' => false)
);
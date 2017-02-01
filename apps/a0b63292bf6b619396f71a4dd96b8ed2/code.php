<?php
$APP['tmp']->set('img', 		$_USER['avatar']);
$APP['tmp']->set('username', 	$_USER['login']);
$APP['tmp']->set('app_url', 	$APP['dir']);

if($_USER['root'] == 1)
{
	$APP['tmp']->set('user_info', 	'Аккаунт администратора');
}else
{
	if(count($_USER['rules']) > 0)
	{
		$APP['tmp']->set('user_info', 	'Персональный аккаунт с ограничениями');
	}else
	{
		$APP['tmp']->set('user_info', 	'Персональный аккаунт без ограничениями');
	}
}

return array(
	'html' 	=> $APP['tmp']->display('html.tmp', true),
	'css'	=> $APP['tmp']->display('css.css', 	true),
	'title' => 'Редактор аккаунта'
);
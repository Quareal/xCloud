<?php
# Подключение библиотеки
include("./resources/project.class.php");

# Доступные ссылки
$path = array(
	'home'		=> 	'./resources/desktop.php',
	'notice'	=>	'./resources/notice.php',
	'search'	=>	'./resources/search.php',
	'install'	=>	'./resources/install.php',
	'password'	=>	'./resources/password.php',
	'get'		=> 	'./resources/getfile.php',
	'info'		=>	'./info.php',
	'status'	=> 	'./status.php'
);

# Включение шаблонизатора
$tmp = new Temp(TMP_PATH);

# Проверка на установку
if(!Project::info('install') && $_GET['path'] != 'install')
{
	header('Location: /?path=install');
	exit;
}

# Системные переменные
$_USER 		= Project::user($_COOKIE['id']);
$_SETTINGS	= Project::get_config();

# Вывод контента
if(isset($_GET['content']) && !empty($_COOKIE['id']))
	exit(json_encode(include($path[$_POST['path']])));

# Переадресация при неверном url
if(empty($path[$_GET['path']]))
{
	header('Location: /?path=home');
	exit;
}

# Вывод шаблона авторизовани или нет
if(isset($_COOKIE['id']) && !empty($_COOKIE['id']))
{
	if(isset($_GET['path']) && $_GET['path'] == 'get')
	{
		include($path[$_GET['path']]);
		exit;
	}else
	{
		# Обнуляем данные фонового приложения
		setcookie('miniapp', '');

		# Генерация гл. страницы	
		$arr = mysql_fetch_array(mysql_query("SELECT `id` FROM `apps` WHERE `alias`='user_editor'"));

		if($_USER['mobile'])
		{
			$tmp->set('edt_url', 	'/?path=home&app='.$arr['id']);
			$tmp->display('home_mobile.tmp');
		}else
		{
			$tmp->set('username', 	$_USER['login']);
			$tmp->set('avatar', 	$_USER['avatar']);
			$tmp->set('edt_url', 	'/?path=home&app='.$arr['id']);
			$tmp->display('home.tmp');
		}
	}
}else
{
	# Авторизация
	if(isset($_POST['login']))
	{
		$username = Project::escape($_POST['username']);
		$password = Project::password($_POST['password']);

		$data = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login`='{$username}' AND `password`='{$password}'"));
		if(!empty($data['id']) && !empty($data['root']))
		{
			setcookie('id', $data['id']);
			header('Location: /?path=home');
			exit;
		}
	}

	$tmp->display('login.tmp');
}
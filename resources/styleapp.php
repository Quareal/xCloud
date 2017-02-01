<?php
# Подключение библиотеки
include("./project.class.php");

# Запросы к базе данных
$q = mysql_query("SELECT `id` FROM `apps`");
$count = mysql_num_rows($q); $css = '';

# Выводим список установленных приложений
if($count > 0)
	while($rows = mysql_fetch_array($q))
	{
		// Покдлючаем библиотеку приложения и получаем стили
		$APP = Project::app_data($rows['id']);
		$content = include(ROOT_PATH.$APP['dir'].'/code.php');
		if(isset($content['css']))
			$css .= $content['css'];
	}

// Выводим все стили 
echo $css;
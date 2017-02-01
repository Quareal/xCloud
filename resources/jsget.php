<?php
# Подключение библиотеки
include("./project.class.php");

# Запросы к базе данных
$q = mysql_query("SELECT * FROM `apps`");
$count = mysql_num_rows($q);

# Стартовые переменные для создания рамок исполнения js кода
$js = "var lcl_add = location.href.split('?');\nvar app_id = getvalue(location.href);\nvar cookie = $.cookie('miniapp');\nvar cookie_mini = jQuery.parseJSON(cookie);\n";

# Выводим список установленных приложений
if($count > 0)
	while($rows = mysql_fetch_array($q))
	{
		// Покдлючаем библиотеку приложения и получаем js
		$APP = Project::app_data($rows['id']);
		$content = include(ROOT_PATH.$APP['dir'].'/code.php');
		if(isset($content['js']) && $rows['type'] == 0)
			$js .= "if(app_id['app'] == {$rows['id']})\n{\n\t".$content['js']."\n}\n\n";
		elseif(isset($content['js']) && $rows['type'] == 2)
			$js .= "if(lcl_add[1] == 'path=notice' && cookie_mini.id == {$rows['id']})\n{\n\t".$content['js']."\n}\n\n";
	}

// Выводим все стили 
echo $js;
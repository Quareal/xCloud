<?php
if(isset($_POST['app']) && !empty($_POST['app']))
{
	# Извлекаем данные приложения
	$APP = Project::app_data($_POST['app']);
	$error = true; $_app = false; $css = '';

	if($APP['isset_dir'] && $APP['isset_code'] && $APP['isset_sql'])
	{
		# Данные для генерации
		$error 	 = false; $_app = true; 
		$APP['history'] = '/?'.urldecode($_POST['history']); 
		$content = include(ROOT_PATH.$APP['dir'].'/code.php');

		# Генерация щаблона в переменную $html
		if($APP['type'] == 2)
		{
			setcookie('miniapp', json_encode(array('id' => $_POST['app'], 'content' => $content['control'])));
			$min_app = true;
			$html = $content['daemon'];
		}else
		{
			$css = $content['css'];
			$min_app = false;
			$tmp->set('title', 			$content['title']);
			$tmp->set('content',		$content['html']);
			$tmp->set('history_back',	$_POST['history_url']);
			$html = $tmp->display('window.tmp', true);
		}
	}else
	{
		# Генерация контейнера с ошибкой
		$tmp->set('title', 'Приложение повреждено');
		$html = $tmp->display('error_app.tmp', true);
	}
}else
{
	# Извлечение данных
	$q = mysql_query("SELECT * FROM `apps` WHERE `type`='0'");
	$html = ''; $_app = false; $error = false; $css = '';

	# Генерация списка приложений
	while($rows = mysql_fetch_array($q))
	{
		$data = Project::xml_app($rows['id']);
		$html .= "
		<li id=\"app_li\">
			<a href=\"/?path=home&app={$rows['id']}\" id=\"block_app\">
				<div id=\"logo_app\">
					<img src=\"/{$rows['dir']}/ico.png\">
				</div>
				<div id=\"title_app\">
					<span>{$data->NAME}</span>
				</div>
			</a>
		</li>";
	}

	# Отключаем размер mini
	$min_app = false;
}

# Возвращаем контент рабочего стола
return array(
	'content' 	=> $html, 
	'title' 	=> 'xCloud: Главная страница', 
	'app' 		=> $_app, 
	'redirect' 	=> false, 
	'error' 	=> $error, 
	'css' 		=> $css,
	'mini_app'	=> $min_app,
	'menu'		=> array('home' => true, 'notice' => false, 'search' => false)
);
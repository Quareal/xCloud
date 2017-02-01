<?php
/*
	Приложение:		Настройки xCloud
	Дата создания:	9.02.16
*/

	$APP['tmp']->set('url', '/?path='.$_POST['path'].'&app='.$_POST['app']);
	if(empty($_POST['page']) || $_POST['page'] == '1')
	{
		$APP['tmp']->set('content', '
		<div id="menu_bl">
			<div>
				<a href="<?=$this->url;?>&page=0">Обновление системы</a>
				<a href="<?=$this->url;?>&page=0">Сброс настроек</a>
			</div>
			<div>
				<a href="<?=$this->url;?>&page=0">Дата и время</a>
			</div>
			<div>
				<a href="<?=$this->url;?>&page=0">Сортировка уведомлений</a>
				<a href="<?=$this->url;?>&page=0">Сортировка поиска</a>
			</div>
			<div>
				<a href="<?=$this->url;?>&page=0">Таблица файловых ассоциаций</a>
				<a href="<?=$this->url;?>&page=0">Таблица автозапуска скриптов</a>
				<a href="<?=$this->url;?>&page=0">Настройка окон</a>
			</div>
			<div>
				<a href="<?=$this->url;?>&page=0">Перезагрузить устройство</a>
			</div>
			<hr>
			<center style="color:#C3C3C3;">
				<i>Ознакомиться с материалом разработчика можно перейдя по ссылке 
				<a id="url" target="_blank" href="https://projects.quareal.ru">https://projects.quareal.ru</a></i>
			</center>
		</div>');
	}

	if($_POST['page'] == '2')
	{
		$q = mysql_query("SELECT * FROM account");
		if(mysql_num_rows($q) > 0)
		{
			$APP['tmp']->set('content', 'y');

		}else
		{
			$APP['tmp']->set('content', '
			<div id="login_block">
				<div>
					<span>
						<a id="url" target="_blank" href="https://projects.quareal.ru">Забыли пароль?</a>
					</span>
					<h3>Авторизация</h3>
					<input type="text" placeholder="Логин от аккаунта Quareal" id="inp_1">
					<input type="password" placeholder="Пароль от аккаунта" id="inp_2">
					<hr style="margin-top:11px;">
					<a href="#" id="login_bt">Войти</a>
				</div>
			</div>');
		}
	}

	if($_POST['page'] == '6')
	{
		$APP['tmp']->set('content', '
		<div style="padding:10px;">
			<fieldset>
				<legend>Память системы</legend>
				<div id="ctnt">
					sdfsdfsdf
				</div>
			</fieldset>
		</div>');
	}


return array('html' => $APP['tmp']->display('html.tmp', true), 'css' => $APP['tmp']->display('app.css', true), 'title' => 'Настройки xCloud');
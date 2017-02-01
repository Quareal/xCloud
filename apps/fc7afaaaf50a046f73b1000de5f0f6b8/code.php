<?php
$name = explode('/', Project::escape(urldecode($_POST['file_path'])));
$html = '<div style="width:100%;"><div style="background:rgba(0, 0, 0, 0.04);padding:20px;" class="marquee"><span>'.$name[count($name) - 1].'</span></div>
<div>
	<input oninput="document.getElementById(\'player_in\').volume = document.getElementById(\'range\').value * 0.01" value="100" id="range" type="range">
</div>
<table id="music_bt">
	<tr>
		<td id="td" onclick="close_miniapp();">&#10060;</td>
		<td id="td" class="sdfsdfsdffsd323">&#9654;</td>
		<td >ssss</td>
	</tr>
</table>
</div>';
return array(
	'control' 	=> $html,
	'daemon'	=> '<audio autoplay="autoplay" id="player_in" src="'.Project::url().'/?path=get&file='.urlencode($_POST['file_path']).'&download"></audio>',
	'css' 		=> $APP['tmp']->display('app.css', 	true)
);
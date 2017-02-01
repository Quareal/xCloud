<?php
# Конфигурация
include($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');

# Подключение к БД
$db = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
mysql_select_db(DB_DATABASE, $db) or die(mysql_errno($db).": ".mysql_error($db));


class Project
{
	public static function info($tag='')
	{
		//$srv_cfg = json_decode(file_get_contents("http://projects.quareal.ru/xcloud/config.php"));
		$data_db = mysql_fetch_array(mysql_query("SELECT `login` FROM `users` WHERE `root`='1'"));
		//$sys_arr = mysql_fetch_array(mysql_query("SELECT * FROM array WHERE name='VERSION'"));

		$arr['install']	= (count($data_db) > 0) ? true : false;
		//$arr['update']	= ($xml->version == $sys_arr['value']) ? false : true;

		return (empty($tag)) ? $arr : $arr[$tag];
	}

	public static function scan_devices()
	{
		$array 		= self::scan_dir('/media/root/');
		$devices 	= array();

		for($i=1;$i<count($array);$i++)
		{
			$procent =  substr((disk_free_space('/media/root/'.$array['dirs'][$i-1]['name']) / disk_total_space('/media/root/'.$array['dirs'][$i-1]['name'])) * 100, 0, 5);
			$devices[$i] = array(
				'name' 			=> $array['dirs'][$i-1]['name'],
				'path'			=> '/media/root/'.$array['dirs'][$i-1]['name'].'/',
				'free_space'	=> self::filesize_get(disk_free_space('/media/root/'.$array['dirs'][$i-1]['name']), false),
				'total_space'	=> self::filesize_get(disk_total_space('/media/root/'.$array['dirs'][$i-1]['name']), false),
				'procent'		=> $procent
			);
		}

		$procent = substr(disk_total_space('/') / 100 * disk_free_space('/'), 0, 5);
		$devices[0] = array(
			'name' 			=> 'System Disk',
			'path'			=> '/',
			'free_space' 	=> self::filesize_get(disk_free_space('/'), false),
			'total_space'	=> self::filesize_get(disk_total_space('/'), false),
			'procent'		=> $procent
		);

		return $devices;
	}

	public static function scan_dir($path)
	{
		$data 	= scandir($path);
		$dirs 	= array(); $d = 0;
		$files 	= array(); $f = 0;
		
		for($i=0;$i<count($data);$i++)
		{
			if($data[$i] != "." && $data[$i] != ".." && $data[$i][0] != ".")
			{
				if(is_dir($path.$data[$i]))
				{
					$count 		= scandir($path.$data[$i]);
					$empt_ct 	= 0;

					for($l=0;$l<count($count);$l++)
						if($count[$l] != "." && $count[$l] != "..")
							$empt_ct++;

					$dirs[$d] = array(
						'name' => $data[$i],
						'size' => '--',
						'time' => date("d F Y", filemtime($path.$data[$i])),
						'rules' => substr(sprintf('%o', fileperms($path.$data[$i])), -4),
						'empty' => $empt_ct
					);

					$d++;
				}else
				{
					$type = explode('.', $data[$i]);
					$files[$f] = array(
						'name' => $data[$i], 
						'type' => $type[count($type)-1],
						'size' => self::filesize_get($path.$data[$i]), 
						'time' => date("d F Y", filemtime($path.$data[$i]))
					);

					$f++;
				}
			}
		}
		
		return array('dirs' => $dirs, 'files' => $files);
	}

	public static function about_doc($way = '')
	{
		if(empty($way))
			return array('type' => 0);
		if(is_dir($way))
		{
			$count 		= scandir($way);
			$empt_ct 	= 0;

			for($l=0;$l<count($count);$l++)
				if($count[$l] != "." && $count[$l] != "..")
					$empt_ct++;

			return array(
				'type' => 1, 
				'size' => '--', 
				'time' => date("d F Y", filemtime($way)),
				'rules' => substr(sprintf('%o', fileperms($way)), -4),
				'empty' => $empt_ct
			);
		}elseif(is_file($way))
		{
			return array(
				'type' => 2,
				'size' => self::filesize_get($way),
				'rules' => substr(sprintf('%o', fileperms($way)), -4),
				'time' => date("d F Y", filemtime($way))
			);
		}else
		{
			return array('type' => 3);
		}
	}

	private static function filesize_get($file, $file_path=true)
	{
		if($file_path)
		{
			if(!file_exists($file)) "0 Байт";
	  		$filesize = filesize($file);
		}else
		{
			$filesize = $file;
		}

	   	if($filesize > 1024)
	   	{
			$filesize = ($filesize/1024);
		   	if($filesize > 1024)
		   	{
				$filesize = ($filesize/1024);
			   	if($filesize > 1024)
			   	{
					$filesize = ($filesize/1024);
					$filesize = round($filesize, 1);
					return $filesize." ГБ";   

			   	}else
			   	{
					$filesize = round($filesize, 1);
				   	return $filesize." MБ";   
			   	}  
			}else
		   	{
				$filesize = round($filesize, 1);
				return $filesize." КБ";   
		   	}
		}else
	   	{
			$filesize = round($filesize, 1);
		   	return $filesize." Байт";   
	   	}
	}

	private static function is_mobile()
	{
		$mobiles = array(
			'iPhone', 'iPod', 'iPad', 
			'Android', 'webOS', 'BlackBerry', 
			'Mobile', 'Symbian', 'Opera M', 
			'HTC_', 'Fennec/', 'WindowsPhone', 
			'WP7', 'WP8', 'WP10'
		);

		foreach($mobiles as $mobile)
		{
			if(preg_match("#".$mobile."#i", $_SERVER['HTTP_USER_AGENT']))
			{
				return true;
			}
		}

		return false;
	}

	public static function user($id='')
	{
		if(!empty($id))
		{
			$data = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id`='{$id}'"));
			return array(
				'rules' 	=> json_decode($data['rules']), 
				'root' 		=> $data['root'], 
				'login' 	=> $data['login'],
				'avatar'	=> $data['avatar'],
				'mobile'	=> self::is_mobile()
			);
		}else
		{
			return false;
		}
	}

	public static function xml_app($id)
	{
		$q = mysql_fetch_array(mysql_query("SELECT * FROM `apps` WHERE `id`='{$id}'"));
		$file = './'.$q['dir'].'/config.xml';
		if(file_exists($file))
		{
			$xml = simplexml_load_file($file);
			return $xml->INTERNALS[0];
		}
	}

	public static function app_data($id)
	{
		$q = mysql_query("SELECT * FROM `apps` WHERE `id`='{$id}'");
		$arr = array();

		if(mysql_num_rows($q) == 1)
		{
			$data = mysql_fetch_array($q);

			$arr['dir'] 		= '/'.$data['dir'];
			$arr['tmp'] 		= new Temp($arr['dir'].'/');
			$arr['sys']			= ($data['system'] == 1) ? true : false;
			$arr['isset_dir'] 	= is_dir(ROOT_PATH.$arr['dir']);
			$arr['isset_code'] 	= file_exists(ROOT_PATH.$arr['dir'].'/code.php');
			$arr['isset_sql']	= true;
			$arr['url_app']		= '/?path=home&app='.$id;
			$arr['association']	= array();
			$arr['type']		= $data['type'];

			$astn = mysql_query("SELECT * FROM `association`"); 
			while($rows = mysql_fetch_array($astn))
			{
				$arr['association'][$rows['type']] = $rows['app_id'];
			}

		}else
		{
			$arr['isset_sql'] = false;
		}

		return $arr;
	}

	public static function password($data)
	{
		return md5(strrev(sha1($data)."Quareal_xCloud_Project".sha1($data)));
	}

	public static function get_config()
	{
		$data = mysql_fetch_array(mysql_query("SELECT * FROM `settings`"));
		return (array)json_decode($data['json_config']);
	}

	public static function escape($string)
	{
		$string = str_replace( "&#032;"				, " "			  , $string );
        $string = str_replace( "&"					, "&amp;"         , $string );
        $string = str_replace( "<!--"				, "&#60;&#33;--"  , $string );
        $string = str_replace( "-->"				, "--&#62;"       , $string );
        $string = preg_replace( "/<script/i"		, "&#60;script"   , $string );
        $string = str_replace( ">"					, "&gt;"          , $string );
        $string = str_replace( "<"					, "&lt;"          , $string );
        $string = str_replace( "\""					, "&quot;"        , $string );
		$string = str_replace( "\&quot;"			, "&quot;"        , $string );
		$string = str_replace( "\'"					, "&#39;"         , $string );
        $string = preg_replace( "/\n/"				, "<br />"        , $string ); 
        $string = preg_replace( "/\\\$/"			, "&#036;"        , $string );
        $string = preg_replace( "/\r/"				, ""              , $string ); 
        $string = str_replace( "!"					, "&#33;"         , $string );
        $string = str_replace( "'"					, "&#39;"         , $string ); 
        $string = preg_replace("/&amp;#([0-9]+);/s"	, "&#\\1;"		  , $string );	

		if(get_magic_quotes_runtime()) $string = stripslashes($string);
		return $string;
	}

	public static function is_image($path) 
	{
		$is = @getimagesize($path);
		if ( !$is ) return false;
		elseif (!in_array($is[2], array(1,2,3))) return false;
		else return true;
	}

	public static function url()
	{
		$type = ($_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
		return $type.$_SERVER['HTTP_HOST'];
	}
/*
	private function key_generator()
	{
		$arr = array(
			'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','r',
			's','t','u','v','x','y','z','1','2','3','4','5','6','7','8','9','0'
		);

		$hash = '';
		$number = rand(5, 15);

		for($i=0;$i<$number;$i++)
		{
			$hash .= $arr[rand(0, count($arr)-1)];
		}

	    return md5($hash);
	}*/
}
# Шаблонизатор

class Temp
{
	private $_path;
	private $_template;
	private $_var = array();
	# Пусть к директории с шаблонами от корня домена ($_SERVER['DOCUMENT_ROOT'])
	public function __construct($path = '')
	{
		$this->_path = $_SERVER['DOCUMENT_ROOT'] . $path;
	}
	# Присваивает значение переменной
	public function set($name, $value)
	{
		$this->_var[$name] = $value;
	}
	# Присваивает значение переменной массива
	public function set_cycle($name, $value)
	{
		$this->_var[$name] .= $value;
	}
	# Получает значение переменной
	public function __get($name)
	{
		if (isset($this->_var[$name])) return $this->_var[$name];
		return '';
	}
	# Собирает шаблон и выводит его на экран
	public function display($template, $return = false)
	{
		$this->_template = $this->_path . $template;
		if (!file_exists($this->_template)) die('Шаблона ' . $this->_template . ' не существует!');

		ob_start();
		include($this->_template);

		if($return)
		{
			return ob_get_clean();
		}else
		{
			echo ob_get_clean();
		}
	}
	private function _strip($data)
	{
		$lit = array("\\t", "\\n", "\\n\\r", "\\r\\n", "  ");
		$sp = array('', '', '', '', '');
		return str_replace($lit, $sp, $data);
	}
	# Защита от XSS
	public function xss($data)
	{
		if (is_array($data)) 
		{
			$escaped = array();
			foreach ($data as $key => $value) 
			{
				$escaped[$key] = $this->xss($value);
			}
			return $escaped;
		}
		return htmlspecialchars($data, ENT_QUOTES);
	}
}
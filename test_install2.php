<?php /*000|0*/

/*Кнопка или ярлык для запуска программы*/
$keyProg="test";

/*Тело пограммы*/
$program=<<<DEC
class test{
	function start(){}
	function view(){echo 'test';}
}//class test
DEC;

function home(){
	echo "Инстолятор программ для <b>PhpWav4</b>:<br>";
	if(file_exists('PhpWav4.php')){
		echo '[<a href="?go=install" style="color:#99f;">Установить</a>]';
	}else{
		echo "<span style='color:red;'>Нет файла <b style='color:#000;'>PhpWav4.php</b>!</span>";
	}
	echo <<<NEC
[<a href="/" style="color:#f00;">Выход</a>]
<br>v2.0
NEC;
}//start()

function install(){
	global $keyProg,$program,$nameProg;
	$t=""; $k=true;
	foreach(file('PhpWav4.php') as $v){
		if(empty($e)){if(substr($v,8,5)=='0000|'){$e="install";}else{$e="error1"; break;}}//error
		if(substr($v,0,13)=="/*|programs*/"){
			$t.=$v.chr(10)."/*>|$keyProg*/".chr(10).$program.chr(10)."/*<|$keyProg*/".chr(10);
			continue;
		}
		if(substr($v,0,13)=="/*|keysProg*/"){
			if(strpos($v,'"'.$keyProg.'"') or strpos($v,"'".$keyProg."'")){$e="error2"; break;}//error
			$t.=substr($v,0,strpos($v,'(')+1).'"'.$keyProg.'"';
			if(substr($v,strpos($v,'(')+1,1)!=')'){$t.=',';}
			$t.=substr($v,strpos($v,"(")+1);
			continue;
		}
		$t.=$v;
	}/*foreach*/
	switch($e){
		case "install":
			$f=fopen('PhpWav4.php','w'); fwrite($f,$t); fclose($f);
			echo "Установлено!";
			break;
		case "error1":
			echo "Не совпадает подписи файла PhpWav4.php !";
			break;
		case "error2":
			echo "Программа уже установлена!";
			break;
	}
	echo " [<a style='color:#99f;' href='?go=home'>Назад</a>]";
}

if(empty($_GET['go'])){$go="home";}else{$go=$_GET['go'];}
switch($go){
	case "home": home(); break;
	case "install": install(); break;
}



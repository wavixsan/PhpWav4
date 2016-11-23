<?php /*0000|*/
ini_set('display_errors',1);
error_reporting(E_ALL);

/*|keysProg*/ $keysProgPW4=array('PhpWav4_v2','file_manager','exploer','PhpWav4','DeletPrograms','PackNEC','InstallPrograms');
 
/*|programs*/

/*>|PhpWav4_v2*/
class PhpWav4_v2{
	var $name="PhpWav4 v2";
	function boot(){
		global $keysProgPW4;
		if(session_id()==false){session_start();}
		$view=false;

		if(!empty($_SESSION['keyPW4']) and !empty($_GET['keyPW4'])){
			if($_SESSION['keyPW4']!=$_GET['keyPW4']){
				$_SESSION['keyPW4']=$_GET['keyPW4'];
			}
		}else if(isset($_GET['keyPW4'])){
			$_SESSION['keyPW4']=$_GET['keyPW4'];
		}//get

		if(!empty($_SESSION['keyPW4'])){switch($_SESSION['keyPW4']){
			case "reset": $_SESSION['keyPW4']=bootPW4(); header('location:'); break;
			case 'exit': header('location:/'); break;
			default:
				if(in_array($_SESSION['keyPW4'],$keysProgPW4)){
					$o=new $_SESSION['keyPW4'];
					if(method_exists($o,'start')){ $o->start(); $view=true; }
				}
		}}//обраьотка session*/

		foreach($keysProgPW4 as $v){
			echo "[<a href='?keyPW4=$v'>$v</a>]";
		}
		echo "<hr>";
		if($view==true){$o->view();}else{echo 'home PhpWav4_v2';}

	}//boot() -
}//end class PhpWav4_v2;
/*<|PhpWav4_v2*/

/*>|file_manager*/
class file_manager{
	function start(){}//start() - Стартовая Функция для обработки Функционала.
	function view(){
		echo 'class test2';
		echo '<div id="leftFM"></div>';
		echo '<div id="rightFM"></div>';
	}//view() - Функция для вивода содержмого на экран.
}//end class file_manager;
/*<|file_manager*/

/*>|exploer*/
class exploer{
	var $info="Проводник по файловой системе.";
	var $name="Проводник";
	var $vers="v1.07";
	var $desc=<<<NEC
16.11.15 - v1.00 - Выпуск нового проводника.<br>
07.12.15 - v1.01 - Исправлен баг корневого пути сервера (доб. функция: \"endGo();\") .<br>
07.12.15 - v1.02 - Исправлен баг с кодировкой в ошибках (прописан meta charset) .<br>
24.01.16 - v1.03 - Переделан meta charset через константу и мелкие исправления в коде.<br>
27.01.16 - v1.04 - Переделан метод открытия директив через POST .<br>
01.02.16 - v1.05 - Исправление стилей для общей совместимости . <br>
02.02.16 - v1.06 - исправлен переход по директории и добавлена проверка директории + фун: |reset .<br>
17.11.16 - v1.07 - Переделан под PhpWav4 + исправление стилей.
NEC;

	function newGo(){
		$a=$_SERVER["SCRIPT_FILENAME"];
		for($i=0; $i<strlen($a); $i++){if(substr($a,$i,1)=="/"){$b=$i;}}
		return substr($a,0,$b+1);
	}//goNaw() - создание нового пути - первый старт.
	
	function nam(){
		$a=$_SERVER["SCRIPT_NAME"]; $b="";
		for($i=0; $i<strlen($a); $i++){if(substr($a,$i,1)=="/"){$b="";}else{$b.=substr($a,$i,1);}}
		return $b;
	}//nam() - имя текущего файла или файл который вызывает эту функцию.
	
	function endGo(){
		$s=$_SERVER["DOCUMENT_ROOT"];
		if(substr($s,strlen($s)-1,1)=="/"){return $s;}else{return $s."/";}
	}//endGo() - проверка DOCUMENT_ROOT на последний "/". 
	
	function session(){
		if(empty($_SESSION["exploer_go"])){$go=$_SESSION["exploer_go"]=$this->newGo();}
			else{$go=$_SESSION["exploer_go"];} 
		if(isset($_POST["go"])){
			if($_POST["go"]==".."){if($go!=$this->endGo()){
				for($i=0; $i<strlen($_SESSION["exploer_go"])-1; $i++){if(substr($_SESSION["exploer_go"],$i,1)=="/"){$b=$i;}}
				$go=substr($_SESSION["exploer_go"],0,$b+1);
			}}else{$go=$_SESSION["exploer_go"].$_POST["go"]."/";}
			if(file_exists($go)){$_SESSION["exploer_go"]=$go;}else{$go=$_SESSION["exploer_go"];}
			header("location:".$this->nam()); // - исправить
		}
		return $go;
	}//session(); - управление сессией и обработка пути директорий.
	
	function goFile($go){
		$n=$_SERVER["DOCUMENT_ROOT"]; if(substr($n,strlen($n)-1,1)=="/"){$a=strlen($n)-1;}else{$a=strlen($n);}
		return "http://".$_SERVER["HTTP_HOST"].substr($go,$a,strlen($go)-$a);
	}//goFile(); - обработка пути для запуска файлов.
	
	function reset(){
		if(session_id()==false){session_start();}
		unset($_SESSION["exploer_go"]);
		unset($_SESSION["exploer_file"]);
	}
	
	function start($s=false){
		if(session_id()==false){session_start();}//-проверяет запущена ли сессия
		switch ($s){
			case false: break;
			case "|file": break; 
			case "|reset" : $this->reset(); break;
			default:exit("Неизвестная опция: <b>$s</b> !");
		}//switch
		$this->go=$this->session();//<---!
	}//start() - Стартовая Функция.
	
	function view($s=false){
		$go=$this->go;//<---!
		$sdir=scandir($go);
		for($i=0; $i<count($sdir); $i++){
			if(is_dir($go.$sdir[$i])){if($sdir[$i]!="." and $sdir[$i]!=".."){$dir[]=$sdir[$i];}}
			if(is_file($go.$sdir[$i])){$file[]=$sdir[$i];}
		}
	
		if($s!="|file"){$goFile=$this->goFile($go);}// - путь для открытия файла
		if($s=="|file"){
			$goFile=$this->nam()."?file="; 
			if(isset($_GET["file"])){$_SESSION["exploer_file"]=$go.$_GET["file"]; header("location:".$this->nam());} 
		}// - путь к файлу через файловую систему для выбора

		echo "<style>
#start span,td,.ex_key{font:14px arial;}
span{background:#333; color:gold; border:1px solid #eee; padding:1px 3px;}
.ex_key{background:none; border:none; padding:0px; text-align:left;}
.ex_key:hover{border:0px;cursor:pointer;}
.ex_key{display:block; color:blue; width:100%; text-decoration:none; outline:none;}
table{border:solid 1px #000; margin-top:3px;}
tr:nth-child(odd){background:#eee;}
tr:hover{background:#ddd;}
#ex_tab{background:#fff;}
		</style>";
		echo "<div id=start>";
		echo "<span>".$this->goFile($go)."</span>"; 
		echo "<form method=post><table id=ex_tab>";
		 
		if($go!=$this->endGo()){
			echo "<tr><td><input class=ex_key type=submit name=go value=..></td><td>dir</td></tr>";
		}// - назад
		
		if(isset($dir)){for($i=0; $i<count($dir); $i++){
			echo "<tr><td><input class=ex_key type=submit name=go value=".$dir[$i]."></td><td>dir</td></tr>";
		}}// - папки
		
		if(isset($file)){for($i=0; $i<count($file); $i++){
			echo "<tr><td><a class=ex_key href=\"".$goFile.$file[$i]."\">$file[$i]</a></td><td>file</td></tr>";
		}}// - файлы
		
		//echo "<tr><td><input type=submit name=go value=|reset></td><td>reset</td></tr>";//- для отладки ???
		echo "</table></form>";
		echo "</div>";
	}//view() - Функция для вивода содержмого на экран
}//end class exploer;
/*<|exploer*/

/*>|PhpWav4*/
class PhpWav4{
	var $name="PhpWav4";
	var $vers="1.01";
	var $desc=<<<NEC
17.11.16 v1.01 - Добавлена обработка info в атрибут title для кнопок программ.
NEC;

function start(){}

function boot(){
$view=true;
session_start();

if(!empty($_POST['keyPW4'])){
	switch($_POST['keyPW4']){
		case "update": break;
		case "reset": $_SESSION['keyPW4']=bootPW4(); header('location:'); break;
		case "exit": header('location:/'); break;
		default : $_SESSION['keyPW4']=$_POST['keyPW4']; header('location:');
	}
}//POST

if(!empty($_SESSION['keyPW4']) and class_exists($_SESSION['keyPW4'])){
	$o=new $_SESSION['keyPW4'];
	$o->start();
}else{$o=bootPW4(); $o=new $o; }

if($view){
echo <<<NEC
<!doctype html>
<head>
<title>PhpWav4</title>
<meta charset="utf-8">
<style>
body{margin:0;background:#eed;}
#menuUpPW4{background:#555; font-size:14px;}
.menuKeyPW4{display:inline-block;color:#fff;}
.nameMenuKeyPW4{padding:2px 8px;}
.menuOpenPW4{display:none;background:#aa9;border:1px solid #444;position:absolute;overflow:hidden;}
.menuKeyPW4:hover,.keyPW4:hover{background:#59f;cursor:pointer;}
.keyPW4:active{background:#05c;}
.menuKeyPW4:hover .menuOpenPW4{display:block;}
.keyPW4{text-decoration:none;display:block;color:#fff;padding:2px 6px;
background:none;border:none; width:100%; text-align:left;outline:none;}
</style>
</head>
<body>

<form method="post" id="menuUpPW4">
<div class="menuKeyPW4"><div class="nameMenuKeyPW4">PhpWav4</div>
	<div class="menuOpenPW4">
		<button type="submit" class="keyPW4" name="keyPW4" value="reset">Перезагрузить</a>
		<button type="submit" class="keyPW4" name="keyPW4" value="exit">Выход</button>
	</div>

</div>
NEC;
global $keysProgPW4;
if(!empty($keysProgPW4)){
	echo '<div class="menuKeyPW4"><div class="nameMenuKeyPW4">Программы</div>'
	.'<div class="menuOpenPW4">';
	foreach($keysProgPW4 as $v){ $t='';
		$n=new $v;
		if(isset($n->info)){$t.="title='{$n->info}'";}
		if(isset($n->name)){$n=$n->name;}else{$n=$v;}
		echo "<button $t type='submit' class='keyPW4' name='keyPW4' value='$v'>$n</button>";
		//echo "<button $t class='keyPW4 gr' onclick=blockC('?keyPW4=$v')>$n</button>";
	}
	echo "</div></div>";
}
	if(isset($o->name)){$n=$o->name;}else{$n=get_class($o);}
	echo <<<NEC
</form>
<div style='background:#333;color:#fff;text-align:center;'>$n</div>
<div id='viewPW4' style='background:#99f'>
NEC;
}//if view
	$o->view();
if($view){
echo <<<NEC
</div>
</body> </html>
NEC;
}//if view
	}//boot()
	function view(){
		echo <<<NEC
<h1 style='padding:5px 10px;margin:0;'>PhpWav4</h1>
<p style='margin:0;padding:0 2px;text-align:right;font-weight:900;'>ver {$this->vers}</p>
NEC;
	}
}/*class PhpWav4*/
/*<|PhpWav4*/

/*>|DeletPrograms*/
class DeletPrograms{
	var $name='Deleted Programs';
	var $info="Удаляет программы из PhpWav4";
	var $vers="1.01";
	var $desc=<<<NEC
09.11.16 v1.01 - Добавлено удалеие 'boot' .
17.11.16 v1.02 - Правка стилей.
NEC;
	
	var $view='home';
	var $nameProg='';
	
	function nam(){
		$a=$_SERVER["SCRIPT_NAME"]; $b="";
		for($i=0; $i<strlen($a); $i++){if(substr($a,$i,1)=="/"){$b="";}else{$b.=substr($a,$i,1);}}
		return $b;
	}//nam() - имя текущего файла или файл который вызывает эту функцию.
	
function start(){
	if(session_id()==false){session_start();}
	if(!empty($_POST['nameDelProg'])){
		$this->view="delet";
		$_SESSION['nameDelProg']=$_POST['nameDelProg'];
	}
	if(!empty($_POST["keyDelProg"])){switch($_POST['keyDelProg']){
		case 'home':
			$this->view='home';
			unset($_SESSION['nameDelProg']);
			break;
		case 'delet': $this->delet($_SESSION['nameDelProg']); break;
	}}
}//start

function delet($keyProg){
	global $keysProgPW4;
	$o=new $keyProg; if(isset($o->name)){$this->nameProg=$o->name;}else{$this->nameProg=$keyProg;}
	$t=''; $g=false; $p=true; $k=true; $b=false;
	foreach(file($this->nam()) as $v){
		/*=====*/
		if(substr($v,0,12)=='}//bootPW4()'){$b=false;}
		if($b==true){
			for($i=0;$i<(strlen($v)-strlen($keyProg));$i++){
				if(substr($v,$i,strlen($keyProg))==$keyProg){$b=false;}
			}
			if($b==false){continue;}
		}
		if(substr($v,0,10)=='/*=boot=*/'){$b=true;}
		/*=====*/
		if($p==true and substr($v,0,13)=="/*|keysProg*/"){
			$s='/*|keysProg*/ $keysProgPW4=array(';
			foreach($keysProgPW4 as $val){
				if($val==$keyProg){continue;}
				if($g==true){$s.=",";}
				$s.="'".$val."'";
				$g=true;
			}
			$t.=$s.');'.chr(10);
			continue;
		}
		if(substr($v,0,strlen($keyProg)+6)=="/*>|$keyProg*/"){$p=false; $e="error";}//error
		if($p==true){$t.=$v;}
		if($k==false and $v!=chr(13)){$p=true; $k=true;}
		if(substr($v,0,strlen($keyProg)+6)=="/*<|$keyProg*/"){$k=false; $e="complete";}
		//$t.=$v;
	}
	if($e=='complete'){$f=fopen($this->nam(),'w'); fwrite($f,$t); fclose($f);}
	$this->view=$e;
	
}//delet

function message($head='header',$mess='message',$key='Ok'){
	echo <<<NEC
<div id='headDelProg'>$head</div>
<div id='messageDelProg'>$mess
	<div id="buttonDelProg">
		<button class="keyButtonDP" name="keyDelProg" value="nome">$key</button>
	</div>
</div>
NEC;
}

function viewDelet(){
	if(isset($_SESSION['nameDelProg'])){ $n=$_SESSION['nameDelProg'];
		echo "<div id='headDelProg'>Удалить программу:</div><div id='messageDelProg'>";
		$o=new $n; if(isset($o->name)){$n=$o->name;}
		echo "Удалить: <b>".$n."</b> !";
		echo <<<NEC
<div id="buttonDelProg">
	<button class='keyButtonDP' name="keyDelProg" value="delet">Delet</button>
	<button class='keyButtonDP' name='keyDelProg' value="home">Cancel</button>
</div>
NEC;
		echo '</div>';
	}
}//viewDelet()

function viewHome(){
	global $keysProgPW4;
	echo '<div id="headDelProg">Выберите прогамму для удаления:</div>';
	echo "<div id='contentDelProg'>";
	if(isset($keysProgPW4)){foreach($keysProgPW4 as $v){
		$o=new $v; if(isset($o->name)){$n=$o->name;}else{$n=$v;}
		echo "<button type=submit class=nameDelProg name=nameDelProg value='$v'>$n</button>";
	}}
	echo "</div>";
}//viewHome()

function view(){
	echo <<<NEC
<style>
#messageDelProg{background:#fff;Text-align:center;padding:10px;color:#f55;}
#messageDelProg b{color:#000;}
#buttonDelProg{padding-top:10px;}
.keyButtonDP{border:1px solid #777;background:#fff;outline:none;padding:5px 10px; font-weight:bold;}
.keyButtonDP:hover{box-shadow:2px 2px 5px rgba(0,0,0,0.5);}
.keyButtonDP:active{color:#f55;}
#formDelProg{background:#f77;padding:3px;display:inline-block;}
#headDelProg{text-wieght:bold;color:#fff;padding:0 3px;}
#contentDelProg{background:#fff;margin:5px;border:1px solid #fee;}
.nameDelProg{outline:none;border:1px solid #Fdc; background:#fff; display:block;width:100%; text-align:left; padding:3px; color:#f00;}
.nameDelProg:hover{background:#f88;color:#fff;cursor:pointer;}
.nameDelProg:active{background:#f55;}
</style>
<form id="formDelProg" method="POST">
NEC;
	switch($this->view){
		case 'home': $this->viewHome(); break;
		case 'delet': $this->viewDelet(); break;
		case 'complete':
			$this->message('Программа удалена','Программа удалена <b>'.$this->nameProg.'</b> !');
			break;
		case 'error': 
			$this->message('Ошыбка удаления','Не найдено окончание программы!');
			break;
	}
	echo '</form>';
}//view
}//class DeletPrograms
/*<|DeletPrograms*/

/*>|PackNEC*/
class PackNEC{
	var $name='PackNEC';
	var $info="Упаковщик программ для Install Programs";
	var $view='home';
	var $vers="1.01";
	var $desc=<<<NEC
10.11.16 v1.01 - Добавлено сохранение boot .
NEC;
	
	function nam(){
		$a=$_SERVER["SCRIPT_NAME"]; $b="";
		for($i=0; $i<strlen($a); $i++){if(substr($a,$i,1)=="/"){$b="";}else{$b.=substr($a,$i,1);}}
		return $b;
	}//nam() - имя текущего файла или файл который вызывает эту функцию.
	
function saveProg(){
	if(!empty($_POST['nameFile']) and !empty($_POST['nameClass']) and !empty($_POST['key'])){
		$key=$_POST['key']; $p=false; $g=false; $nec=true; $dec=true; $text=''; $b=false;
		foreach(file($this->nam()) as $v){
			if(substr($v,0,strlen($key)+6)=="/*>|$key*/"){$p=true; $g=true; continue;}
			if(substr($v,0,strlen($key)+6)=="/*<|$key*/"){$p=false;}
			if($g){$g=false; continue;}
			if($p==true){
				for($i=0;$i<strlen($v);$i++){
					switch(substr($v,$i,1)){case '\\': case '$': $text.='\\';}
					$text.=substr($v,$i,1);
				}
			}
			if(substr($v,0,4)=='NEC;'){$nec=false;}
			if(substr($v,0,4)=='DEC;'){$dec=false;}
			
			if(substr($v,0,10)=='/*=boot=*/'){$b=true; continue;}
			if(substr($v,0,12)=='}//bootPW4()'){$b=false;}
			if($b==true){
				for($i=0;$i<(strlen($v)-strlen($key));$i++){
					if(substr($v,$i,strlen($key))==$key){$b=false; break;}
				}
				if($b==false){$boot=true;}
			}
		}//foreach
		
		if(!$p){
			$key=$_POST['nameClass'];
			if($nec and $dec){$nec="NEC";}elseif(!$nec and $dec){$nec='DEC';}else{$nec='GEC';}
			$t="<?php /*000||*/".chr(10)."\$keyProg='$key';".chr(10);
			if(isset($boot)){$t.='$boot=true;'.chr(10);}
			$t.="\$program=<<<$nec".chr(10)."class $key{";
			//if(!empty($_POST['name'])){$t.='	var $name="'.$_POST['name'].'";'.chr(10);}
			$t.=chr(10).$text."$nec;".chr(10);
			if(isset($_POST['installPack'])){
				$t=$t.chr(10).'//test';
			}
			$f=fopen($_POST['nameFile'].'.php','w'); fwrite($f,$t); fclose($f);
			$this->view='pack';
		}//if $p
	}
}
	
function start(){
	if(isset($_POST['keyNec'])){$this->view='form';}
	if(isset($_POST['keysNec'])){switch($_POST['keysNec']){
		case 'saveProg': $this->saveProg(); break;
		case 'home': $this->view='home'; break;
	}}
}//start()
	
function view(){
	echo <<<NEC
<style>
#packNec{background:#ffc;padding:2px;}
#headNec{background:#444;padding:2px 5px;color:#fff;}
#keysNec{margin:0;}
.keyNec{display:block; border:1px solid #333; outline:none; background:#777; padding:1px 5px; width:100%; margin:1px 0; color:#ff9; text-align:left;}
.keyNec:hover{color:#9f9;}
.keyNec:active{color:f ;}
</style>
<form id=packNec method=POST>
NEC;
	switch($this->view){
		case 'home': $this->viewHome(); break;
		case 'form': $this->viewForm($_POST['keyNec']); break;
		case 'pack': echo 'compele <input type=submit value=home name=keysPack>';  break;
	}
	echo '</form>';
}
	
function viewHome(){
	global $keysProgPW4;
	echo '<div id=headNec>Выберите программу для упаковки:</div><div id=keysNec>';
	foreach($keysProgPW4 as $v){
		$o=new $v; if(isset($o->name)){$n=$o->name;}else{$n=$v;}
		echo "<button class=keyNec type=submit name='keyNec' value='$v'>$n</button>";
	}
	echo '</div>';
}
	
function viewForm($key){
	echo <<<NEC
name class: <input type=text name='nameClass' value='$key'> <br>
name prog file: <input type=text name='nameFile' value='{$key}_pack'> .php <br>
<!--name prog: <input type=text name=name><br>-->
Упаковать в установщик: <input type='checkbox' name='installPack'>
<button type=submit name=keysNec value='saveProg'>save</button>
<button type=submit name=keysNec value='home'>cancel</button>
<input type='hidden' name='key' value='$key'>
NEC;
}//viewForm
}//class packNec;
/*<|PackNEC*/

/*>|InstallPrograms*/
class InstallPrograms{
	var $name='Install Programs';
	var $info="Устанавливает программы в PhpWav4.";
	var $vers='1.01';
	var $view='home';
	var $desc=<<<NEC
13.11.16 v.1.01 - Добавлено установка boot.
NEC;
	
	function nam(){
		$a=$_SERVER["SCRIPT_NAME"]; $b="";
		for($i=0; $i<strlen($a); $i++){if(substr($a,$i,1)=="/"){$b="";}else{$b.=substr($a,$i,1);}}
		return $b;
	}//nam() - имя текущего файла или файл который вызывает эту функцию.
	
function installProg($f){
	include($f);
	if(!empty($keyProg) and !empty($program)){
		//$f=file('PhpWav4.php'); 
		$f=file($this->nam());
		$t=""; $this->view='installComplete';
		foreach($f as $v){
			if(substr($v,0,13)=="/*|keysProg*/"){
				if(strpos($v,'"'.$keyProg.'"') or strpos($v,"'".$keyProg."'")){
					$this->view="err2"; break;
				}//error
				global $keysProgPW4;
				$t.="/*|keysProg*/ \$keysProgPW4=array('$keyProg'";
				foreach($keysProgPW4 as $val){$t.=",'$val'";}
				$t.=");".chr(10);
				continue;
			}
			if(substr($v,0,13)=="/*|programs*/"){
				$t.=$v.chr(10)."/*>|$keyProg*/".chr(10).$program.chr(10)."/*<|$keyProg*/".chr(10);
				continue;
			}
			$t.=$v;
			if(!empty($boot) and substr($v,0,9)=='/*|boot*/'){$t.="	return '$keyProg';".chr(10);}
		}
		if($this->view=="installComplete"){
			$f=fopen($this->nam(),'w'); fwrite($f,$t); fclose($f);
			//$f=fopen('test.php','w'); fwrite($f,$t); fclose($f);
		}
	}else{$this->view='err1';}//error
}//installProg()

function start(){
	if(!empty($_POST['keyInsProg'])){switch($_POST['keyInsProg']){
		case 'home': $this->view='home'; break;
		default :
			if(file_exists($_POST['keyInsProg'])){
				$str=file($_POST['keyInsProg']);
				if(substr($str[0],8,5)=="000||"){
					unset($str);
					$this->installProg($_POST['keyInsProg']);
				}
			}else{$this->view='err0';}//error
	}}
}

function viewHome(){
	echo 'Выберите файл для установки!';
	echo '<div id="contentInsProg">';
	foreach(scandir('.') as $v){
		if(is_file($v) and substr($v,strlen($v)-3,3)=='php' and filesize($v)>0){
			$f=file($v);
			switch(substr($f[0],8,5)){
				//case "0000|": echo "<a style='color:blue;display:block;'>$v</a>"; break;
				//case "000|0": echo "<a style='color:#99c;display:block'>$v</a>"; break;
				case "000||":
	echo "<button type=submit class=keyInsProg name=keyInsProg value='$v'>$v</button>";
					break;
				//default: echo "<a style='color:#999;display:block;'>$v</a>";
			}
		}
	}
	echo '</div>';
}
function view(){
	echo <<<NEC
<style>
#insForm{background:#ddf; padding:5px 3px;}
#contentInsProg{background:#fff; margin:5px;border:1px solid #eef;}
.keyInsProg{border:1px solid #eef; background:#fff; outline:none; color:#009; padding:3px; margin:0px; display:block; text-align:left; width:100%;}
.keyInsProg:hover{background:#99f; color:#fff; cursor:pointer;}
.keyInsProg:active{background:#55c;}
</style>
NEC;
	echo '<form id="insForm" method="POST">';
	switch($this->view){
		case 'home': $this->viewHome(); break;
		case 'installComplete': echo 'программа установлена'; break;
		case 'err0': echo 'неизвестная ошыбка'; break;
		case 'err1': echo 'нет ключа и программы'; break;
		case 'err2': echo 'программа уже установлена'; break;
		default: echo '???';
	}
	if($this->view!='home'){
		echo "<button type='submit' name='keyInsProg' value='home'>назад</button>";
		}
	echo <<<NEC
</form>
NEC;
}
}//class
/*<|InstallPrograms*/

/*=boot=*/
function bootPW4(){
/*|boot*/
	return 'PhpWav4_v2';
	return 'PhpWav4';
}//bootPW4()
/*================*/

/*|Bios*/
class biosPW4{
	var $ver='1.0';
function viewBoot(){
	echo "<b>Not boot</b> - bios v{$this->ver}<br>";
	global $keysProgPW4;
	if(!empty($keysProgPW4)){foreach($keysProgPW4 as $v){
		echo "[<a style='color:blue;' href='?bootPW4=$v'>$v</a>] ";
	}}else{echo 'Not programs !';}
	echo '<br>[<a style="color:red;" href="?biosPW4=exit">Exit</a>]<hr>';
}//viewBoot
function boot(){
	session_start();
	if(!empty($_GET['biosPW4']) and $_GET['biosPW4']=='exit'){
		unset($_SESSION['bootPW4']);
		header('location:/');
	}//bios exit
	if(!empty($_GET['bootPW4'])){$_SESSION['bootPW4']=$_GET['bootPW4'];}
	if(isset($_SESSION['bootPW4']) and class_exists($_SESSION['bootPW4'])){
		$o=new $_SESSION['bootPW4'];
		$o->start();
		$this->viewBoot();
		$o->view();
	}else{$this->viewBoot();}
}//boot
}//class biosPW4
/*|EndBios*/

$o=bootPW4();
if(class_exists($o)){$o=new $o; $o->boot();}else{
/*>bios<*/if(class_exists('biosPW4')){$o=new biosPW4; $o->boot(); exit;}
echo '<b>Not boot !</b>';
}
/*PhpWav4 v1.0 wavixsan*/
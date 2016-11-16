<?php /*0000|*/
ini_set('display_errors',1);
error_reporting(E_ALL);

/*|keysProg*/ $keysProgPW4=array('test','PackNEC','DeletPrograms','InstallPrograms','PhpWav4');
 
/*|programs*/

/*>|test*/
class test{
	function start(){}
	function view(){echo 'class test';}
}
/*<|test*/

/*>|PackNEC*/
class PackNEC{
	var $name='Pack NEC';
	var $view='home';
	
	function nam(){
		$a=$_SERVER["SCRIPT_NAME"]; $b="";
		for($i=0; $i<strlen($a); $i++){if(substr($a,$i,1)=="/"){$b="";}else{$b.=substr($a,$i,1);}}
		return $b;
	}//nam() - имя текущего файла или файл который вызывает эту функцию.
	
function saveProg(){
	if(!empty($_POST['nameFile']) and !empty($_POST['nameClass']) and !empty($_POST['key'])){
		$key=$_POST['key']; $p=false; $g=false; $nec=true; $dec=true; $text='';
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
			
		}
		if(!$p){
			$key=$_POST['nameClass'];
			if($nec and $dec){$nec="NEC";}elseif(!$nec and $dec){$nec='DEC';}else{$nec='HEC';}
			$t="<?php /*000||*/".chr(10)."\$keyProg='$key';".chr(10);
			$t.="\$program=<<<$nec".chr(10)."class $key{";
			//if(!empty($_POST['name'])){$t.='	var $name="'.$_POST['name'].'";'.chr(10);}
			$t.=chr(10).$text.chr(10)."$nec;".chr(10);
			$f=fopen($_POST['nameFile'].'.php','w'); fwrite($f,$t); fclose($f);
			$this->view='pack';
		}//if $p
	}
}
	
	function start(){
		if(isset($_POST['keyNec'])){$this->view='form';}
		if(isset($_POST['keysNec'])){switch($_POST['keysNec']){
			case 'saveProg': $this->saveProg(); break;
		}}
	}
	
	function view(){
		echo '<form method=POST>';
		switch($this->view){
			case 'home': $this->viewHome(); break;
			case 'form': $this->viewForm($_POST['keyNec']); break;
			case 'pack': echo 'compele'; break;
		}
		echo '</form>';
	}
	
	function viewHome(){
		global $keysProgPW4;
		echo 'Выберите программу для упаковки:';
		foreach($keysProgPW4 as $v){
			$o=new $v; if(isset($o->name)){$n=$o->name;}else{$n=$v;}
			echo "<button type=submit name='keyNec' value='$v'>$n</button>";
		}
	}
	
	function viewForm($key){
		echo <<<NEC
name class: <input type=text name='nameClass' value='$key'> <br>
name prog file: <input type=text name='nameFile' value='$key'> .php <br>
name prog: <input type=text name=name><br>
<button type=submit name=keysNec value='saveProg'>save</button>
<input type='hidden' name='key' value='$key'>
NEC;
	}
	
}//class packNec;


/*<|PackNEC*/

/*>|DeletPrograms*/
class DeletPrograms{
	var $name='Delet Programs';
	
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
	$t=''; $g=false; $p=true; $k=true;
	foreach(file($this->nam()) as $v){
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
#formDelProg{background:#f77;padding:3px;}
#headDelProg{text-wieght:bold;color:#fff;}
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
}
/*<|DeletPrograms*/

/*>|InstallPrograms*/
class InstallPrograms{
	var $name='Install Programs';
	var $version='0.0';
	var $view='home';
	
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

/*>|PhpWav4*/
class PhpWav4{
	var $name="PhpWav4";
	function start(){}
	function boot(){ $view=true;
session_start();
if(!empty($_GET['XML_PW4'])){
	switch($_GET['XML_PW4']){
		default : $_SESSION['keyPW4']=$_GET['XML_PW4']; $view=false;
	}
}//GET_XML_PW4
if(!empty($_GET['keyPW4'])){
	switch($_GET['keyPW4']){
		//case "reset": $o=new PhpWav4; $o->resetPW4(); exit; break;
		default : $_SESSION['keyPW4']=$_GET['keyPW4']; 
	}
}//GET
if(!empty($_POST['keyPW4'])){
	switch($_POST['keyPW4']){
		case "update": break;
		case "reset": $o=new PhpWav4; $o->resetPW4(); break;
		case "exit": $o=new PhpWav4; $o->exitPW4(); break;
		default : $_SESSION['keyPW4']=$_POST['keyPW4'];
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
	foreach($keysProgPW4 as $v){
		$n=new $v; if(isset($n->name)){$n=$n->name;}else{$n=$v;}
		echo "<button type='submit' class='keyPW4' name='keyPW4' value='$v'>$n</button>";
		//echo "<button class='keyPW4' style='color:green;' onclick=viewPW4('$v')>$n</button>";
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
<script>
function eid(id){return document.getElementById(id);}
function viewPW4(s){
var xmlhttp;
if(window.XMLHttpRequest){
	xmlhttp=new XMLHttpRequest();
}else{
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function(){
	if(xmlhttp.readyState==4 && xmlhttp.status==200){
		eid('viewPW4').innerHTML=xmlhttp.responseText;
	}
}
xmlhttp.open("GET",'?XML_PW4='+s,true);
xmlhttp.send();
}
</script>
</body> </html>
NEC;
}//if view
	}//boot()
	function view(){
		echo "<h1 style='padding:0 10px;'>PhpWav4</h1>";
	}
	function resetPW4(){
		$_SESSION['keyPW4']=bootPW4();
		header('location:');
	}
	function exitPW4(){header('location:/');}
}/*class PhpWav4*/
/*<|PhpWav4*/

/*=== boot ===*/
function bootPW4(){
/*|boot*/

return "PhpWav4";
}
$o=bootPW4(); if(class_exists($o)){$o=new $o; $o->boot();}else{echo 'not boot';}
/*PhpWav4 v1.0 wavixsan*/
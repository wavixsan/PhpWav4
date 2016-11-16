<?php /*0000|*/
ini_set('display_errors',1);
error_reporting(E_ALL);

/*|keysProg*/ $keysProgPW4=array('PhpWav4');
 
/*|programs*/

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
/*if(!empty($_GET['keyPW4'])){
	switch($_GET['keyPW4']){
		//case "reset": $o=new PhpWav4; $o->resetPW4(); exit; break;
		default : $_SESSION['keyPW4']=$_GET['keyPW4']; 
	}
}//GET*/
if(!empty($_POST['keyPW4'])){
	switch($_POST['keyPW4']){
		case "update": break;
		case "reset": $_SESSION['keyPW4']=bootPW4(); header('location:'); break;
		case "exit": header('location:/'); break;
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
<p style='margin:0;padding:0 2px;text-align:right;font-weight:900;'>ver 0.0</p>
NEC;
	}
}/*class PhpWav4*/
/*<|PhpWav4*/

/*=== boot ===*/
function bootPW4(){
/*|boot*/

/*>PhpWav4<*/ return "PhpWav4";
}
$o=bootPW4(); if(class_exists($o)){$o=new $o; $o->boot();}else{echo 'not boot';}
/*PhpWav4 v1.0 wavixsan*/
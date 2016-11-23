<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
/*===========================================================================*/

//$arr[]=array('name'=>'svsc vxcxv','email'=>'sdf dfg fsddsf');
/*Save
a:2:{s:4:"name";s:10:"svsc vxcxv";s:5:"email";s:14:"sdf dfg fsddsf";}
a:2:{s:4:"name";s:8:"sdfsdvsv";s:5:"email";s:6:"sdvsgs";}
a:2:{s:4:"name";s:6:"sdsvss";s:5:"email";s:9:"sdgsgscds";}
a:2:{s:4:"name";s:9:"dfbgdvdfv";s:5:"email";s:7:"dfdfvds";}
a:2:{s:4:"name";s:7:"dfgdgdf";s:5:"email";s:14:"dfgdfvfbbdbfvd";}
a:2:{s:4:"name";s:5:"dffdf";s:5:"email";s:6:"dfdgfd";}
a:2:{s:4:"name";s:0:"";s:5:"email";s:0:"";}
a:2:{s:4:"name";s:3:"sfs";s:5:"email";s:5:"kskds";}
a:2:{s:4:"name";s:4:"dron";s:5:"email";s:0:"";}
endSave*/

function nam(){
	$a=$_SERVER["SCRIPT_NAME"]; $b="";
	for($i=0; $i<strlen($a); $i++){if(substr($a,$i,1)=="/"){$b="";}else{$b.=substr($a,$i,1);}}
	return $b;
}//nam() - имя текущего файла или файл который вызывает эту функцию.

function save($m){
	$arr=file(nam());
	$t="";
	foreach($arr as $v){
		$t.=$v;
		if(substr($v,0,6)=="/*Save"){$t.=serialize($m).PHP_EOL;}
	}
	$f=fopen(nam(),"w"); fwrite($f,$t); fclose($f);
}//save() - сохраняет данный в файл.

function fun(){
	$arr=file(nam());
	$z=false;
	$hr="-------------------------<br>";
	$t=$hr;
	foreach($arr as $v){
		if(substr($v,0,6)=="/*Save"){$z=true; continue;}
		if(0===strpos($v,"endSave*/")){break;}
		if($z==true){
			$v=unserialize($v);
			$t.=<<<NEC
	name: {$v['name']} ;<br>
	email: {$v["email"]} ;<br>
	$hr
NEC;
			$t.=PHP_EOL;
		}
	}
	return $t;
}//fun() - Вывод записей.

function view($v){
	echo <<<NEC
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Form</title>
<head>
<body>
$v
</body>
</html>
NEC;
}//view() - Вывод документа.

function form(){
	return <<<NEC
	<form method="GET">
	name:<input type="text" name="name"><br>
	email<input type="text" name="email"><br>
	<input type="submit">
	</form>
NEC;
}//form() - Форма.

$t=form();
if(!empty($_POST)){save($_POST);$t.=fun();}elseif(!empty($_GET)){save($_GET);$t.=fun();}
view($t);


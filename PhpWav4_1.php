<?php /*0000|*/

/*|keysProg*/ $keysProgPW4=array("InstallPrograms",'green','red');

/*|programs*/

/*>|InstallPrograms*/
class installPrograms{
	function start(){}
	function view(){ echo 'echo test'; }
}
/*<|InstallPrograms*/

class PhpWav4{
	function start(){}
	function view(){
		echo "<h1 style='padding:0 10px;'>PhpWav4</h1>";
	}
	function resetPW4(){
		$_SESSION['keyPW4']=bootPW4();
		header('location:');
	}
	function exitPW4(){header('location:/');}
}/*class PhpWav4*/

function bootPW4(){
/*|boot*/

	return "PhpWav4";
}

session_start();
if(!empty($_GET['keyPW4'])){
	switch($_GET['keyPW4']){
		case "reset": $o=new PhpWav4; $o->resetPW4(); exit; break;
		default : $_SESSION['keyPW4']=$_GET['keyPW4'];
	}
}
if(!empty($_POST['keyPW4'])){
	switch($_POST['keyPW4']){
		case "reset": $o=new PhpWav4; $o->resetPW4(); break;
		case "exit": $o=new PhpWav4; $o->exitPW4(); break;
		default : $_SESSION['keyPW4']=$_POST['keyPW4'];
	}
}

if(!empty($_SESSION['keyPW4']) and class_exists($_SESSION['keyPW4'])){
	$o=new $_SESSION['keyPW4'];
	$o->start();
}else{$o=bootPW4(); $o=new $o; }
echo <<<NEC
 
<head>
<title>PhpWav4</title>
<meta charset="utf-8">
<style>
body{margin:0;background:#eed;}
#menuUpPW4{background:#555; font-size:14px;}
.menuKeyPW4{display:inline-block;color:#fff;}
.nameMenuKeyPW4{padding:2px 8px;}
.menuOpenPW4{display:none;background:#aa9;border:1px solid #444;position:absolute;overflow:hidden;}
.menuKeyPW4:hover,.keyPW4:hover{background:#59f;}
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

if(!empty($keysProgPW4)){
	echo '<div class="menuKeyPW4"><div class="nameMenuKeyPW4">Программы</div>'
	.'<div class="menuOpenPW4">';
	foreach($keysProgPW4 as $v){
		echo "<button type='submit' class='keyPW4' name='$v'>$v</button>";
	}
	echo "</div></div>";
}
echo "</form>";
$o->view();
echo "</body> </html>";

/*PhpWav4 v1.0 wavixsan*/


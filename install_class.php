<?php /*00000*/
//################ �� ��������, �������� 
/*�������� ���������*/
$nameProg="install";

class install{
	
/*�������� ���������*/
public $name;

/*������ ��� ����� ��� ������� ���������*/
public $keyUp=<<<NEC
	echo 'testKey ';
NEC;

/*���� ��������*/
public $programm=<<<NEC
	echo ' testProgramm';
NEC;

function tag($p){
	$name=$this->name;
	return chr(10)."/*>|$name*/".chr(10).$p.chr(10)."/*<|$name*/".chr(10);
}/*tag()*/

function home(){
	echo <<<NEC
���������� �������� ��� <b>PhpWav4</b>:<br>
[<a href="?go=install" style="color:#99f;">����������</a>]
[<a href="?go=delet" style="color:#f99">�������</a>]
[<a href="/" style="color:#f00;">exit</a>]
<br>v0.0 beta
NEC;
}

function install(){
	$name=$this->name;
	$prog=$this->programm;
	$keyup=$this->keyUp;
	$t="";
	foreach(file('PhpWav4.php') as $v){
		$t.=$v;
		if(substr($v,0,14)=="/*|programms*/"){$t.=tag($prog);}
		if(substr($v,0,11)=="/*|keysUp*/"){$t.=tag($keyup);}
	}/*foreach*/
	$f=fopen('test.php','w'); fwrite($f,$t); fclose($f);
	echo "�����������! [<a href='?go=home'>�����</a>]";
}

function delet(){
	$name=$this->name;
	$p=true; $t=""; $k=2;
	foreach(file('test.php') as $v){
		if(substr($v,0,strlen($name)+6)=="/*>|$name*/"){$p=false;}
		if(substr($v,0,strlen($name)+6)=="/*<|$name*/"){$p=true; $k=0;}
		if($p==true and $k==2){$t.=$v;}
		if($k!=2){$k++;}
	}/*foreach*/
	$f=fopen('test.php','w'); fwrite($f,$t); fclose($f);
	echo "�������! [<a href='?go=home'>�����</a>]";
}

function __construct($name){
	$this->name=$name;
	if(empty($_GET['go'])){$go="home";}else{$go=$_GET['go'];}
	switch($go){
		case "home": $this->home(); break;
		case "install": $this->install(); break;
		case "delet": $this->delet(); break;
	}
}

//function start(){}
}//class install

$o=new install('red');
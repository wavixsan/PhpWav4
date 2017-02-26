<?php /*0000|*/

//ini_set('display_errors',1);
//error_reporting(E_ALL);

/*|keys*/ $keysPW4=array('PhpWav4_v2','PackNEC','cod51','sql_console','PhpWav4_v3','program_manager');

/*|boot*/ $bootPW4=array('PhpWav4_v2','PhpWav4_v3');

/*|bios*/ $biosPW4="biosPW4";

/*|programs*/

/*>|PhpWav4_v2*/
class PhpWav4_v2{
	public $name="PhpWav4 v2";
	public $ver='2.05';
	public $info="PhpWav v2 OC";
	public $script=array('_xml');
	public $desc=<<<NEC
06.02.17 v2.01 - Одоптация под оболочку PhpWav4 v1.1
07.02.17 v2.02 - Список программ виводит только программы, переделана конструкция вивода программ, видиление программы.
08.02.17 v2.03 - Перед. домашная страница, перед. отопражение программ и + изменение стилей.
09.02.17 v2.04 - Изменено назване программы в заголовке на более жирное и добавлены отступы.
20.02.17 v2.05 - Переделана структука кода, доб. поддержка скриптов, доб. функция _xml .
NEC;

	function boot(){
		global $keysPW4;
		$keys=''; $head=''; $script='';
		if(session_id()==false){session_start();}

		if(!empty($_GET['keyPW4'])){
			switch($_GET['keyPW4']){
				case "reset": unset($_SESSION['keyPW4']); header('location:'); break;
				case 'exit': header('location:/'); break;
				default: $_SESSION['keyPW4']=$_GET['keyPW4'];
			}
		}// - обработка get .

		if(!empty($_SESSION['keyPW4']) and class_exists($_SESSION['keyPW4'])){
			$o=new $_SESSION['keyPW4'];
			if(method_exists($o,'start')){ $o->start(); }
		}// - обработка session .

		if(!empty($keysPW4)){
			foreach($keysPW4 as $v){
				if(method_exists($v,'start') and method_exists($v,'view')){
					$n=new $v; $t=''; $s='';
					if(isset($n->info)){$t.="title='{$n->info}'";}
					if(isset($n->name)){$n=$n->name;}else{$n=$v;}
					if($_SESSION['keyPW4']==$v){$s=" keyPW4active";}
					$keys.="<a $t href='?keyPW4=$v' class='keyPW4$s'>$n</a>";
				}
			}
			if(!empty($keys)){
				$keys= <<<NEC
<div class="menuKeyPW4"><div class="nameMenuKeyPW4">Программы</div>
	<div class="menuOpenPW4">
		$keys
	</div></div>
NEC;
			}
		}//if $keysPW4 - Обработка списка программ (кнопок).

		if(isset($o) and method_exists($o,'script')){ $script=$o->script(); }// - Обработка скриптов.

		if(isset($o)){
			if(isset($o->name)){
				$n=$o->name;
			}else{$n=get_class($o);}
			if(!empty($script)){$n.=' - <span style="font-size:14px;font-weight:200;color:#9f9;">( Script )</span>';}
			$head="<div style='background:#333;color:#fff;text-align:center;font-weight:bold;padding:1px;'>$n</div>";
		}// - Обработка заголовка.

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
.menuKeyPW4:hover,.keyPW4:hover{background:#444;cursor:pointer;}
.keyPW4:active{background:#333;}
.menuKeyPW4:hover .menuOpenPW4{display:block;}
.keyPW4{text-decoration:none;display:block;color:#fff;padding:2px 6px;
background:none;border:none; width:100%; text-align:left;outline:none;}
.keyPW4active{background:#776;}
#home{background:#fff; border:1px solid #444; font-size:20px;text-align:center; padding: 10px;}
</style>
</head>
<body>

<form method="POST" id="menuUpPW4">
<div class="menuKeyPW4"><div class="nameMenuKeyPW4">PhpWav4</div>
	<div class="menuOpenPW4">
		<a class="keyPW4" href="?keyPW4=reset">Перезагрузить</a>
		<a class="keyPW4" href="?keyPW4=exit">Выход</a>
	</div>
</div>
$keys
</form>
$head
<div id='viewPW4' style='background:#f99;'>
NEC;
		if(isset($o) and method_exists($o,'view')){$o->view();}else{
			echo "<div id='home'>Добро пожаловать в <b>PhpWav4</b> ver {$this->ver}</div>";
		}
		echo <<<NEC
</div>
<script>
function _xml(str,id){
	var xmlhttp;
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
		 	document.getElementById(id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",str,true);
	xmlhttp.send();
}
$script
</script>
</body>
</html>
NEC;
	}//boot() -
}//end class PhpWav4_v2;
/*<|PhpWav4_v2*/

/*>|PackNEC*/
class PackNEC{
	public $name='PackNEC';
	public $info="Упаковщик программ для PhpWav4";
	public $ver="1.12";
	public $desc=<<<NEC
10.11.16 v1.01 - Добавлено сохранение boot .
07.12.16 v1.02 - Исправлен boot из за переменования /*|boot*/ .
09.12.16 v1.03 - Добавлена версия в имени сохраняемого файла .
10.12.16 v1.04 - Добавлена упаковка bios .
12.12.16 v1.05 - Испавлена упаковка bios .
21.12.16 v1.06 - Одоптация под оболочку PhpWav4 v1.1
22.12.16 v1.07 - Добавление и правка стилей.
24.12.16 v1.08 - Добавлено описание программы и правка стилей.
28.12.16 v1.09 - Исправлено добавления версии к имени файла для сохранения.
07.02.17 v1.10 - Испр. упаковка пустого биоса.
08.02.17 v1.11 - Доб. проверка сохраняемого файла на сущесвование.
12.02.17 v1.12 - Доб. запись имени, версии и информации в упакованый файл для дольнейшего предпросмотра.
NEC;

	private $view='home';

private function saveProgram(){
	if(!empty($_POST['nameFile']) and !empty($_POST['nameClass']) and !empty($_POST['key'])){
		//if(file_exists($_POST['nameFile'])){$file=false;}else{$file=true;}
		$key=$_POST['key']; $p=false; $g=false; $nec=true; $dec=true; $text=''; global $bootPW4;
		foreach(file(__FILE__) as $v){
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
		}//foreach

		if(!$p){
			$key=$_POST['nameClass'];
			if($nec){$nec="NEC";}elseif($dec){$nec='DEC';}else{$nec='TEC';}
			$t="<?php /*000||*/".chr(10)."\$key='$key';".chr(10);
			if(property_exists($key,'name')){$o=new $key; $t.='$name="'.$o->name.'";'.chr(10);}
			if(property_exists($key,'ver')){$o=new $key; $t.='$ver="'.$o->ver.'";'.chr(10);}
			if(property_exists($key,'info')){$o=new $key; $t.='$info="'.$o->info.'";'.chr(10);}
			if(in_array($_POST['key'],$bootPW4)){$t.='$boot=true;'.chr(10);}
			$t.="\$program=<<<$nec".chr(10)."class $key{";
			//if(!empty($_POST['name'])){$t.='	var $name="'.$_POST['name'].'";'.chr(10);}
			$t.=chr(10).$text."$nec;".chr(10);
			if(isset($_POST['installPack'])){
				$t=$t.chr(10).'//test';
			}
			$f=fopen($_POST['nameFile'],'w'); fwrite($f,$t); fclose($f);
			$this->view='pack';
		}//if $p
	}
}//saveProgram

private function saveBios(){
	$cont=file(__FILE__);
	global $biosPW4;
	$ver=""; $t=''; $nec=true; $dec=true; $z=false;
	foreach($cont as $v){
		if(substr($v,0,9)=='/*|Bios*/'){$z=true; continue;}
		if(substr($v,0,12)=='/*|EndBios*/'){break;}
		if($z==true){
			for($i=0;$i<strlen($v);$i++){
				switch(substr($v,$i,1)){case '\\': case '$': $t.='\\';}
				$t.=substr($v,$i,1);
			}
			if(substr($v,0,4)=='NEC;'){$nec=false;}
			if(substr($v,0,4)=='DEC;'){$dec=false;}
		}

	}
	if($z==true){
		if(empty($t)){
			$this->view='notBios';
		}else{
			if($nec==true){$nec="NEC";}elseif($dec==true){$nec='DEC';}else{$nec='TEC';}
			$t='<?php /*00|00*/'.chr(10)
				.'$keyBios="'.$biosPW4.'";'.chr(10)
				.'$packBios=<<<'.$nec .chr(10).$t."$nec;".chr(10);
			if(property_exists($biosPW4,'ver')){$o=new $biosPW4; $ver="_v".$o->ver;}
			$f=fopen($biosPW4.$ver."_pack.php",'w'); fwrite($f,$t); fclose($f);
			$this->view='pack';
		}

	}
}//saveBios() - сохранение биоса.

private function nameFileTest(){
	if(!empty($_POST['nameFile'])){
		if(file_exists($_POST['nameFile'])){
			$this->view='remove';
		}else{
			$this->saveProgram();
		}
	}
}//nameFileTest() - Проверка на существования файла по имени.

public function start(){
	if(isset($_POST['keyNec'])){$this->view='form';}
	if(isset($_POST['keysNec'])){
		switch($_POST['keysNec']){
			case 'saveProgram': $this->nameFileTest(); break;
			case 'home': $this->view='home'; break;
			case 'saveBios': $this->saveBios(); break;
			case 'info': $this->view='info'; break;
			case 'remove': $this->saveProgram(); break;
		}
	}
}//start() - Стартовая Функция для обработки Функционала.

public function view(){
	echo <<<NEC
<style>
#packNec{background:#ffc;padding:2px;}
#headNec,#footerNec,#messageNec,#formNec{background:#444;padding:2px 5px;color:#fff;}
#keysNec{margin:0;}
.keyNec{
	display:block; border:1px solid #333; outline:none; background:#777; padding:1px 5px;
	width:100%; margin:1px 0; color:#ff9; text-align:left;
	}
#footerNec{font-size:14px;}
#footerNec span{float:right; text-align:right; display:inline-block;}
.keyFooNec{outline:none;background:none;border:none;padding:0;text-decoration:underline;color:#ff9;}
.keyNec:hover,.keyNecOk:hover,#formNec button:hover{color:#9f9;background:#666;}
.keyFooNec:hover{color:#9f9;}
.keyNec:active,.keyFooNec:active,.keyNecOk:active,#formNec button:active{color:#faa;}
#messageNec{border:1px solid #333; padding:5px 5px; text-align:center;}
.keyNecOk,#formNec button{
	margin:5px 0; outline:none; border:1px solid #333; background:#777; color:#ff9; padding:5px 10px;
	}
#formNec{padding:10px 0px;}
#formNec div{width:260px; margin:0 5px;}
#formNec input{
	display:block; width:97%; margin:0 0 10px 0;
	background:#555; color:#fff;
	border:1px solid #ff9; border-radius:5px;
	padding: 2px 5px;
}
#formNec input:focus,#formNec input:hover{
	outline:none; background:#777; border-color:#333;
}
#formNec label{color:#ff9; font-size:14px;}
#formNec button{margin:0;}
#infoNec{
	outline:none; background:none; border:none; color:#fff;
	float:right; text-align:right; padding:0;
}
#infoNec:hover{text-decoration:underline;}
#infoNec:active{color:#99f;}
</style>
<form id=packNec method=POST>
NEC;
	switch($this->view){
		case 'home': $this->viewHome(); break;
		case 'form': $this->viewForm($_POST['keyNec']); break;
		case 'pack': $this->messageView('Сохранено'); break;
		case 'info': $this->info(); break;
		case 'notBios': $this->messageView('Bios не найден!'); break;
		case 'remove': $this->removeView(); break;
	}
	echo '</form>';
}//view() - Функция для вивода содержмого на экран.

private function info(){
	$t="<span style='color:#9f9;'><b>$this->name ver $this->ver</b></span>"
		." - <span style='color:#f99;'>$this->info</span> <br>";
	foreach(explode(chr(10),$this->desc) as $v){
		$arr=explode("-",$v);
		$arr[0]="<span style='color:#ff9;'>".$arr[0]."</span>";
		$t.=implode("-",$arr)."<br>";
	}
	$this->messageView("<div style='text-align:left;font-size:13px; margin-bottom:-10px;'>".$t."</div>");
}//info() - Вивод информации о программе.

private function viewHome(){
	global $keysPW4;
	echo '<div id=headNec>Выберите программу для упаковки:</div><div id=keysNec>';
	foreach($keysPW4 as $v){
		$o=new $v; if(isset($o->name)){$n=$o->name;}else{$n=$v;}
		echo "<button class=keyNec type=submit name='keyNec' value='$v'>$n</button>";
	}
	echo '</div><div id="footerNec">
		<button class="keyFooNec" type="submit" name="keysNec" value="saveBios">Упаковать Bios</button>
		<button id=infoNec name=keysNec type=submit value=info>'.$this->name.' v:'.$this->ver.'</button>
	</div>';
}//viewHome() -

private function removeView(){
	if(!empty($_POST['nameFile']) and !empty($_POST['nameClass']) and !empty($_POST['key'])) {
		$key = $_POST['key'];
		$nameFile = $_POST['nameFile'];
		$nameClass = $_POST['nameClass'];
		echo <<<NEC
<div id='messageNec' style='color:#fff;'>Файл с именем <span style='color:#ff9;'>$nameFile</span> существует!!!<br>
	<button class='keyNecOk' type=submit value=remove name=keysNec>Перезаписать</button>
	<button class='keyNecOk' type=submit value='$key' name=keyNec>Назад</button>
	<input type='hidden' name='nameFile' value='$nameFile'>
	<input type='hidden' name='nameClass' value='$nameClass'>
	<input type='hidden' name='key' value='$key'>
</div>
NEC;
	}
}//removeView() - Вывод сообщения на перезапись файла.

private function messageView($str){
	echo "<div id='messageNec'>$str<br>";
	echo "<button class='keyNecOk' type=submit value=home name=keysNec>Ок</button>";
	echo "</div>";
}//messageView() - Вывод сообщения с кнопкой Ок.

private function viewForm($key){
	$ver=''; $o=new $key; if(isset($o->ver)){$ver="_v".$o->ver;} unset($o);
	echo <<<NEC
<div id="formNec"><div>
<label>Имя класса:</label>
<input type=text name='nameClass' value='$key'>
<label>Имя сохраняемого файла:</label>
<input type=text name='nameFile' value='{$key}{$ver}_pack.php'>
<!--name prog: <input type=text name=name><br>-->
<!--Упаковать в установщик: <input type='checkbox' name='installPack'><br-->
<button type=submit name=keysNec value='saveProgram'>Сохранить</button>
<button type=submit name=keysNec value='home'>Отмена</button>
<input type='hidden' name='key' value='$key'>
</div></div>
NEC;
}//viewForm
}//class packNec;
/*<|PackNEC*/

/*>|cod51*/
class cod51{
	public $info='test cod51';
	public function start(){}//start() - Стартовая Функция для обработки Функционала.
	public function view(){
		echo 'class cod51';
		echo "<div id='test'>error js</div>";
	}//view() - Функция для вивода содержмого на экран.
	//public function boot(){}//boot() - Boot приложение.
	public function script(){
		//echo "</script><script>";
		return "document.getElementById('test').innerHTML='test js';";
	}
}//end class cod51;
/*<|cod51*/

/*>|sql_console*/
class sql_console{

	public $name="SQL console";
	public $ver="beta";
	//public $info="text text text";

	private $view="home";
	public $base;
	public $error;
	protected $connection;

	const HOST="127.0.0.1:3306";
	const USER="root";
	const PASS="";
	const BASE="mysql";
/*
public function query($sql){
	$this->connection->query($sql);
}
/*
public function escape($str){
	return mysqli_escape_string($this->connection, $str);
}
*/
public function connect($host=self::HOST,$user=self::USER,$pass=self::PASS,$base=self::BASE){
	if(!empty($this->base)){$base=$this->base;}
	$this->connection=new mysqli($host,$user,$pass,$base);
	if(mysqli_connect_errno()){
		$this->error=mysqli_connect_errno();
	}
}

public function error(){
	echo $this->error;
	switch($this->error){
		case 1045: echo ": Неправильный логин или пароль!"; break;
		case 1049: echo ": Неправильное имя базы данных!"; break;
		case 2002: echo ": Неправильно указан хост!"; break;
		default: echo ": Неизвестная ошибка!";
	}//switch
	echo "<form method='POST'><button type='submit' name='sql' value='|reset'>Reset</button></form>";
}

public function start(){
	//$var=debug_backtrace();
	//if(isset($var[1]['class']) and $var[1]['class']!='PhpWav4_v3'){
		//$this->view="er1";
	//}else{
		if(session_id() == false){session_start();}
		if(!empty($_POST['sql'])){
			if($_POST['sql']=="|reset"){
				unset($_SESSION['sql_base']);
				unset($_POST['sql']);
			}
			if(substr($_POST['sql'],0,3)=="use"){
				$_SESSION['sql_base']=trim(substr($_POST['sql'],4));
			}
			if(
				substr($_POST['sql'],0,13)=="drop database" and
				$_SESSION['sql_base']==trim(substr($_POST['sql'],14))
			){
				unset($_SESSION['sql_base']);
			}
		//}
		if($_SESSION['sql_base']){$this->base = $_SESSION['sql_base'];}
		error_reporting(0);
		$this->connect();
		if(!empty($this->error)){$this->view="er2";}
	}
	//$this->mysqli->query("set names 'utf8'");
}//start() - Стартовая Функция для обработки Функционала.

public function view(){
	switch($this->view){
		case "home": $this->console(); break;
		case "er1": echo "Error not PhpWav4 v3..."; break;
		case "er2": $this->error(); break;
	}

/*
	//$this->connect();

/**/
}//view() - Функция для вивода содержмого на экран.

private function console(){
	function sel($s){
		$s=implode("'",explode('"',$s));
		$s1=chr(10);
		$s2=chr(13);
		switch(substr($s,strlen($s)-1,1)){
			case " ": case $s1: case $s2:
			return sel(substr($s,0,strlen($s)-1));
			case ";": return $s;
			default: return $s.";";
		}
	}//sel() - рекурсивная функция добовляет точку с запетой;

	function res($res){

	}//res() - Оброботка ответ от запроса;

	if(empty($_POST["sql"])){$sql="";}else{$sql=$_POST["sql"];}
	if(!empty($_POST['sql'])){
		$sql=$_POST['sql'];

	}
	echo "
<style>
#sql div{border:1px solid #555; margin:5px; background:#fff; padding:0 5px;}
#sql table{border-collapse:collapse; margin:5px; background:#fff;}
#sql td,#sql th{border:1px solid #555; padding:0 5px;}
</style>
	";
	echo "<form id='sql' method='POST'>";
	echo "<textarea style='width:98%; height:120px;' name=sql>$sql</textarea>";
	echo "<br><input type='submit' value='Отправить'>";
	echo " Database: <b>";
	if(!empty($this->base)){echo $this->base;}else{echo self::BASE;}
	echo "</b>";
	if(!empty($_POST["sql"])) {
		$z=true;
		$start=microtime(true);
		$res = $this->connection->query($sql);
		$start=round(microtime(true)-$start,3);
		//echo 'Время выполнения: '.(microtime(true)-$start).' сек.';
		switch(gettype($res)){
			case "object":
				echo ", Time: $start сек.";
				echo "<table>";
				while($row = $res->fetch_assoc()){
					if($z==true){
						echo "<tr>";
						foreach($row as $k => $v){echo "<th>$k</th>";}
						echo "</tr>";
						$z=false;
					}
					echo "<tr>";
					foreach($row as $v){echo "<td>$v</td>";}
					echo "</tr>";
				}
				echo "</table>";
				break;
			case "boolean":
				echo "<div>";
				if($res == true){
					echo "Query OK, ($start сек)";
				}else{
					echo "Error ".$this->connection->errno.": ".$this->connection->error;
				}
				echo "</div>";
				break;
		}
	}
	if(isset($_POST['count'])){$count=$_POST['count'];}else{$count=1;}
	if(!empty($_POST['add'])){
		echo "<hr>";
		$sql=sel($sql);
		$arr=explode("|",$_POST['add']);
		$add=$sql.'|'.implode("|",$arr);
		$count++; $c=$count-1;
		for($i=0;$i<count($arr) and $i<3; $i++){
			echo "<div style='border:1px solid #777;'>".($c--).": ".$arr[$i];
			echo "</div>";
		}
	}else{$add=$sql;$count=1;}
	echo "<input type='hidden' name='count' value='$count'>";
	echo '<input type="hidden" name="add" value="'.$add.'">';

	echo "</form>";
}

	private function connect_form(){
		echo "
			<div>Host: <input type='text' name='host' value='".self::HOST."'></div>
			<div>User: <input type='text' name='user' value='".self::USER."'></div>
			<div>Pass: <input type='text' name='pass' value='".self::PASS."'></div>
			<div>Base: <input type='text' name='base' value='".self::BASE."'><div/>
			<div><input type='submit' name='key' value='Отправить'></div>
		";
	}

}//end class sql_console;
/*<|sql_console*/

/*>|PhpWav4_v3*/
class PhpWav4_v3{
	public $name="PhpWav4 v3";
	public $ver="3.03";//от 22.12.16;
	public $info="PhpWav v3 OC";
	public $desc=<<<NEC
26.12.16 v3.01 - Добавлена домашная страница
06.01.17 v3.02 - Переим. функц. PW4v3() на _xml(), добв. центральный блок, Функц. _message, _form
12.01.17 v3.03 - Список программ виводит только программы и + мелкие исправления в коде.
00.02.17 v3.04 - ..Поддержка скриптов..
NEC;

	private $view=false;

private function keys(){
	global $keysPW4; $keys=''; $head='';
	foreach ($keysPW4 as $v){
		if(property_exists($v,'name')){$o=new $v; $n=$o->name; unset($o);}else{$n=$v;}
		if(property_exists($v,'info')){$o=new $v; $t=$o->info;}else{$t='';}
		if(isset($_SESSION['PW4v3']) and $v==$_SESSION['PW4v3']){
			$head="<div id='headPW4v3'>$n</div>";
			$h=" hoverPW4";
		}else{$h='';}
		if(method_exists($v,'start') and method_exists($v,'view')){
			if(method_exists($v,'script')){
				$keys.="<button title='$t' class='keyPW4b keyPW4$h' name='PW4v3' value='$v'>$n</button>";
				continue;
			}
			$keys .= "<a title='$t' class='keyPW4$h' onclick=_xml('?PW4v3=$v','PW4v3')>$n</a>";
		}else if(method_exists($v,'boot')){
			//$keys .= "<a title='$t' class='keyPW4$h' >$n</a>";
		}
	}
	echo <<<NEC
<div id="menuUpPW4">
	<div class="menuKeyPW4">
		<div class="nameMenuKeyPW4">PhpWav4</div>
		<div class="menuOpenPW4">
			<a class="keyPW4" onclick=_xml("?PW4v3=reset","PW4v3")>Перезапуск</a>
			<a class="keyPW4" href="/">Выход</a>
		</div>
	</div>
	<div class="menuKeyPW4">
	<div class="nameMenuKeyPW4">Программы</div>
		<form method="POST" class="menuOpenPW4" id="keysPW4">
			$keys
		</form>
	</div>
</div>
$head
NEC;
}

private function message($str){
	unset($_SESSION['PW4v3']);
	$this->keys();
	echo "<div id='messagePW4v3'><b>Сообщение:</b> $str <b>!</b></div>";
}

public function boot(){
	if(session_id()==false){session_start();}
	/*if(isset($_GET['PW4v3s'])){
		switch($_GET['PW4v3s']){
			case "view":
				//$this->setting();
				break;
		}
		exit;
	}*/
	if(isset($_POST['PW4v3'])){
		if(
			class_exists($_POST['PW4v3']) and
			method_exists($_POST['PW4v3'],'start') and
			method_exists($_POST['PW4v3'],'view')
		){
			$_SESSION['PW4v3']=$_POST['PW4v3'];
		}else{
			$this->message('error not is program');
		}
	}
	if(isset($_GET['PW4v3'])){
		if($_GET['PW4v3']=='reset'){
			unset($_SESSION['PW4v3']);
			$this->message('Перезапуск выполнен');
		}else if(class_exists($_GET['PW4v3'])){
			$o=new $_GET['PW4v3'];
			if(method_exists($o,'start') and method_exists($o,'view')){
				$_SESSION['PW4v3']=$_GET['PW4v3'];
				$o->start();
				$this->keys();
				$o->view();
			}else if(method_exists($o,'boot')){
				$this->message('Загрузочная программа');
			}else{
				$this->message('Ненайдены: boot, start, view');
			}
		}else{
			$this->message("Неизвесная команда '<b>{$_GET['PW4v3']}</b>'");
		}
		exit;
	}
	if(!empty($_SESSION['PW4v3']) and class_exists($_SESSION['PW4v3'])){
		$o=new $_SESSION['PW4v3'];
		if(method_exists($o,'start')){$o->start();}
		$this->view=true;
	}

	//var_dump($_POST['scriptPW4v3']);
	/*===============================*/

	echo <<<NEC
<html>
<head>
<title>PhpWav4</title>
<meta charset="utf-8">
<meta name=viewport content="width=device-width, initial-scale=1">
<style>
	body{margin:0;background:#eed;}
	#headPW4v3{background:#535;text-align:center;color:#ffd;font-weight:900;}
	#messagePW4v3{padding:5px; text-align:center; border:1px solid #444; background:#fff;}
	#menuUpPW4{background:#757; font-size:14px;}
	.menuKeyPW4{display:inline-block;color:#fff;}
	.nameMenuKeyPW4{padding:2px 4px;}
	.keyPW4{padding:2px 8px; display:block; text-decoration:none; color:#fff;}
	.keyPW4b{background:none; border:none; outline:none; width:100%; text-align:left;}
	.hoverPW4,.keyPW4:active{color:#006;}
	.menuOpenPW4{display:none;background:#979;border:1px solid #444;position:absolute;}
	.menuKeyPW4:hover,.keyPW4:hover{background:#99f;cursor:pointer;}
	.menuKeyPW4:hover .menuOpenPW4{display:block;}
	#home{background:#fff; border:1px solid #444; font-size:20px;text-align:center; padding: 10px;}
	#PW4v3block{
		width:100%; height:100%; position:fixed; top:0; left:0; overflow:auto;
		background:rgba(0,0,0,0.5); border:none; outline:none; display:none;
	}
	#PW4v3center{
		display:inline-block; border:solid 1px #000; box-shadow:5px 5px 3px rgba(0,0,0,0.5);
		background:#fff; padding:0px;
	}
	#PW4v3message{display:block; border:none; font-size:15px;}
</style>
</head>
<body>
<div id="PW4v3">
NEC;
	$this->keys();
	if($this->view==true){
		if(isset($o) and method_exists($o,'view')){$o->view();}
	}else{
		echo "<div id='home'>Добро пожаловать в <b>PhpWav4</b> ver {$this->ver}</div>";
	}
	echo <<<NEC
</div><!--PW4v3-->
<button id='PW4v3block'><div id='PW4v3center'><div id='PW4v3message'></div></div></button>
<script>
function _xml(str,id){
	var xmlhttp;
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
		 	document.getElementById(id).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET",str,true);
	xmlhttp.send();
}
function _form(form,id){
	var text="",g=false,arr=[].slice.call(form);
	for(var i=0; i<arr.length; i++){
		switch(arr[i].type){
			case "checkbox": if(arr[i].checked!=true){break;}
			default:
				if(arr[i].name && arr[i].value) {
					if(g){text+="&";}else{text+="?"; g=true;}
					text+=arr[i].name+"="+arr[i].value;
				}
		}
	}
	_xml(text,id);
	console.log(text);
}
function _message(get){
	if(get=='reset'){
		document.getElementById('PW4v3block').style.display='none';
	}else{
		document.getElementById('PW4v3block').style.display='block';
		_xml(get,'PW4v3message');
	}
}
</script>
NEC;
	if(isset($o) and method_exists($o,'script')){
		echo "<script>".chr(10);
		echo $o->script();
		echo chr(10)."</script>";
		echo "<div id='headPW4v3'>script on</div>";
	}
echo <<<NEC
</body>
</html>
NEC;
	exit;
}//boot() -
}//end class PhpWav4_v3;
/*<|PhpWav4_v3*/

/*>|program_manager*/
class program_manager{
	public $name='Program Manager';
	public $ver='1.0';//>09.02.17-12.02.17;
	public $info='Менеджер программ';
	public $desc=<<<NEC
09.02.17 по 12.02.17 v1.0 - Разработка и создание программы.
NEC;
	private $view='home';

public function remove($name){
	if(!empty($name) and file_exists($name)){
		$f=fopen($name,'r'); $t=fread($f,13); fclose($f);
		if(substr($t,8,5)=='000||'){
			include($name);//
			unset($t);
			if(!empty($key) and !empty($program)  and class_exists($key)){
				$t=''; $z=true;
				foreach(file(__FILE__) as $v){
					if(substr($v,0,strlen($key)+6)=="/*>|$key*/"){$z=false; $t.=$v;}
					if(substr($v,0,strlen($key)+6)=="/*<|$key*/"){$z=true; $t.=$program.chr(10);}
					if($z==true){$t.=$v;}
				}
				if($z==true){
					$this->view="okRem";
					$f=fopen(__FILE__,'w'); fwrite($f,$t); fclose($f);
				}else{
					$this->view='erRem';
				}
			}
		}
	}
}//remove() - Перезапись программы.

public function install($name){
	if(file_exists($name)){
		$f=fopen($name,'r'); $t=fread($f,13); fclose($f);
		if(substr($t,8,5)=='000||'){
			include($name);//
			if(!empty($key) and !empty($program)){
				global $keysPW4,$bootPW4;
				$arr=file(__FILE__);
				$t='';
				foreach($arr as $v){
					if(substr($v,0,9)=='/*|keys*/'){
						$t.='/*|keys*/ $keysPW4=array('."'$key','".implode("','",$keysPW4)."');".chr(10);
						continue;
					}
					if(isset($boot) and $boot==true and substr($v,0,9)=='/*|boot*/'){
						$t.='/*|boot*/ $bootPW4=array('."'$key','".implode("','",$bootPW4)."');".chr(10);
						continue;
					}
					if(substr($v,0,13)=='/*|programs*/'){
						$t.=$v.chr(10)."/*>|$key*/".chr(10).$program.chr(10)."/*<|$key*/".chr(10);
						continue;
					}
					$t.=$v;
				}
				$f=fopen(__FILE__,'w'); fwrite($f,$t); fclose($f);
				$this->view='okIns';
			}else{
				$this->view='erIns';
			}
		}
	}
}//install() - Установка программы.

public function delete($key){
	global $keysPW4,$bootPW4;
	function keys($n,$key,$keys){
		unset($keys[array_search($key,$keys)]);
		if($keys==array()){$t='';}else{$t="'".implode("','",$keys)."'";}
		return '/*|'.$n.'*/ $'.$n.'PW4=array('.$t.');'.chr(10);
	}
	if(class_exists($key) and in_array($key,$keysPW4)){
		$arr=file(__FILE__);
		$t=''; $z=true; $b=false; $g=0;
		if(in_array($key,$bootPW4)){$b=true;}
		foreach($arr as $v){
			if($g){$g--; continue;}
			if(substr($v,0,strlen($key)+6)=="/*>|$key*/"){$z=false; continue;}
			if(substr($v,0,strlen($key)+6)=="/*<|$key*/"){$z=true; $g=1; continue;}
			if($z==true){
				if($b==true and substr($v,0,9)=='/*|boot*/'){
					$t.=keys('boot',$key,$bootPW4); $b=false;
					continue;
				}
				if(substr($v,0,9)=='/*|keys*/'){
					$t.=keys('keys',$key,$keysPW4);
					continue;
				}
				$t.=$v;
			}
		}
		if($z==true){
			$f=fopen(__FILE__,'w'); fwrite($f,$t); fclose($f);
			$this->view='okDel';
		}else{
			$this->view='erDel';
		}
	}
}//delete() - Удаление программы.

public function start(){
	if(isset($_POST['keyPM'])){
		switch($_POST['keyPM']){
			case 'home': $this->view='home'; break;
			case 'install': $this->view='install'; break;
		}
	}
	if(isset($_POST['infoPM']) and class_exists($_POST['infoPM'])){$this->view="info";}
	if(isset($_POST['installPM'])){$this->view='installProgram';}
	if(isset($_POST['keyInsPM'])){$this->install($_POST['keyInsPM']);}
	if(isset($_POST['deletePM'])){$this->view='delete';}
	if(isset($_POST['keyDelPM'])){$this->delete($_POST['keyDelPM']);}
	if(isset($_POST['removePM'])){$this->remove($_POST['removePM']);}
}//start() - Стартовая Функция для обработки Функционала.

public function view(){
	echo <<<NEC
<style>
#headPM{background:#333; padding:0 2px; padding-top:2px; color:#fff;}
#headPM div{display:inline-block; float:right; color:#fff; margin:0 5px;}
#footer{background:#333; padding:0 2px; color:#fff;}
#tablePM{border:solid 2px #333; background:#777; border-collapse:collapse;}
#tablePM td{border:solid 1px #333;}
.keysPM,.keysDelPM,.keysInsPM,.keysMesPM{
	border:0; width:100%; height:20px;text-align:left; background:#555; color:#eef;outline:none; padding:1px 5px;
}
.keysMesPM{margin:2px;width:auto;border:1px solid #777;}
.keysInsPM{width:auto; border:1px solid #777;}
.keysDelPM{color:#fee;} .keysDelPM:hover{background:#877;} .keysDelPM:active{background:#977; color:#fdd;}
.keysPM:hover,.keysInsPM:hover,.keysMesPM:hover{background:#888;}
.keysPM:active,.keysInsPM:active,.keysMesPM :active{background:#444;}
</style>
NEC;
	echo '<form method="post" style="background:#333;">';
	switch($this->view){
		case 'home': $this->viewHome(); break;
		case 'install': $this->viewInstall(); break;
		case 'info': $this->viewInfo(); break;
		case 'okDel': $this->message('Программа удалена.'); break;
		case 'okIns': $this->message('Программа установлена.'); break;
		case 'installProgram': $this->installProgram(); break;
		case 'delete': $this->deleteProgram(); break;
		case 'okRem': $this->message('Программа перезаписана.');break;
		case 'erRem': $this->message('Ошыбка перезаписи: Не найдено окончиние программы!'); break;
		case 'erDel': $this->message('Ошыбка удаления: Не найдено окончиние программы!'); break;
		case 'erIns': $this->message('Ошыбка Установки: Нет ключа или программы для установки!'); break;
	}
	echo '</form>';
}//view() - Функция для вивода содержмого на экран.

private function installProgram(){
	if(isset($_POST['installPM']) and file_exists($_POST['installPM'])){
		include($_POST['installPM']);
		if(!empty($key) and class_exists($key)){
			if(property_exists($key,'ver')){$o=new $key; $v=" <b>v".$o->ver."</b>"; unset($o);}else{$v='';}
			if(empty($name)){$name=$key;}
			if(!empty($ver)){
				$ver=", перезаписать на: <b>v$ver</b>";
			}else{
				$ver=" перезаписать на: <b>{$_POST['installPM']}</b>";
			}
			$t="<style>b{color:#cfc;font-weight:500;}</style>";
			$t.="Программа уже установленна: $name".$v."$ver?";
			$u="name='removePM' value='{$_POST['installPM']}'";
			$this->message($t,'Назад',"name='keyPM' value='install'","Перезаписать",$u);
		}else if(!empty($key)){
			if(empty($name)){$name=$key;}
			if(!empty($ver)){$ver=' v'.$ver;}else{$ver='';}
			$t="Установить программу: $name"."$ver?";
			$u="name='keyInsPM' value='{$_POST['installPM']}'";
			$this->message($t,'Назад',"name='keyPM' value='install'",'Установить',$u);
		}else{
			$this->message('Нет ключа для установки!!!','Назад',"name='keyPM' value='install'");
		}
	}
}

private function deleteProgram(){
	if(isset($_POST['deletePM']) and class_exists($_POST['deletePM'])){
		$v=$t=$_POST['deletePM'];
		if(property_exists($t,'name')){$o=new $t; $t=$o->name; unset($o);}
		$t="Удалить: $t !!!";
		$this->message($t,"Отмена",false,'Удалить',"name='keyDelPM' value='$v'");
	}
}

private function message($str='message',$key2=false,$url2=false,$key1=false,$url1=false){
	echo "<div id='footer' style='background:#333;padding:2px;'>
		<div style='text-align:center;background:#444;color:#fff;'><div>$str</div>";
	if($key1!=false and $url1!=false){
		echo "<button class='keysMesPM' $url1>$key1</button>";
	}
	if($key2!=false and $url2!=false){
		echo "<button class='keysMesPM' $url2>$key2</button>";
	}else if($key2!=false and $url2==false){
		echo "<button class='keysMesPM' name='keyPM' value='home'>$key2</button>";
	}else{
		echo "<button class='keysMesPM' name='keyPM' value='home'>OK</button>";
	}
	echo "</div></div>";
}//message() - Функция вивода сообщений.

private function viewInfo(){
	if(!empty($_POST['infoPM']) and class_exists($_POST['infoPM'])){
		$name=$_POST['infoPM']; $o=new $name; $ver=''; $desc=''; $info='';
		if(property_exists($o,'name')){$name=$o->name;}
		if(property_exists($o,'ver')){$ver='<span style="color:#cfc;">v'.$o->ver.'</span>';}
		if(property_exists($o,'info')){$info='- '.$o->info;}
		if(property_exists($o,'desc')){
			$desc.="<div style='color:#aaa;text-align:center;'>Описание</div><div>";
			foreach(explode(chr(10),$o->desc) as $v){
				$arr=explode('-',$v);
				$arr[0]="<span style='color:#ddf;'>{$arr[0]}</span>";
				$desc.=implode('-',$arr)."<br>";
			}
			$desc.='</div>';
		}
		echo <<<NEC
<style>
#content{padding:2px; background:#333;color:#fff; font-size:14px;}
</style>
<div id="headPM"><button class="keysInsPM" name="keyPM" value="home">Назад</button></div>
<div id="content" style='border:1px solid #777; margin:2px;'>
	<div><b style='color:#ffd;'>$name</b> $ver $info.</div>
	$desc
</div>

NEC;
	}
}//viewInfo() - Вывод информации о программе.

private function viewInstall(){
	$table='';
	foreach(scandir('.') as $v){
		if(is_file($v) and substr($v,strlen($v)-3,3)=='php' and filesize($v)>0){
			$f=fopen($v,'r'); $t=fread($f,13); fclose($f);
			if(substr($t,8)=='000||'){
				$table.="<tr><td style='width:100%;'>
					<button class='keysPM' name='installPM' value='$v'>$v</button></td></tr>";
			}
		}
	}
	echo <<<NEC
<div id='headPM'>
	<button class='keysInsPM' name='keyPM' value='home'>Назад</button>
	<span style='padding:0 4px;'>Выберите программу для установки:</span>
</div>
<table id='tablePM' style='width:100%;'>
$table
</table>
<div id='footer'> - все установочные файлы должны находится вместе с файлом PhpWav4.php .</div>
NEC;
}//viewInstall() - Просмотр упакованых файлов.

private function viewHome(){
	global $keysPW4;
	$table='';
	foreach($keysPW4 as $v){
		if(property_exists($v,'name')){$o=new $v; $n=$o->name; unset($o);}else{$n=$v;}
		//if(property_exists($v,'ver')){$o=new $v; $ver='v'.$o->ver; unset($o);}else{$ver='';}
		$table.="<tr><td style='width:100%;'>
			<button class='keysPM' name='infoPM' value='$v'>$n</button></td><td>
			<button class='keysDelPM' name='deletePM' value='$v'>Удалить</button></td></tr>";
	}
	$n=count($keysPW4);
	echo <<<NEC
<div id='headPM'>
	<button class='keysInsPM' name='keyPM' value='install'>Установить программу</button>
	<div>Кол-во программ: $n.</div>
</div>
<table id='tablePM'>$table</table>
NEC;
}//viewHome() - домашная страница.

	//public function boot(){}//boot() - Boot приложение.
}//end class program_manager;
/*<|program_manager*/

/*endProgram*/

/*|Bios*/
class biosPW4{
	public $ver='1.2';
	public $desc=<<<NEC
10.12.16 v1.1 - Добавлена проверка start и view, запуск boot .
21.12.16 v1.2 - Одоптация под оболочку PhpWav4 v1.1
NEC;
	private function viewBoot(){
		echo "<b>Not boot</b> - bios v{$this->ver}<br>";
		global $keysPW4;
		if(!empty($keysPW4)){foreach($keysPW4 as $v){
			echo "[<a style='color:blue;' href='?bootPW4=$v'>$v</a>] ";
		}}else{echo 'Not programs !';}
		echo '<br>[<a style="color:red;" href="?biosPW4=exit">Exit</a>]<hr>';
	}//viewBoot
	public function boot(){
		session_start();
		if(!empty($_GET['biosPW4']) and $_GET['biosPW4']=='exit'){
			unset($_SESSION['bootPW4']);
			header('location:/');
		}//bios exit
		if(!empty($_GET['bootPW4'])){$_SESSION['bootPW4']=$_GET['bootPW4'];}
		if(isset($_SESSION['bootPW4']) and class_exists($_SESSION['bootPW4'])){
			$o=new $_SESSION['bootPW4'];
			if(method_exists($o,'start')){$o->start();}else{
				if(method_exists($o,'boot')){$o->boot(); exit;}
			}
			$this->viewBoot();
			if(method_exists($o,'view')){$o->view();}else{echo "not view";}
		}else{$this->viewBoot();}
	}//boot
}//class biosPW4
/*|EndBios*/

function bootPW4(){
	global $bootPW4,$biosPW4;
	if($bootPW4!=array()){foreach ($bootPW4 as $v){
		if(class_exists($v) and method_exists($v,'boot')){$o=new $v; $o->boot(); exit;}
	}}
	if(class_exists($biosPW4) and method_exists($biosPW4,'boot')){$o=new $biosPW4; $o->boot(); exit;}
	echo '<b>Not boot !</b>';
}//bootPW4()

bootPW4();
/*PhpWav4 v1.1 WavixSan*/
//21.12.16 v1.1 - Переделан boot и bios;
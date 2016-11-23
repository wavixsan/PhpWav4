<?php /*000||*/
$keyProg='InstallPrograms';
$program=<<<DEC
class InstallPrograms{
	var \$name='Install Programs';
	var \$info="Устанавливает программы в PhpWav4.";
	var \$vers='1.01';
	var \$view='home';
	var \$desc=<<<NEC
13.11.16 v.1.01 - Добавлено установка boot.
NEC;
	
	function nam(){
		\$a=\$_SERVER["SCRIPT_NAME"]; \$b="";
		for(\$i=0; \$i<strlen(\$a); \$i++){if(substr(\$a,\$i,1)=="/"){\$b="";}else{\$b.=substr(\$a,\$i,1);}}
		return \$b;
	}//nam() - имя текущего файла или файл который вызывает эту функцию.
	
function installProg(\$f){
	include(\$f);
	if(!empty(\$keyProg) and !empty(\$program)){
		//\$f=file('PhpWav4.php'); 
		\$f=file(\$this->nam());
		\$t=""; \$this->view='installComplete';
		foreach(\$f as \$v){
			if(substr(\$v,0,13)=="/*|keysProg*/"){
				if(strpos(\$v,'"'.\$keyProg.'"') or strpos(\$v,"'".\$keyProg."'")){
					\$this->view="err2"; break;
				}//error
				global \$keysProgPW4;
				\$t.="/*|keysProg*/ \\\$keysProgPW4=array('\$keyProg'";
				foreach(\$keysProgPW4 as \$val){\$t.=",'\$val'";}
				\$t.=");".chr(10);
				continue;
			}
			if(substr(\$v,0,13)=="/*|programs*/"){
				\$t.=\$v.chr(10)."/*>|\$keyProg*/".chr(10).\$program.chr(10)."/*<|\$keyProg*/".chr(10);
				continue;
			}
			\$t.=\$v;
			if(!empty(\$boot) and substr(\$v,0,9)=='/*|boot*/'){\$t.="	return '\$keyProg';".chr(10);}
		}
		if(\$this->view=="installComplete"){
			\$f=fopen(\$this->nam(),'w'); fwrite(\$f,\$t); fclose(\$f);
			//\$f=fopen('test.php','w'); fwrite(\$f,\$t); fclose(\$f);
		}
	}else{\$this->view='err1';}//error
}//installProg()

function start(){
	if(!empty(\$_POST['keyInsProg'])){switch(\$_POST['keyInsProg']){
		case 'home': \$this->view='home'; break;
		default :
			if(file_exists(\$_POST['keyInsProg'])){
				\$str=file(\$_POST['keyInsProg']);
				if(substr(\$str[0],8,5)=="000||"){
					unset(\$str);
					\$this->installProg(\$_POST['keyInsProg']);
				}
			}else{\$this->view='err0';}//error
	}}
}

function viewHome(){
	echo 'Выберите файл для установки!';
	echo '<div id="contentInsProg">';
	foreach(scandir('.') as \$v){
		if(is_file(\$v) and substr(\$v,strlen(\$v)-3,3)=='php' and filesize(\$v)>0){
			\$f=file(\$v);
			switch(substr(\$f[0],8,5)){
				//case "0000|": echo "<a style='color:blue;display:block;'>\$v</a>"; break;
				//case "000|0": echo "<a style='color:#99c;display:block'>\$v</a>"; break;
				case "000||":
	echo "<button type=submit class=keyInsProg name=keyInsProg value='\$v'>\$v</button>";
					break;
				//default: echo "<a style='color:#999;display:block;'>\$v</a>";
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
	switch(\$this->view){
		case 'home': \$this->viewHome(); break;
		case 'installComplete': echo 'программа установлена'; break;
		case 'err0': echo 'неизвестная ошыбка'; break;
		case 'err1': echo 'нет ключа и программы'; break;
		case 'err2': echo 'программа уже установлена'; break;
		default: echo '???';
	}
	if(\$this->view!='home'){
		echo "<button type='submit' name='keyInsProg' value='home'>назад</button>";
		}
	echo <<<NEC
</form>
NEC;
}
}//class
DEC;

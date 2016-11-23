<?php /*000||*/
$keyProg='DeletPrograms';
$program=<<<DEC
class DeletPrograms{
	var \$name='Deleted Programs';
	var \$info="Удаляет программы из PhpWav4";
	var \$vers="1.01";
	var \$desc=<<<NEC
09.11.16 v1.01 - Добавлено удалеие 'boot' .
17.11.16 v1.02 - Правка стилей.
NEC;
	
	var \$view='home';
	var \$nameProg='';
	
	function nam(){
		\$a=\$_SERVER["SCRIPT_NAME"]; \$b="";
		for(\$i=0; \$i<strlen(\$a); \$i++){if(substr(\$a,\$i,1)=="/"){\$b="";}else{\$b.=substr(\$a,\$i,1);}}
		return \$b;
	}//nam() - имя текущего файла или файл который вызывает эту функцию.
	
function start(){
	if(session_id()==false){session_start();}
	if(!empty(\$_POST['nameDelProg'])){
		\$this->view="delet";
		\$_SESSION['nameDelProg']=\$_POST['nameDelProg'];
	}
	if(!empty(\$_POST["keyDelProg"])){switch(\$_POST['keyDelProg']){
		case 'home':
			\$this->view='home';
			unset(\$_SESSION['nameDelProg']);
			break;
		case 'delet': \$this->delet(\$_SESSION['nameDelProg']); break;
	}}
}//start

function delet(\$keyProg){
	global \$keysProgPW4;
	\$o=new \$keyProg; if(isset(\$o->name)){\$this->nameProg=\$o->name;}else{\$this->nameProg=\$keyProg;}
	\$t=''; \$g=false; \$p=true; \$k=true; \$b=false;
	foreach(file(\$this->nam()) as \$v){
		/*=====*/
		if(substr(\$v,0,12)=='}//bootPW4()'){\$b=false;}
		if(\$b==true){
			for(\$i=0;\$i<(strlen(\$v)-strlen(\$keyProg));\$i++){
				if(substr(\$v,\$i,strlen(\$keyProg))==\$keyProg){\$b=false;}
			}
			if(\$b==false){continue;}
		}
		if(substr(\$v,0,10)=='/*=boot=*/'){\$b=true;}
		/*=====*/
		if(\$p==true and substr(\$v,0,13)=="/*|keysProg*/"){
			\$s='/*|keysProg*/ \$keysProgPW4=array(';
			foreach(\$keysProgPW4 as \$val){
				if(\$val==\$keyProg){continue;}
				if(\$g==true){\$s.=",";}
				\$s.="'".\$val."'";
				\$g=true;
			}
			\$t.=\$s.');'.chr(10);
			continue;
		}
		if(substr(\$v,0,strlen(\$keyProg)+6)=="/*>|\$keyProg*/"){\$p=false; \$e="error";}//error
		if(\$p==true){\$t.=\$v;}
		if(\$k==false and \$v!=chr(13)){\$p=true; \$k=true;}
		if(substr(\$v,0,strlen(\$keyProg)+6)=="/*<|\$keyProg*/"){\$k=false; \$e="complete";}
		//\$t.=\$v;
	}
	if(\$e=='complete'){\$f=fopen(\$this->nam(),'w'); fwrite(\$f,\$t); fclose(\$f);}
	\$this->view=\$e;
	
}//delet

function message(\$head='header',\$mess='message',\$key='Ok'){
	echo <<<NEC
<div id='headDelProg'>\$head</div>
<div id='messageDelProg'>\$mess
	<div id="buttonDelProg">
		<button class="keyButtonDP" name="keyDelProg" value="nome">\$key</button>
	</div>
</div>
NEC;
}

function viewDelet(){
	if(isset(\$_SESSION['nameDelProg'])){ \$n=\$_SESSION['nameDelProg'];
		echo "<div id='headDelProg'>Удалить программу:</div><div id='messageDelProg'>";
		\$o=new \$n; if(isset(\$o->name)){\$n=\$o->name;}
		echo "Удалить: <b>".\$n."</b> !";
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
	global \$keysProgPW4;
	echo '<div id="headDelProg">Выберите прогамму для удаления:</div>';
	echo "<div id='contentDelProg'>";
	if(isset(\$keysProgPW4)){foreach(\$keysProgPW4 as \$v){
		\$o=new \$v; if(isset(\$o->name)){\$n=\$o->name;}else{\$n=\$v;}
		echo "<button type=submit class=nameDelProg name=nameDelProg value='\$v'>\$n</button>";
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
	switch(\$this->view){
		case 'home': \$this->viewHome(); break;
		case 'delet': \$this->viewDelet(); break;
		case 'complete':
			\$this->message('Программа удалена','Программа удалена <b>'.\$this->nameProg.'</b> !');
			break;
		case 'error': 
			\$this->message('Ошыбка удаления','Не найдено окончание программы!');
			break;
	}
	echo '</form>';
}//view
}//class DeletPrograms
DEC;

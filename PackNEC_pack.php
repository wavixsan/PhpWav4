<?php /*000||*/
$keyProg='PackNEC';
$program=<<<DEC
class PackNEC{
	var \$name='PackNEC';
	var \$info="Упаковщик программ для Install Programs";
	var \$view='home';
	var \$vers="1.01";
	var \$desc=<<<NEC
10.11.16 v1.01 - Добавлено сохранение boot .
NEC;
	
	function nam(){
		\$a=\$_SERVER["SCRIPT_NAME"]; \$b="";
		for(\$i=0; \$i<strlen(\$a); \$i++){if(substr(\$a,\$i,1)=="/"){\$b="";}else{\$b.=substr(\$a,\$i,1);}}
		return \$b;
	}//nam() - имя текущего файла или файл который вызывает эту функцию.
	
function saveProg(){
	if(!empty(\$_POST['nameFile']) and !empty(\$_POST['nameClass']) and !empty(\$_POST['key'])){
		\$key=\$_POST['key']; \$p=false; \$g=false; \$nec=true; \$dec=true; \$text=''; \$b=false;
		foreach(file(\$this->nam()) as \$v){
			if(substr(\$v,0,strlen(\$key)+6)=="/*>|\$key*/"){\$p=true; \$g=true; continue;}
			if(substr(\$v,0,strlen(\$key)+6)=="/*<|\$key*/"){\$p=false;}
			if(\$g){\$g=false; continue;}
			if(\$p==true){
				for(\$i=0;\$i<strlen(\$v);\$i++){
					switch(substr(\$v,\$i,1)){case '\\\\': case '\$': \$text.='\\\\';}
					\$text.=substr(\$v,\$i,1);
				}
			}
			if(substr(\$v,0,4)=='NEC;'){\$nec=false;}
			if(substr(\$v,0,4)=='DEC;'){\$dec=false;}
			
			if(substr(\$v,0,10)=='/*=boot=*/'){\$b=true; continue;}
			if(substr(\$v,0,12)=='}//bootPW4()'){\$b=false;}
			if(\$b==true){
				for(\$i=0;\$i<(strlen(\$v)-strlen(\$key));\$i++){
					if(substr(\$v,\$i,strlen(\$key))==\$key){\$b=false; break;}
				}
				if(\$b==false){\$boot=true;}
			}
		}//foreach
		
		if(!\$p){
			\$key=\$_POST['nameClass'];
			if(\$nec and \$dec){\$nec="NEC";}elseif(!\$nec and \$dec){\$nec='DEC';}else{\$nec='GEC';}
			\$t="<?php /*000||*/".chr(10)."\\\$keyProg='\$key';".chr(10);
			if(isset(\$boot)){\$t.='\$boot=true;'.chr(10);}
			\$t.="\\\$program=<<<\$nec".chr(10)."class \$key{";
			//if(!empty(\$_POST['name'])){\$t.='	var \$name="'.\$_POST['name'].'";'.chr(10);}
			\$t.=chr(10).\$text."\$nec;".chr(10);
			if(isset(\$_POST['installPack'])){
				\$t=\$t.chr(10).'//test';
			}
			\$f=fopen(\$_POST['nameFile'].'.php','w'); fwrite(\$f,\$t); fclose(\$f);
			\$this->view='pack';
		}//if \$p
	}
}
	
function start(){
	if(isset(\$_POST['keyNec'])){\$this->view='form';}
	if(isset(\$_POST['keysNec'])){switch(\$_POST['keysNec']){
		case 'saveProg': \$this->saveProg(); break;
		case 'home': \$this->view='home'; break;
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
	switch(\$this->view){
		case 'home': \$this->viewHome(); break;
		case 'form': \$this->viewForm(\$_POST['keyNec']); break;
		case 'pack': echo 'compele <input type=submit value=home name=keysPack>';  break;
	}
	echo '</form>';
}
	
function viewHome(){
	global \$keysProgPW4;
	echo '<div id=headNec>Выберите программу для упаковки:</div><div id=keysNec>';
	foreach(\$keysProgPW4 as \$v){
		\$o=new \$v; if(isset(\$o->name)){\$n=\$o->name;}else{\$n=\$v;}
		echo "<button class=keyNec type=submit name='keyNec' value='\$v'>\$n</button>";
	}
	echo '</div>';
}
	
function viewForm(\$key){
	echo <<<NEC
name class: <input type=text name='nameClass' value='\$key'> <br>
name prog file: <input type=text name='nameFile' value='{\$key}_pack'> .php <br>
<!--name prog: <input type=text name=name><br>-->
Упаковать в установщик: <input type='checkbox' name='installPack'>
<button type=submit name=keysNec value='saveProg'>save</button>
<button type=submit name=keysNec value='home'>cancel</button>
<input type='hidden' name='key' value='\$key'>
NEC;
}//viewForm
}//class packNec;
DEC;

<?php $tt="00000"; $phpn="PhpWav2.php"; $verw="2.2";
//echo "<meta charset=\"utf-8\">";
$p=substr($phpn,0,strlen($phpn)-4);
$te=$_SERVER["SCRIPT_NAME"]; $t="";
for($i=0; $i<strlen($te); $i++){ $t.=substr($te,$i,1); if(substr($te,$i,1)=="/"){$t="";} }
if($t!=$phpn){
	//if(file_exists($phpn)){exit("<font color=\"red\">Файл с таки именем существует</font>: ".$phpn);}
	if(!rename($t,$phpn)){exit("<font color=\"red\">Невозможно переименовать на:</font> $phpn");}
	else{header("location:$phpn");}
}

/*======Стартовые Опции======*/
//StartConfig - стартовые конфигурации для первого старта

//Color_Text_Prog-beg
$c0="</font>"; $c1="<font color=\"red\">"; $c2="<font color=\"blue\">"; $c3="<font color=\"green\">";
//Color_Text_Prog-end

//FilesMeneger-beg
if(empty($_GET["sa"])){header("location:$phpn?sa=FilesMeneger");}
if(empty($c0)){$c0=""; $c1=""; $c2="";}
if(empty($_GET["go"])){
	$ss=$_SERVER["SCRIPT_FILENAME"]; $sc=0; $se=0;
	for($i=0; $i<strlen($ss); $i++){if(substr($ss,$i,1)=="/"){$sa[]=$i+1; $sc++;}}
	$go=substr($ss,0,$sa[$sc-1]);
	header("location: ".$phpn."?go=".$go."&sa=".$_GET["sa"]);
}else{$go=$_GET["go"];}
//FilesMeneger-end

//EndStartConfig ==================================???


/*======Верхние кнопки======*/
function KeysUp(){echo"<form action=\"\" method=\"post\"><hr>"; global $phpn; global $go;
//KeysUp - верхная функция кнопок

//UpLoader-beg
echo "<input type=\"submit\" name=\"KeyUpLoader\" value=\"UpLoader\"> ";
//UpLoader-end

//Php_Info-beg
echo "<input type=\"submit\" name=\"KeyPhp_Info\" value=\"Php_Info\"> ";
//Php_Info-end

//Install_Prog-beg
echo "<input type=\"submit\" name=\"KeyInstall_Prog\" value=\"Install_Prog\"> ";
//Install_Prog-end

//Info_Prog-beg
echo "<input type=\"submit\" name=\"KeyInfo_Prog\" value=\"Info_Prog\"> ";
//Info_Prog-end

//FilesMeneger-beg
echo "<input type=\"submit\" name=\"KeyFilesMeneger\" value=\"FilesMeneger\"> ";
//FilesMeneger-end

//EndKeysUp =================???
echo"<hr></form>";}/*======*/ //echo KeysUp();


/*======Нижние кнопки======*/
function KeysDown(){echo"<hr>";
//KeysDown - нижная функция кнопок

//Cut_Copy_Insert_Files-beg
echo "<input type=\"submit\" name=\"KeyCut\" value=\"Вырезать\"> ";
echo "<input type=\"submit\" name=\"KeyCopy\" value=\"Копировать\"> ";
echo "<input type=\"submit\" name=\"KeyInsert\" value=\"Вставить\"> ";
//Cut_Copy_Insert_Files-end

//Create_Folder_File-beg
echo "<input type=\"submit\" name=\"KeyCreate\" value=\"Создать\"> ";
//Create_Folder_File-end

//Install_Test-beg
echo "<input type=\"submit\" name=\"KeyEdit\" value=\"Редактировать\"> ";
//Install_Test-end

//Delete_Files-beg
echo "<input type=\"submit\" name=\"KeyDelete\" value=\"Удалить\"> ";
//Delete_Files-end

//Rename_Files-beg
echo "<input type=\"submit\" name=\"KeyRename\" value=\"Переименовать\"> ";
//Rename_Files-end

//EndKeysDown =================???
echo"<hr>";}/*======*/ //echo KeysDown();


/*======Функции обработки======*/
//Function - место для функций обработки от приложений

//UpLoader-beg
if(!empty($_POST["KeyUpLoader"])){header("location:$phpn?go=$go&sa=UpLoader");}
if(!empty($_POST["UpLoader"])){ KeysUp();
	if(empty($c0)){$c0=""; $c1=""; $c2="";}
	if(is_uploaded_file($_FILES["filename"]["tmp_name"])){ 
	move_uploaded_file($_FILES["filename"]["tmp_name"],$go.$_FILES["filename"]["name"]);}
		else { exit($c1."Ошибка загрузки файла".$c0."!"); } 
	echo $c2."Файл загружен".$c0.": ".$_FILES["filename"]["name"]." .";
exit;}
//UpLoader-end

//Cut_Copy_Insert_Files-beg
if(!empty($_POST["KeyCut"])){$kcc="cut";}
if(!empty($_POST["KeyCopy"])){$kcc="copy";}
if(!empty($kcc)){
	if(empty($c0)){$c0=""; $c1=""; $c2="";}
	$k=1; $er=0; $text=$kcc.chr(10); KeysUp();
	$files=scandir($go); $text.=$go.chr(10);
	for($i=2; $i<count($files); $i++){
		$type=filetype($go.$files[$i]);
		if($type=="dir"){$dir[]=$files[$i];}
		if($type=="file"){$file[]=$files[$i];}
	}
	if(!empty($dir)){for($i=0; $i<count($dir); $i++){if(!empty($_POST[$k])){$con[]=$dir[$i]; $er++;}$k++;}}
	if(!empty($file)){for($i=0; $i<count($file); $i++){if(!empty($_POST[$k])){$con[]=$file[$i]; $er++;}$k++;}}
	if($er==0){exit($c1."Файл невыбран!".$c0);}
	//if($er==1){}
	for($i=0; $i<count($con); $i++){$text.=$con[$i].chr(10);}
	if(!file_exists("temp")){if(!mkdir("temp",0700)){exit($c1."Невозможно зоздать папку".$c0.": \"temp\".");}}
	$file=fopen("temp/buff.php","w"); fwrite($file,$text); fclose($file);
	echo $c2."Выбранние файлы сохранены в буффер".$c0.".";
exit;}
if(!empty($_POST["KeyInsert"])){ KeysUp();//-зделать проверку вставляемых файлов
	if(empty($c0)){$c0=""; $c1=""; $c2="";}
	if(!file_exists("temp")){exit($c1."Не найдена папка".$c0.": \"temp\"");}
	if(!file_exists("temp/buff.php")){exit($c1."Ненайден буфферний файл".$c0.": \"buff.php\"");}
	$line=file("temp/buff.php"); 
	for($i=0; $i<count($line); $i++){$lines[]=substr($line[$i],0,strlen($line[$i])-1);}
	if($lines[0]=="cut" or $lines[0]=="copy"){for($i=2; $i<count($lines); $i++){
		if(is_dir($lines[1].$lines[$i])){echo($c1."Функция не обрабатывает папки".$c0."!<br>");}
		if(is_file($lines[1].$lines[$i])){
			if(!copy($lines[1].$lines[$i],$go.$lines[$i])){exit($c1."Ошыбка копирования".$c0."!");}
			if($lines[0]=="cut"){if(!unlink($lines[1].$lines[$i])){exit($c1."Ошыбка удаления".$c0."!");}}
		}
	}}
	if(!unlink("temp/buff.php")){exit($c1."Ошыбка удаления буферного файла".$c0."!");}
	if($lines[0]=="cut"){echo $c2."Файлы перемещены".$c0.".";}
	if($lines[0]=="copy"){echo $c2."Файлы скопированы".$c0.".";}
exit;}
//Cut_Copy_Insert_Files-end

//Create_Folder_File-beg
if(!empty($_POST["KeyCreate"])){ KeysUp(); if(empty($c0)){$c0=""; $c1=""; $c2="";}
	echo "<form action=\"\" method=\"POST\">";
	echo $c2."Функция для создания файла или папки$c0.<br><br>";
	echo "Введите имя: <input type=\"text\" name=\"NamCreate\"><br><br>";
	echo "<input type=\"submit\" name=\"KeyCreateFolder\" value=\"Создать папку\"> ";
	echo "<input type=\"submit\" name=\"KeyCreateFile\" value=\"Создать файл\">";
	echo "</form>";
exit;}
if(!empty($_POST["KeyCreateFolder"])){$kcf_create="Folder";}
if(!empty($_POST["KeyCreateFile"])){$kcf_create="File";}
if(!empty($kcf_create)){ KeysUp(); if(empty($c0)){$c0=""; $c1=""; $c2="";}
	if(!empty($_POST["NamCreate"])){$Nam=$_POST["NamCreate"];}else{echo($c1."Ви не ввели имя$c0!<br><br>");
		exit("<form method=\"POST\"><input type=\"submit\" name=\"KeyCreate\" value=\"Назад\"></form>");}
	if($kcf_create=="File"){$t1="Файл"; $t2="";} 
	if($kcf_create=="Folder"){$t1="Папка"; $t2="а";}
	if(file_exists($go.$Nam)){echo("$c1$t1 с таким именем существует$c0: <b>$Nam</b> .<br><br>");
		exit("<form method=\"POST\"><input type=\"submit\" name=\"KeyCreate\" value=\"Назад\"></form>");}
	if($kcf_create=="File"){$file=fopen($go.$Nam,"w"); fwrite($file,""); fclose($file);}
	if($kcf_create=="Folder"){mkdir($go.$Nam);}
	if(file_exists($go.$Nam)){echo "$c2$t1 создан$t2$c0: <b>$Nam</b> .";}else{
		echo $c1."Невозможно создать $t1$c0: <b>$Nam</b> .";
		exit("<form method=\"POST\"><input type=\"submit\" name=\"KeyCreate\" value=\"Назад\"></form>");}
exit;}
//Create_Folder_File-end

//Php_Info-beg
if(!empty($_POST["KeyPhp_Info"])){KeysUp(); echo phpinfo(); KeysUp(); exit;}
//Php_Info-end

//Install_Test-beg
if(!empty($_POST["KeyEdit"])){ KeysUp();
	$res=scandir($go); $k=0; $er=0;
	for($i=0; $i<count($res); $i++){ 
		if(is_dir($go.$res[$i])){$dir[]=$res[$i];}
		if(is_file($go.$res[$i])){$file[]=$res[$i];} }
	for($i=1; $i<count($dir); $i++){if(!empty($_POST[$k])){exit($c1."Функция не обрабативает папки$c0!");}$k++;}
	for($i=0; $i<count($file); $i++){if(!empty($_POST[$k])){$fnam=$file[$i]; $er++;}$k++;}
	if($er==0){exit($c1."Файл не выбран$c0!");}
	if($er!=1){exit($c1."Выбрано больше одного файла$co!");}
	if(!file_exists("temp")){if(!mkdir("temp")){exit($c1."Невозможно создать папку".$c0.": temp");}}
	$file=fopen("temp/buff.php","w"); fwrite($file,$fnam); fclose($file);
	$lines=file($go.$fnam); $text="";
	for($i=0; $i<count($lines); $i++){$text.=$lines[$i];}
	echo "<form method=\"POST\">";
	echo "<input type=\"submit\" name=\"KeySaveEdit\" value=\"Сохранить\"> ";
	//echo "<input type=\"submit\" name=\"KeySeveAsEdit\" value=\"Сохранить как\"> ";
	echo $c2."Редактирование файла$c0: <b>$fnam</b><br><br>";
	echo "<textarea rows=\"23\" cols=\"115\" name=\"TextEdit\">$text</textarea>";
	echo "</form>";
exit;}
if(!empty($_POST["KeySaveEdit"])){ KeysUp();
	$text=$_POST["TextEdit"];
	if(file_exists("temp/buff.php")){$lines=file("temp/buff.php"); unlink("temp/buff.php"); $file=$lines[0];}
		else{exit($c1."Ошибка буферизации".$c0."!");}
	$file=fopen($go.$file,"w"); fwrite($file,$text); fclose($file);
	echo $c2."Файл успешно сохранён$c0.";
exit;}
//Install_Test-end

//Delete_Files-beg
if(!empty($_POST["KeyDelete"])){KeysUp(); $files=scandir($go); $ef=0; $ed=0; $k=1; $text=""; $text2="";
	if(empty($c0)){$c0=""; $c1=""; $c2="";}
	for($i=1; $i<count($files); $i++){$type=filetype($go.$files[$i]);
		switch($type){case "dir": $dir[]=$files[$i]; break; case "file": $file[]=$files[$i]; break;}
	}
	for($i=1; $i<count($dir); $i++){if(!empty($_POST[$k])){$fn[]=$dir[$i]; $ed++;}$k++;}
	for($i=0; $i<count($file); $i++){if(!empty($_POST[$k])){$fn[]=$file[$i];  $ef++;}$k++;}
	if($ed==0 && $ef==0){echo $c1."Файл не вибран".$c0."!"; exit;}else{$d=""; $f=""; $t1=""; $t2="";}
	if($ed==1){$t1="ую"; $d="папку";} if($ed>1){$t1="ые"; $d="папки";}
	if($ef==1){$t1="ый"; $f="файл";} if($ef>1){$t1="ые"; $f="файлы";}
	if($ef>0 && $ed>0){$t1="ые"; $t2=" и ";}
	for($i=0; $i<count($fn); $i++){$text.=$fn[$i]."/";  $text2.="<b>".$fn[$i]."</b><br>";}
	$text3="?go=$go&sa=Delete_Files&DelNam=$text";
	echo "[<a href=\"$text3\">".$c1."Удалить".$c0."</a>] выбранн$t1 ".$d.$t2.$f."!";
	echo "<br><br>$text2";
exit;}
//Delete_Files-end

//Rename_Files-beg
if(!empty($_POST["Ok_KeyRename"])){ KeysUp();
	if(empty($c0)){$c0=""; $c1=""; $c2="";}
	if(!empty($_POST["NewNam"])){$nam=$_POST["NewNam"];}
		else{exit($c1."Ошибка передачи имени".$c0."!");}
	if(file_exists("temp/buff.php")){$lines=file("temp/buff.php"); unlink("temp/buff.php"); $file=$lines[0];}
		else{exit($c1."Ошибка буферизации".$c0."!");}
	if(is_dir($go.$file)){$text="Папка"; $te="a";}
	if(is_file($go.$file)){$text="Файл"; $te="";}
	if(file_exists($nam)){exit($c1.$text." с таким именем существует".$c0."!");}
	if(!rename($go.$file,$go.$nam)){exit($c1."Ошибка переименования".$c0."!");}
	echo $c2.$text." переименован".$te.$c0.".";
exit;}
if(!empty($_POST["KeyRename"])){$k=1; $files=scandir($go); $er=0; KeysUp();
	if(empty($c0)){$c0=""; $c1=""; $c2="";}
	for($i=1; $i<count($files); $i++){$type=filetype($go.$files[$i]);
		switch($type){case "dir": $dir[]=$files[$i]; break; case "file": $file[]=$files[$i]; break;}
	}
	for($i=1; $i<count($dir); $i++){if(!empty($_POST[$k])){ $f=$dir[$i]; $er++;}$k++;}
	for($i=0; $i<count($file); $i++){if(!empty($_POST[$k])){$f=$file[$i]; $er++;}$k++;}
	if($er==0){exit($c1."Файл не вибран".$c0."!");}
	if($er!=1){exit($c1."Вы вибрали больше одного файла".$c0."!");}
	if(!file_exists("temp")){if(!mkdir("temp",0700)){exit($c1."Невозможно создать папку".$c0.": temp");}}
	$file=fopen("temp/buff.php","w"); fwrite($file,$f); fclose($file);
	echo "<form action=\"\" method=\"POST\" enctype=\"multipart/form-data\">";// 
	echo "<input type=\"text\" name=\"NewNam\" value=\"$f\">";
	echo "<input type=\"submit\" name=\"Ok_KeyRename\" value=\"Переименовать\">";
	echo "</form>";
exit;}
//Rename_Files-end

//Install_Prog-beg
if(!empty($_POST["KeyInstall_Prog"])){header("location:$phpn?go=$go&sa=Install_Prog");}
if(empty($c0)){$c0=""; $c1=""; $c2=""; $c3="";}
//Install_Prog-end

//Info_Prog-beg
if(!empty($_POST["KeyInfo_Prog"])){header("location:$phpn?go=$go&sa=Info_Prog");}
//Info_Prog-end

//FilesMeneger-beg
if(!empty($_POST["KeyFilesMeneger"])){header("location:$phpn?go=$go&sa=FilesMeneger");}
//FilesMeneger-end

//EndFunction =====================???


/*======Приложения======*/
if(isset($_GET["sa"])){
//Programs - место для программ

//UpLoader-beg
if($_GET["sa"]=="UpLoader"){ KeysUp();
	echo "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\">";
	echo "Выберите файл для загрузки: <br><br>";
	echo "<input type=\"file\" name=\"filename\"><br><br>";
	echo "<input type=\"submit\" name=\"UpLoader\" value=\"Загрузить\">";
	echo "</form>";
exit;}
//UpLoader-end

//Install_Test-beg
//место для программ
//Install_Test-end

//Delete_Files-beg
if($_GET["sa"]=="Delete_Files"){$nam=$_GET["DelNam"]; KeysUp(); $j=0; $na[0]=""; $text=""; $ed=0; $ef=0;
	if(empty($c0)){$c0=""; $c1=""; $c2="";}
	for($i=0; $i<strlen($nam); $i++){$t=substr($nam,$i,1); if($t=="/"){$j++; $na[$j]="";}else{$na[$j].=$t;}}
	for($i=0; $i<count($na)-1; $i++){
		$text.="<b>".$na[$i]."</b></br>";
		if(is_dir($go.$na[$i])){$ed++;}
		if(is_file($go.$na[$i])){$ef++;}
		if(!file_exists($go.$na[$i])){exit($c1."Нет файла или папки $c0: <b>$na[$i]</b>");}
		if(is_dir($go.$na[$i])){if(!rmdir($go.$na[$i])){exit($c1."Невозможно удалить папку$c0: <b>$na[$i]</b>");}}
		if(is_file($go.$na[$i])){if(!unlink($go.$na[$i])){exit($c1."Невозможно удалить файл$c0: <b>$na[$i]</b>");}}
	} $t1=""; $t2=""; $t3=""; $d=""; $f="";
	if($ed==1){$t1="aя"; $d="Папкa"; $t3="a";} if($ed>1){$t1="ыe"; $d="Папки"; $t3="ы";}
	if($ef==1){$t1="ый"; $f="Файл"; $t3="";} if($ef>1){$t1="ые"; $f="Файлы"; $t3="ы";}
	if($ef>0 && $ed>0){$t1="ые"; $t2=" и "; $t3="ы";}
	echo $c2.$d.$t2.$f." удален$t3".$c0."!";
	echo "<br><br>".$text;
exit;}
//Delete_Files-end

//Install_Prog-beg
if($_GET["sa"]=="Install_Prog"){ $files=scandir("."); KeysUp();
	function Check_Ins($files,$s){ global $phpn; $Reply="";
		$lines=file($phpn); for($j=0; $j<count($lines); $j++){ if(substr($lines[$j],0,2)=="//"){
			if($s==1){ $a=substr($lines[$j],2,strlen(substr($files,0,strlen($files)-4)));
				if($a==substr($files,0,strlen($files)-4)){$Reply="Установлено"; $j=count($lines);} }
			if($s==2){$isa=1; include($files); $a=substr($lines[$j],2,strlen($inam));
				if($a==$inam){$Reply="Установлено"; $j=count($lines);} }
		}}
	return $Reply;}
	echo $c2."Установщик программ для$c0: <b>PhpWav2</b> .<br>";
	echo $c3."Выберите программу из списки для установки$c0: <hr><table border=\"0\">";
	for($i=1; $i<count($files); $i++){ if(is_file($files[$i])){
		$file=fopen($files[$i],"r"); $text=fread($file,16); fclose($file);
		if(substr($text,11,5)=="00001"){
			echo "<tr><td>[<a href=\"$files[$i]\">".$c2.$files[$i].$c0."</a>]</td>";
			echo "<td>$c1".Check_Ins($files[$i],1)."$c0</td><td></td></tr>";}
		if(substr($text,11,5)=="00002"){$isa=1; include($files[$i]);
			$text="$phpn?go=$go&sa=Install_Prog_Ok&NamIns=$files[$i]";
			echo "<tr><td>[<a href=\"$text\">".$c3.$inam.$c0."</a>]</td>";
			echo "<td>$c1".Check_Ins($files[$i],2)."$c2</td>";
			echo "<td>>><a href=\"$files[$i]\">$c2$files[$i]$c0</a><<</font></td></tr>";}
	}}
	echo "</table><hr>".$c1."Установочние файлы должны ноходится вместе с файлом$c0: <b>$p</b> .<br>";
	echo "$c2*$c0 - Автономний установщик программ.<br>";
	echo "$c3*$c0 - Инсталятор программ.<br>";
exit;}
if($_GET["sa"]=="Install_Prog_Ok"){ KeysUp();
	if(empty($_GET["NamIns"])){exit($c1."Ошыбка передачи имени$c0!");}
	$nam=$_GET["NamIns"]; $isa="1"; include($nam);
	$text="$phpn?go=$go&sa=Install_Prog_Ins&NamIns=$nam";
	echo $c2."Установщик программ для$c0: <b>PhpWav2</b> .<br>";
	echo "[<a href=\"$text\">".$c3."Установить$c0</a>]: <b>$inam</b>. <br><br>";
	echo "Описание: $c3$iopis$c0<br>";
	echo "Версия: $c3$iver$c0. Автор: $c3$iautor$c0.";
exit;}
if($_GET["sa"]=="Install_Prog_Ins"){ $nam=$_GET["NamIns"]; $isa="Install_2"; include($nam); KeysUp();
	$lines=file($phpn); $text=""; $er=0;
	for($i=0; $i<count($lines); $i++){$text.=$lines[$i]; if(substr($lines[$i],0,2)=="//"){ 
		if(!empty($start)){if(substr($lines[$i],2,11)=="StartConfig"){$text.=$start; $er=1;}}
		if(!empty($keyup)){if(substr($lines[$i],2,6)=="KeysUp"){$text.=$keyup; $er=1;}}
		if(!empty($kdown)){if(substr($lines[$i],2,8)=="KeysDown"){$text.=$kdown; $er=1;}}
		if(!empty($func)){if(substr($lines[$i],2,8)=="Function"){$text.=$func; $er=1;}}
		if(!empty($program)){if(substr($lines[$i],2,8)=="Programs"){$text.=$program; $er=1;}}
		if(!empty($info)){if(substr($lines[$i],2,11)=="InfoProgram"){$text.=$info; $er=1;}}
		if(!empty($opisanie)){if(substr($lines[$i],2,15)=="OpisanieProgram"){$text.=$opisanie; $er=1;}}
		if(!empty($downconfig)){if(substr($lines[$i],2,10)=="DownConfig"){$text.=$downconfig; $er=1;}}
		if(substr($lines[$i],2,strlen($inam))==$inam){exit("<b>$inam</b>$c1 - Уже установлен$c0!");}
	}}//for
	if($er==0){exit($c1."Нет установочных файлов$c0!");}
	$file=fopen($phpn,"w"); fwrite($file,$text); fclose($file);
	echo "<b>$inam</b> - ".$c2."успешно установлен$c0.<br><br>";
exit;}
//Install_Prog-end

//Opisanie_Prog-beg
if($_GET["sa"]=="Opisanie_Prog"){ $nam=$_GET["OpNam"]; KeysUp();
	$lines=file($phpn); $a=0; $c=0;
	for($i=0; $i<count($lines); $i++){ if(substr($lines[$i],0,2)=="//"){
		if(substr($lines[$i],2,15)=="OpisanieProgram"){$a=1; $i++;}
		if(substr($lines[$i],2,18)=="EndOpisanieProgram"){$a=0;}
		if($a==1){
			if(substr($lines[$i],2,strlen($nam)+4)==$nam."-beg"){$c=1; $i++;}
			if(substr($lines[$i],2,strlen($nam)+4)==$nam."-end"){$c=0;}
		}
		if($c==1){echo $lines[$i]."<br>";}
	}}
exit;}
//Opisanie_Prog-end

//Delete_Prog-beg
if($_GET["sa"]=="Delete_Prog"){ $nam=$_GET["DelNam"]; if(empty($c0)){$c0=""; $c1="";}
	KeysUp(); $text="$phpn?go=$go&sa=Delete_Prog_del&DelNam=$nam";
	echo "[<a href=\"$text\">$c1"."Удалить$c0</a>]: <b>$nam</b>";
exit;}
if($_GET["sa"]=="Delete_Prog_del"){ $nam=$_GET["DelNam"]; if(empty($c0)){$c0=""; $c2="";}
	$lines=file($phpn); $a=1; $text="";
	for($i=0; $i<count($lines); $i++){ 
		if(substr($lines[$i],0,2)=="//"){ if(substr($lines[$i],2,strlen($nam))==$nam){
			if(substr($lines[$i],strlen($nam)+3,3)=="beg"){$a--;}
			if(substr($lines[$i],strlen($nam)+3,3)=="end"){$a++; $i=$i+2;}
		}}
	if($a==1){$text.=$lines[$i];}
	}//for
	//$file=fopen("text.php","w");
	$file=fopen($phpn,"w");
	fwrite($file,$text);
	fclose($file);
	if($nam=="Delete_Prog"){KeysUp(); exit($c2."Программа удалена".$c0.": <b>$nam.</b>");}
	header("location:$phpn?go=$go&sa=Delete_Prog_DelOk&DelNam=$nam");
exit;}
if($_GET["sa"]=="Delete_Prog_DelOk"){ $nam=$_GET["DelNam"]; KeysUp(); if(empty($c0)){$c0=""; $c2="";}
	echo $c2."Программа удалена".$c0.": <b>$nam.</b>";
exit;}
//Delete_Prog-end

//Info_Prog-beg
if($_GET["sa"]=="Info_Prog"){
	if(empty($c0)){$c0=""; $c1=""; $c2=""; $c3="";}
	KeysUp();
	$a=0; $c=0; $lines=file($phpn); $de=0; $op=0;
	for($i=0; $i<count($lines); $i++){
		if(substr($lines[$i],2,11)=="Delete_Prog"){$de=1; }
		if(substr($lines[$i],2,13)=="Opisanie_Prog"){$op=1; }
	}
	echo "<table border=\"1\"><tr><td>Название</td><td>Версия</td><td>Автор</td>";
	if($de==1){echo "<td>Удалить</td>";}
	if($op==1){echo "<td>Описание</td>";}
	echo "</tr>";
	for($i=0; $i<count($lines); $i++){ if(substr($lines[$i],0,2)=="//"){ $b=1;
		if(substr($lines[$i],2,14)=="EndInfoProgram"){$a=2; $i=count($lines)-1;}
		if($a==1){
			if(substr($lines[$i],strlen($lines[$i])-4,3)=="beg"){$i++; $c=1;}
			if(substr($lines[$i],strlen($lines[$i])-4,3)=="end"){$c=0;}
		}
		if($c==1){ $t1=""; $t2=""; $t3=""; $t4=""; $t5=""; for($j=2; $j<strlen($lines[$i]); $j++){
			if(substr($lines[$i],$j,1)==" "){$b++; $j++;}
			if($b==1){$t1.=substr($lines[$i],$j,1);}
			if($b==2){$t2.=substr($lines[$i],$j,1);}
			if($b==3){$t3.=substr($lines[$i],$j,1);}
		} 
		if($de==1){ $text="$phpn?go=$go&sa=Delete_Prog&DelNam=$t1";
			$t4="<td>[<a href=\"$text\">$c1"."Удалить$c0</a>]</td>";}
		if($op==1){ $text="$phpn?go=$go&sa=Opisanie_Prog&OpNam=$t1";
			$t5="<td>[<a href=\"$text\">$c3"."Описание$c0</a>]</td>";}
		echo "<tr><td>$t1</td><td>$t2</td><td>$t3</td>".$t4.$t5."</tr>";
		}
		if($a==0){if(substr($lines[$i],2,11)=="InfoProgram"){$a=1;}}
	}}
	echo "</table><hr>";
exit;}
//Info_Prog-end

//FilesMeneger-beg
if($_GET["sa"]=="FilesMeneger"){
function razmer($raz){
	if($raz<=1024){$fsize=$raz; $fsize.=" байт";}
	elseif($raz<=pow(1024,2)){$fsize=round($raz/1024,2); $fsize.=" Кб";}
	elseif($raz<=pow(1024,3)){$fsize=round($raz/pow(1024,2),2); $fsize.=" Мб";}
	elseif($raz<=pow(1024,4)){$fsize=round($raz/pow(1024,3),2); $fsize.=" Гб";}
	elseif($raz<=pow(1024,5)){$fsize=round($raz/pow(1024,4),2); $fsize.=" Тб";}
	//дописать для Мб, Гб, Тб...
return $fsize;}
	if(empty($c0)){$c0=""; $c1=""; $c2=""; $c3="";}
	$files=scandir($go);
	for($i=0; $i<count($files); $i++){
		$type=filetype($go.$files[$i]);
		switch($type){
			case "dir": $dir[]=$files[$i]; $sc=$go.$files[$i]."/"; 
				if($files[$i]==".."){if(substr($go,strlen($go)-3,3)!="../"){$d1=1;
					for($j=strlen($go); $j>1; $j--){if(substr($go,$j-2,1)=="/"){$d1++;
						if($d1==2){$sc=substr($go,0,$j-1);}
				}}}else{echo"ok";}}
				$sl[]=$phpn."?go=".$sc."&sa=".$_GET["sa"];
				break;
			case "file": $file[]=$files[$i]; $fsize[]=razmer(filesize($go.$files[$i])); break;
			case "fifo": $fnm[]=$files[$i]; $fn[]="fifo"; break;
			case "char": $fnm[]=$files[$i]; $fn[]="char"; break;
			case "block": $fnm[]=$files[$i]; $fn[]="block"; break;
			case "link": $fnm[]=$files[$i]; $fn[]="link"; break;
			case "socket": $fnm[]=$files[$i]; $fn[]="socket"; break;
			default: exit($c1."Ошибка: Неизвесний тип файла".$c0."!");
		}//switch
	}//for
	$gf=$_SERVER["DOCUMENT_ROOT"]; if(substr($gf,strlen($gf)-1,1)!="/"){$gf.="/";} $ag=strlen($gf);
	$gs="http://".$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"]."/".substr($go,$ag,strlen($go)-$ag);
	KeysUp();
	$k=1;
	echo $gs;
	echo "<hr><form action=\"\" method=\"post\"><table border=\"0\">";
	echo "<tr><td></td><td>Имя</td><td>Размер</td><td>Тип</td><td>Время изменения</td></tr>";
	if($gf!=$go){
		echo "<tr><td></td><td><a href=\"".$sl[1]."\">".$c2.$dir[1].$c0."</a>/</td><td></td><td>dir</td><td></td></tr>";
	}
	if(!empty($dir)){for($i=2; $i<count($dir); $i++){
		echo "<tr><td><input type=\"checkbox\" name=\"".$k."\"></td>";
		echo "<td><a href=\"".$sl[$i]."\">".$c2.$dir[$i].$c0."</a>/</td><td></td>";
		echo "<td>".filetype($go.$dir[$i])."</td><td></td></tr>";
		$k++;}}
	if(!empty($file)){for($i=0; $i<count($file); $i++){
		echo "<tr><td><input type=\"checkbox\" name=\"".$k."\"></td>";
		echo "<td><a href=\"".$gs.$file[$i]."\">".$c2.$file[$i].$c0."</a></td><td>".$fsize[$i]."</td>";
		echo "<td>".filetype($go.$file[$i])."</td><td>".date("d.m.y H:i:s",filemtime($go.$file[$i]))."</td></tr>";
		$k++;}}
	if(!empty($fnm)){for($i=0; $i<count($fnm); $i++){
		echo "<tr><td></td><td>".$fnm[$i]."</td><td></td><td>".$fn[$i]."</td><td></td></tr>";}}
	echo "</table> <hr>";
	echo "Диск: свободно ".razmer(disk_free_space("."))." из ".razmer(disk_total_space("."))." .";
	KeysDown();
	echo "[<a href=\"$phpn\">$c1"."Перезагрузка$c0</a>]";
	echo "<hr></form>";
	clearstatcache(); 
exit;}
//FilesMeneger-end

//EndPrograms ==========???
}/*======*/

/*======Информация о приложениях======*/
//InfoProgram - иноформация приложениях

//UpLoader-beg
//UpLoader 2.1 WavixSan
//UpLoader-end

//Cut_Copy_Insert_Files-beg
//Cut_Copy_Insert_Files 1.2 WavixSan
//Cut_Copy_Insert_Files-end

//Create_Folder_File-beg
//Create_Folder_File 1.0 WavixSan
//Create_Folder_File-end

//Php_Info-beg
//Php_Info 1.1 WavixSan
//Php_Info-end

//Install_Test-beg
//Install_Test 0.0 WavixSan
//Install_Test-end

//Delete_Files-beg
//Delete_Files 1.2 WavixSan
//Delete_Files-end

//Rename_Files-beg
//Rename_Files 1.2 WavixSan
//Rename_Files-end

//Color_Text_Prog-beg
//Color_Text_Prog 1.1 WavixSan
//Color_Text_Prog-end

//Install_Prog-beg
//Install_Prog 1.1 WavixSan
//Install_Prog-end

//Opisanie_Prog-beg
//Opisanie_Prog 1.0 WavixSan
//Opisanie_Prog-end

//Delete_Prog-beg
//Delete_Prog 1.2 WavixSan
//Delete_Prog-end

//Info_Prog-beg
//Info_Prog 2.2 WavixSan
//Info_Prog-end

//FilesMeneger-beg
//FilesMeneger 2.7 WavixSan
//FilesMeneger-end

//EndInfoProgram ====================???

/*======Описание програм======*/
//OpisanieProgram - описание програм

//UpLoader-beg
//- Программа для загрузки файлов на сервер.
//ver 2.0 - Переделанная ver 1.0 под PhpWav2 .
//18.07.15 ver2.1 - Переделана верхная кнопка через функцию и цветовая локализация для текста.
//UpLoader-end

//Cut_Copy_Insert_Files-beg
//- Программа для вырезания копирования и вставки файлов, зделана для FilesMeneger .
//17.07.15 ver 1.1 - Переделан движок вставки и дописана русская локализация.
//19.07.15 ver1.2- Добавлена цветовая локализация для текста .
//Cut_Copy_Insert_Files-end

//Create_Folder_File-beg
//- $iopis
//Create_Folder_File-end

//Php_Info-beg
//- Небольшая программа для просмотра функции phpinfo();
//19.07.15 ver1.1 - Переделана верхная кнопка через функцию. 
//Php_Info-end

//Install_Test-beg
//- $iopis
//Install_Test-end

//Delete_Files-beg
//- Программа для удаление файлов, зделана для FilesMeneger.
//14.07.15 ver1.1 - Добавлена возможность удалять несколько файлов.
//18.07.15 ver1.2 - Добавлена возможность удалять папки, переписан текст + цветовая локализация.
//Delete_Files-end

//Rename_Files-beg
//-  Программа для переименования файлов, зделана для FilesMeneger .
//14.07.15 ver 1.1 - Переделан буфер через папку temp .
//17.07.15 ver 1.2 - Добавлена возможнасть переименовать папку, переписан текст + цветовая локализация.
//Rename_Files-end

//Color_Text_Prog-beg
//- $iopis
// 19.07.15 ver1.1 - Добавлен цвет "green" .
//Color_Text_Prog-end

//Install_Prog-beg
//- Новая версия установщика программ для: <b>PhpWav2</b>.
//22.07.15 ver1.1 - Исправленна ошибка вивода больших букв, зделана проверка установленних программ.
//Install_Prog-end

//Opisanie_Prog-beg
//- Программа для просмотра описания программ, зделана для Info_Prog.
//Opisanie_Prog-end

//Delete_Prog-beg
//- Программа для удаления программ, зделана для Info_Prog .
//15.07.15 ver 1.1 - Исправлен баг когда после удаления оставалась верхная кнопка программи .
//19.07.15 ver1.2 - Исправлен баг когда после удаления Delete_Prog выбрасивало в ОС ошибку. + цвет локал.
//Delete_Prog-end

//Info_Prog-beg
//- Программа для просмотра информации о программах .
//ver 2.0 - Переделанная функция "tools" от "phpwav под" PhpWav2 .
//ver 2.1 - Добавлена функция потдержки удаления программ.
//ver 2.2 - Добавлена функция потдержки просмотра описания для программ.
//19.07.18 ver2.3 - Переделана верхная кнопка через функцию и цветовая локализация для текста.
//Info_Prog-end

//FilesMeneger-beg
//- Программа для просмотра файловой системы сервера.
//ver 2.0 - Переделаная ver 1.3 под PhpWav2 . 
//ver 2.1 - Переделан размер через функцию.
//ver 2.2 - Дописаны типы.
//ver 2.3 - Переделан путь через url.
//ver 2.4 - Переделано ограничение пути сервера.
//18.07.15 ver2.5 - Переделана верхная кнопка через функцию и цветовая локализация для текста.
//20.07.15 ver2.6 - Переделана стартовая функция запуск через "sa" и запуск через "go" .
//20.07.15 ver2.7 - Исправлена цветовая локализация для директив .
//FilesMeneger-end

//EndOpisaniePogram ============???

/*======Нижние конфигурации======*/
//DownConfig - дополнителиные опции

//EndDownConfig ================???

KeysUp();
exit("<b>".$p."</b> <font color=\"red\">- OC оболочка, для программ.</font>");
//- Оболочка для программ
//18.07.15 ver2.1 - Переделана верхная функция кнопок под submit .
 ?>
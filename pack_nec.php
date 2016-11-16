<?php 
function upPack($n,$s){
	$t='<?php $pack=<<<SEC'.chr(10);
	foreach(file($n) as $str){
		for($i=0;$i<strlen($str);$i++){
			switch(substr($str,$i,1)){case '\\': case '$': $t.='\\';}
			//if(substr($str,$i,1)=='$'){$t.='\\';}
			$t.=substr($str,$i,1);
		}
	}
	$t.=chr(10).'SEC;'.chr(10);
	$f=fopen($s,'w'); fwrite($f,$t); fclose($f);
}
function downPack($n,$s){
	if(file_exists($n)){include($n);}
	if(isset($pack)){
		$f=fopen($s,'w'); fwrite($f,$pack); fclose($f);
	}
}
upPack('test_install2.php','pack.php');
//downPack('pack.inc','pack.php');

//21.10.2016 - Переделана система экранизации.
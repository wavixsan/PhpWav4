<?php /*000||*/
	
/*Кнопка или ярлык для запуска программы*/
$keyProg="PackProgram";

/*Тело пограммы*/
$program=<<<NEC
class $keyProg{
	function start(){}
	function view(){echo 'class test2';}
}
NEC;

/*boot*/
//var $boot="return '".$this->keyProg."';";


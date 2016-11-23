<?php /*000||*/
	
/*Кнопка или ярлык для запуска программы*/
$keyProg="PhpWav4_v2";
$boot=true;

/*Тело пограммы*/
$program=<<<NEC
class $keyProg{
	function start(){}//start() - Стартовая Функция для обработки Функционала.
	function boot(){}//boot() -
	function view(){echo 'class $keyProg';}//view() - Функция для вивода содержмого на экран.
}//end class $keyProg;
NEC;

/*boot*/
//var $boot="return '".$this->keyProg."';";


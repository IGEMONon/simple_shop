<?php
$string = 'No one saves us but ourselves. No one can and no one may. We ourselves must walk the path.';
$pattern = '~([\w]+)~';
$string = strtolower($string);
preg_match_all($pattern, $string, $matches);
$mas = array();
foreach ($matches[1] as $key=>$word) {
    if (array_key_exists($word,$mas)) {
        $mas[$word] ++;
    }else{
        $mas[$word] = 1;
    }
}
$result = ksort($mas);
$result = arsort($mas);
$i=0;
foreach ($mas as $word=>$quantity){
    echo "$word => $quantity </br>";
    $i++;
    if ($i>=15) break;
}
die();
?>
//FRONT CONTROLLER

//1. Общие настройки
ini_set('display_errors',1); //отображение всех ошибок на время написания кода
error_reporting(E_ALL);

session_start();


//2. Подключение файлов системы
define('ROOT', dirname(__FILE__)); //Объявляется константа ROOT, dirname - функция получения полного пути к
                                         //директории файла
require_once(ROOT.'/components/Autoload.php');

//4. Вызов Router
$router = new Router();
$router->run();
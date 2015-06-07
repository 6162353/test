<?php

/* 
 для тестирования кусков кода
 */

$debug=0;


header('Content-type: text/html; charset=utf-8');

$db_user='dz9';
$db_name='dz9';
$db_server='localhost';


$conn = mysql_connect(
$db_server, $db_user,$db_user)
or die("Невозможно установить соединение: ". mysql_error());


echo '<br>conn=';
echo $conn; 

mysql_select_db($db_name);
mysql_query('SET NAMES utf8');



?>
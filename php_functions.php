<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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

$query='select id from cities';

$result_query = mysql_query($query) or die('Запрос не удался');

echo '<br>result_query=';
echo $result_query;

$result = mysql_fetch_assoc($result_query);

echo '<br>result=';
vardump($result);


?>
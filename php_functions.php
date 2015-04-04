<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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

/* Мне нужно получить такой вот массив, чтобы не переписывать мой код
$cities = array ( 'Новосибирск' => '641780',
    'Барабинск' => '641490',
    'Бердск' => '641510',
    'Искитим' => '641600',
    'Колывань' => '641630',
    'Краснообск' => '641680',
    'Куйбышев' => '641710',
    'Мошково' => '641760',
    'Обь' => '641790',
    'Ордынское' => '641800',
    'Черепаново' => '641970',
    'Выбрать другой...' => '0'
    
    
   );

*/

/* В результате fetch_assoc мы получим массив только одной записи
 * поэтому запрашиваем все записи в цикле, одновременно формируя массив $cities
 */

/*

$query='select * from cities order by id ASC';

$result_query = mysql_query($query) or die('Запрос не удался');

echo '<br>result_query=';
echo $result_query;

while ($result = mysql_fetch_assoc($result_query)) {

if ($debug) {
echo '<br>result=';
var_dump($result);
}

/*$result = 
 * array (size=2)
  'id' => string '0' (length=1)
  'city' => string 'Другой город...' (length=26) 
 * 
 * Соответственно $result['city']=Другой город...
 * $result['id']=0
 * 
 * Это нужно для формирования массива $cities
 */

/*
$cities[$result['city']]=$result['id'];

}

echo '<br>cities=';
var_dump($cities);

/*
 * Получается
 * array (size=12)
  'Барабинск' => string '641490' (length=6)
  'Бердск' => string '641510' (length=6)
  'Искитим' => string '641600' (length=6)
  'Колывань' => string '641630' (length=6)
  'Краснообск' => string '641680' (length=6)
  'Куйбышев' => string '641710' (length=6)
  'Мошково' => string '641760' (length=6)
  'Новосибирск' => string '641780' (length=6)
  'Обь' => string '641790' (length=6)
  'Ордынское' => string '641800' (length=6)
  'Черепаново' => string '641970' (length=6)
  'Другой город...' => string '70000' (length=5)
 * 
 * То что мне и нужно.
 * Дальше Метро
 * 
 * 
 */

/* ШАБЛОН ДЛЯ ЗАПРОСА В БД  
 * 
$query='select * from cities order by id ASC';

$result_query = mysql_query($query) or die('Запрос не удался');

echo '<br>result_query=';
echo $result_query;

while ($result = mysql_fetch_assoc($result_query)) {

if ($debug) {
echo '<br>result=';
var_dump($result);
}

$cities[$result['city']]=$result['id'];

}

echo '<br>cities=';
var_dump($cities);
 * 
 * 
 */

/* МЕТРО */
/*
$query='select * from tube_stations order by tube_station ASC';

$result_query = mysql_query($query) or die('Запрос не удался');

echo '<br>result_query=';
echo $result_query;

while ($result = mysql_fetch_assoc($result_query)) {

if ($debug) {
echo '<br>result=';
var_dump($result);
}

$tube_stations[$result['tube_station']]=$result['id'];

}

echo '<br>tube_stations=';
var_dump($tube_stations);

/* получается 
 * 
$tube_stations = array ('Берёзовая роща' => '2028',
    'Гагаринская' => '2018',
    'Заельцовская' => '2017',
    'Золотая Нива' => '2029',
    'Красный проспект' => '641630',
    'Маршала Покрышкина' => '2027',
    'Октябрьская' => '2021',
    'Площадь Гарина-Михайловского' => '2025',
    'Площадь Ленина' => '2020',
    'Площадь Маркса' => '2024',
    'Речной вокзал' => '2022',
    'Сибирская' => '2026',
    'Студенческая' => '2023',
    
   );

 */








/* КАТЕГОРИЯ
 * 
 * 
 * 
 * 
 *  */
 

$query='select * from categories order by id ASC';

$result_query = mysql_query($query) or die('Запрос не удался');

//echo '<br>result_query_of_category_from_categories=';
//echo $result_query;

while ($result = mysql_fetch_assoc($result_query)) {

if ($debug) {
echo '<br>result_query_from_categories=';
var_dump($result);
}

/* мы получили

 * $result['id']=1
 * $result['category']=Транспорт
 * 
 * и пошел запрос к другой таблице - подзапрос
 * 
 *  */

$subquery='select * from subcategories where category='.$result['id'].' order by subcategory';

$result_subquery = mysql_query($subquery) or die('Запрос не удался');

while ($result2 = mysql_fetch_assoc($result_subquery)) {

    /* мы получили

 * $result2['id']=9
 * $result2['subcategory']=Автомобили с пробегом
 * 
 * и формируем массив $category = array (  'Автомобили с пробегом' => '9',
     * 'Новые автомобили' => '109' ...)
 * 
 *  */
    
if ($debug) {
echo '<br>result2_subquery_from_category=';
var_dump($result2);



}    
    
$subcategory[$result2['subcategory']]=$result2['id'];



}

if ($debug) {
echo '<br>$subcategory=';
var_dump($subcategory);}


/* закончили формировать подкатегорию и добавляем её в массив (формируем)
 * $categories = array (  "Транспорт" => array (
        
        'Автомобили с пробегом' => '9',
        'Новые автомобили' => '109',
 */

$categories[$result['category']]=$subcategory;

//обнуляем
mysql_free_result($result_subquery);
$subcategory=array();

if ($debug) {
echo '<br>$subcategory ПОСЛЕ СБРОСА=';
var_dump($subcategory);}

}


echo '<br>$categories=';
var_dump($categories);









//mysql_free_result($result_query);
mysql_free_result($result_query);
mysql_close($conn);

?>
<?php

header('Content-type: text/html; charset=utf-8');

/* Урок 3 Задание 1
Создайте массив $date с пятью элементами
 * - C помощью генератора случайных чисел забейте массив $date юниксовыми метками
 * - Сделайте вывод сообщения на экран о том, какой день в сгенерированном массиве получился 
наименьшим, а какой месяц наибольшим
        */

$timestamps=array(4);

mt_srand(time());

$now=time();

for ($i=0; $i<=4; $i++) {
    $timestamps[$i]=mt_rand(0,$now);
    //var_dump($timestamps[$i]);
}

echo '<p>Unix timestamps is ';
var_dump($timestamps);
echo '</p>';

$date=array();

for ($i=0; $i<=4; $i++) {
    $date[$i]=  getdate($timestamps[$i]);
    //var_dump($date[$i]);
}


//var_dump($date);

// print all array in readable format
echo '<br><p>Dates is</p>';
for ($i=0; $i<=4; $i++) {
    
    echo '<p>'.date("d.m.y H:i:s",$timestamps[$i]).'</p>';
    
    }



// the lowest day

$amount=count($date[0]);
//echo '</p>amount elements in $date are '.$amount.'</p>';

//var_dump($amount);

//echo $date[0]['mday'];
        
$date_day=array();

for ($i=0; $i<=4; $i++) {
    
    $date_day[$i] = $date[$i]['mday'];
    //var_dump($date_day[$i]);
    
    }
    
$date_month=array();    
    
for ($i=0; $i<=4; $i++) {
    
    $date_month[$i] = $date[$i]['mon'];
    //var_dump($date_month[$i]);
    
    }
    
//var_dump($date_day);
echo '<br><p> the lowest day is '.min($date_day).'</p>';

//var_dump($date_month);
echo '<p> the greatest month is '.max($date_month).'</p>';

//Отсортируйте массив по возрастанию дат


sort($timestamps);


//var_dump($timestamps);

for ($i=0; $i<=4; $i++) {
    $date[$i]=  getdate($timestamps[$i]);
    //var_dump($date[$i]);
}


echo '<br><p>Sorted dates is</p>';
for ($i=0; $i<=4; $i++) {
    
    echo '<p>'.date("d.m.y H:i:s",$timestamps[$i]).'</p>';
    
    }
//var_dump($date);


/*С помощью функция для работы с массивами извлеките последний элемент массива в новую переменную 
$selected */

$selected=array_pop($date);
//var_dump($selected);
        

/*C помощью функции date() выведите $selected на экран в формате "дд.мм.ГГ ЧЧ:ММ:СС"
 * 
 */

echo '<br><p>$selected is '.date("d.m.y H:i:s",$selected[0]).'</p>';

/*Выставьте часовой пояс для Нью-Йорка, и сделайте вывод снова, чтобы проверить, что часовой пояс 
был изменен успешно
 * 
 */

/* Knowing the difference in time zones.


$now_new_york=$now-7*60*60;
var_dump(getdate($now+60*60));
var_dump(getdate($now_new_york));
echo '<p>$now is '.date("d.m.y H:i:s",$now+60*60).'</p>';
echo '<p>$now_new_yourk is '.date("d.m.y H:i:s",$now_new_york).'</p>';

*/

/* Through the use of Greenwich time. 


$now=gmdate("d.m.y H:i:s",time()+4*60*60);
var_dump($now);
$now_new_york=gmdate("d.m.y H:i:s",time()-4*60*60);
var_dump($now_new_york);

echo '<p>$now is '.$now.'</p>';
echo '<p>$now_new_york is '.$now_new_york.'</p>';
 * 
 * 
 */

// Through the setting time zones. 

echo '<br>';
date_default_timezone_set('Europe/Moscow');
//var_dump(date("d.m.y H:i:s",time()+60*60));

echo '<p> Time in Moscow is '.date("d.m.y H:i:s",time()+60*60).'</p>';

date_default_timezone_set('America/New_York');
//var_dump(date("d.m.y H:i:s",time()+60*60));
echo '<p> Time in New York is '.date("d.m.y H:i:s",time()+60*60).'</p>';



?>
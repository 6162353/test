<?php

header('Content-type: text/html; charset=utf-8');

//error_reporting(E_ALL);

ini_set('display_errors', 1);

//echo $x;

//prent('hi how do you do');


//echo "My surname is Kolesnikova";

$age=28;
$name="Алина";

echo 'Меня зовут '.$name.' <br>';
echo 'Мне '.$age.' лет <br>';

//print_r($_SERVER);

// Задание 2

define('town','Москва');

echo '<p>'.town.'</p>';

$town='Ливерпуль';

echo '<p>'.town.'</p>';



// Задание 3

$book=array();
$book['title']='"Уклонение от уплаты налогов как проблема социального управления"';
$book['author']='Анна Санина';
$book['pages']='184';

//var_dump($book);


echo '<p>Недавно я прочитала книгу '.$book['title'].', написанную автором '.$book['author'].', я осилила все '.$book['pages'].' страниц, мне она очень понравилась.</p>';


// Задание 4

$book1=array();
$book1['title']='"English Grammar in Use with Answers"';
$book1['author']='Рэймонд Мерфи';
$book1['pages']='390';

$book2=array();
$book2['title']='"SEO. Искусство раскрутки сайтов"';
$book2['author']='Эрик Энж';
$book2['pages']='668';

$books=array($book1,$book2);

echo '<p>Недавно я прочитала книги '.$books[0]['title'].' и '.$books[1]['title'].', написанные соответственно авторами '.$books[0]['author'].' и '.$books[1]['author'].', я осилила в сумме '.($books[0]['pages']+$books[1]['pages']).' страниц, не ожидала от себя подобного.';



//var_dump($books);


?>
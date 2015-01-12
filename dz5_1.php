<?php

$otladka=0;


//GET

$news='Четыре новосибирские компании вошли в сотню лучших работодателей
Выставка университетов США: открой новые горизонты
Оценку «неудовлетворительно» по качеству получает каждая 5-я квартира в новостройке
Студент-изобретатель раскрыл запутанное преступление
Хоккей: «Сибирь» выстояла против «Ак Барса» в пятом матче плей-офф
Здоровое питание: вегетарианская кулинария
День святого Патрика: угощения, пивной теннис и уличные гуляния с огнем
«Красный факел» пустит публику на ночные экскурсии за кулисы и по закоулкам столетнего здания
Звезды телешоу «Голос» Наргиз Закирова и Гела Гуралиа споют в «Маяковском»';

$news=  explode("\n", $news);

// Функция вывода всего списка новостей.

function output_list_of_news() {
    
    global $otladka;
    global $news;
    
    header('Content-type: text/html; charset=utf-8');
    
    $amount=count($news);
    
    if ($otladka) { 
        echo '<p><b>var_dump($amount)= </b></p>';
        var_dump($amount);
    }
    
    echo '<body>';
    
    for ($i=0; $i<$amount; $i++) {
        
        echo '<p>'.$news[$i].'</p>';
        
    }
    
    echo '</body>';
    
}

// Функция вывода конкретной новости.

function output_news($id) {
    
    global $otladka;
    global $news;
    
    header('Content-type: text/html; charset=utf-8');
    
    if ($otladka) { 
        print_r($news);
    }
    
    if ($otladka) {
    echo '<p><b>var_dump($_GET)= </b></p>';
    echo var_dump($_GET);
}

    
    echo $news[$id];
    
};

function output_error() {
    
        header("HTTP/1.0 404 Not Found");
        header('Content-type: text/html; charset=utf-8');
        echo '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
        <html><head>
        <title>404 Не найдено</title>
         </head><body>
        <h1>Веб-страница не найдена</h1>
        <p>Пожалуйста, проверьте правильность написания веб-ссылки в адресной строке</p>
        </body></html>';
    
}



// Точка входа.
// Если новость присутствует - вывести ее на сайте, иначе мы выводим весь список

// Был ли передан id новости в качестве параметра?
// если параметр не был передан - выводить 404 ошибку
// То есть если нет ничего - выводим список новостей, если есть id корретный - новость
// В противном случае 404
// http://php.net/manual/ru/function.header.php


if (count($_GET)==0) {
    
    if ($otladka) { 
        echo '<p><b>var_dump($_GET)= </b></p>';
        echo var_dump($_GET);
    }
    output_list_of_news();
    
}

else {
    
    if (key_exists('id', $_GET)) {
    
        if ($_GET['id']>0 AND $_GET['id']<10) {
        
            output_news($_GET['id']-1);
        }
        
        
        else {
            
            output_error();
            
        }
        
        
    }
    
    else {
        
        
        output_error();

        
        
        
    }
    
    
}
    







?>
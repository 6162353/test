<?php

//POST

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
//print_r($news);

// Функция вывода всего списка новостей.

function output_list_of_news() {
    
    global $news;
    
    output_begin_html();
    
    $amount=count($news);

 
    for ($i=0; $i<$amount; $i++) {
        
        echo '<p>'.$news[$i].'</p>';
        
    }

    output_form();
    
}

// Функция вывода конкретной новости.

function output_news($id) {
    
    global $news;
    
    output_begin_html();
  
    echo $news[$id];
    
};

// Точка входа.
// Если новость присутствует - вывести ее на сайте, иначе мы выводим весь список

// Был ли передан id новости в качестве параметра?
// если параметр не был передан - выводить 404 ошибку
// http://php.net/manual/ru/function.header.php




if (count($_POST)==0) {
      
    output_list_of_news();
    
}

else {
    
    if (key_exists('id', $_POST)) {
    
        if ($_POST['id']>0 AND $_POST['id']<10) {
        
            output_news($_POST['id']-1);
            
            output_form();
        }
        
        
        else {
            
            output_error();
            
        }
        
        
    }
    
    else {
        
        
        output_error();

        
        
        
    }
    
    
}

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

function output_begin_html() {
    
    echo '<!DOCTYPE HTML>
    <html>
     <head>
      <meta charset="utf-8">
      <title>Новости</title>
     </head>
     <body>';
    
}



function output_form() {

    echo '<br>';
    echo '<form method="POST">
      <p><b>Номер новости:</b>
      <input type="text" name="id" maxlength="1">
      <input type="submit"></p>
     </form>';
    
    echo '</body>';


}

?>





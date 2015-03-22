<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$project_root=$_SERVER['DOCUMENT_ROOT'];
$smarty_dir=$project_root.'/test/smarty/';

// put full path to Smarty.class.php
require($smarty_dir.'libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->compile_check = true;
$smarty->debugging = false;



$smarty->template_dir = $smarty_dir.'templates';
$smarty->compile_dir = $smarty_dir.'templates_c';
$smarty->cache_dir = $smarty_dir.'cache';
$smarty->config_dir = $smarty_dir.'configs';

$smarty->assign('name', 'Alina');


header('Content-type: text/html; charset=utf-8');



$otladka0=0;
$otladka=0;
$otladka2=0;
$reset=0;
$delete=0;
$ads_f='ads.txt';
$current_php_script='dz8';

$seller_name="";
$checkedPrivate='checked';
$checkedCompany='';
$post_edit=0;
$email='';
$checked_allow_mails='';
$phone=$title=$description='';
$selected='selected=""';
$location_id='641780';
$price='0';
$amount_ads=0;
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
$tube_station_id='';
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

$category_id='';
$categories = array (
    
    "Транспорт" => array (
        
        'Автомобили с пробегом' => '9',
        'Новые автомобили' => '109',
        'Мотоциклы и мототехника' => '14',
        'Грузовики и спецтехника' => '81',
        'Водный транспорт' => '11',
        'Запчасти и аксессуары' => '10',
        
    ),
    
    'Недвижимость' => array (
	'Квартиры' => '24',
        'Комнаты' => '23',
        'Дома, дачи, коттеджи' => '25',
        'Земельные участки' => '26',
        'Гаражи и машиноместа' => '85',
        'Коммерческая недвижимость' => '42',
        'Недвижимость за рубежом' => '86',
        ),
        
    'Работа' => array (
	'Вакансии (поиск сотрудников)' => '111',
        'Резюме (поиск работы)' => '112'
        ),
    
    'Услуги' => array (
	'Предложения услуг' => '114',
        'Запросы на услуги' => '115'
        ),
    
    'Личные вещи' => array (
	'Одежда, обувь, аксессуары' => '27',
        'Детская одежда и обувь' => '29',
        'Товары для детей и игрушки' => '30',
        'Часы и украшения' => '28',
        'Красота и здоровье' => '88'
        ),
    
    'Для дома и дачи' => array (
	'Бытовая техника' => '21',
        'Мебель и интерьер' => '20',
        'Посуда и товары для кухни' => '87',
        'Продукты питания' => '82',
        'Ремонт и строительство' => '19',
        'Растения' => '106'
        ),
    
    'Бытовая электроника' => array (
	'Аудио и видео' => '32',
        'Игры, приставки и программы' => '97',
        'Настольные компьютеры' => '31',
        'Ноутбуки' => '98',
        'Оргтехника и расходники' => '99',
        'Планшеты и электронные книги' => '96',
        'Телефоны' => '84',
        'Товары для компьютера' => '101'
        ),
    
    'Хобби и отдых' => array (
	'Билеты и путешествия' => '33',
        'Велосипеды' => '34',
        'Книги и журналы' => '83',
        'Коллекционирование' => '36',
        'Музыкальные инструменты' => '38',
        'Охота и рыбалка' => '102',
        'Спорт и отдых' => '39',
        'Знакомства' => '103'
        ),
    
    'Животные' => array (
	'Собаки' => '89',
        'Кошки' => '90',
        'Птицы' => '91',
        'Аквариум' => '92',
        'Другие животные' => '93',
        'Товары для животных' => '94'
        ),
    
    'Для бизнеса' => array (
	'Готовый бизнес' => '116',
        'Оборудование для бизнеса' => '40'
        )
    
    
    
);


/*
через файлы
*/


if ($reset) {
$GLOBALS["_POST"]=null;


unlink('ads.txt');
}


if (file_exists('ads.txt')) {
    $ads_t=file_get_contents('ads.txt');
    $temp_array=unserialize($ads_t);
    
    $ads_h=fopen($ads_f,'r+');

    }
else {


$ads_h=fopen($ads_f,'w+');
$ads_t='a:0:{}';
fwrite($ads_h,$ads_t);
$temp_array=array();

        }
        

        
        

if (isset($_POST['form'])) {
    if ($_POST['form']=="Записать изменения") {
// сохранить элемент
$temp_array[$_GET['id']]=$_POST;
$ads_t=serialize($temp_array);
        fseek($ads_h,0);
        fwrite($ads_h,$ads_t);


$_POST=null;
}
    if ($_POST['form']=="Назад") {
$_POST=null;
unset($_GET);
fclose($ads_h);
header('Location:/test/'.$current_php_script.'.php');
}
}

// если гет заполнен, значит запросили удаление или просмотр
if (isset($_GET["id"])) {
    if (isset($_GET["del"])) {
    if (isset($temp_array[$_GET["id"]])) {
unset($temp_array[$_GET["id"]]);
unset($_GET["id"]);
$ads_t=  serialize($temp_array);


     
        fseek($ads_h,0);
        fwrite($ads_h,$ads_t);
   
fclose($ads_h);
header('Location:/test/'.$current_php_script.'.php');
}
  

}


    if (isset($_GET["edit"])) {
        
        $id=$_GET['id'];
        $post_edit=1;
        $checkedPrivate = ($temp_array[$id]['private']) ? 'checked' : '' ;
        $checkedCompany = ($temp_array[$id]['private']) ? '' : 'checked' ;
        $seller_name = $temp_array[$id]['seller_name'];
        $email= $temp_array[$id]['email'];
        
        if (isset($temp_array[$id]['allow_mails'])) { 
            $checked_allow_mails='checked';
            }
        
        $phone=$temp_array[$id]['phone'];
        
        $location_id=$temp_array[$id]['location_id'];
        $tube_station_id=$temp_array[$id]['metro_id'];
        $category_id=$temp_array[$id]['category_id'];
        $title=$temp_array[$id]['title'];
        $description=$temp_array[$id]['description'];
        $price=$temp_array[$id]['price'];

}
}
// если заполнен пост

    elseif (count($_POST)) {
if (isset($_POST['main_form'])) {
if ($_POST['main_form']=='Добавить') {
        

        array_push($temp_array,$_POST);

        $ads_t=serialize($temp_array);

        $ads_h=fopen($ads_f,'r+');
        fseek($ads_h,0);
        fwrite($ads_h,$ads_t);
        
        

}
}

}

if (isset($temp_array)) {
        

      $amount_ads=count($temp_array); 

}

    
fclose($ads_h); 

$smarty->assign('checkedPrivate',$checkedPrivate);
$smarty->assign('checkedCompany',$checkedCompany);
//$smarty->assign(,);
$smarty->assign('seller_name',$seller_name);
$smarty->assign('email',$email);
$smarty->assign('checked_allow_mails',$checked_allow_mails);
$smarty->assign('phone',$phone);
$smarty->assign('selected',$selected);
$smarty->assign('cities', $cities);
$smarty->assign('location_id',$location_id);
$smarty->assign('tube_stations',$tube_stations);
$smarty->assign('tube_station_id',$tube_station_id);
$smarty->assign('categories',$categories);
$smarty->assign('category_id',$category_id);
$smarty->assign('title',$title);
$smarty->assign('description',$description);
$smarty->assign('price',$price);
$smarty->assign('post_edit',$post_edit);
$smarty->assign('amount_ads',$amount_ads);
$smarty->assign('temp_array',$temp_array);
$smarty->assign('current_php_script',$current_php_script);



$smarty->display('dz8.tpl');

?>


<?php

/* 

<
 *
 * 1) dz7_1.php Сохранять объявления в Cookie и выставить время жизни - неделю
 
 * желательно добавить возможность редактирования объявления
 * + поменять название кнопки - редактировать
 * + добавить кнопку -  Назад
 * 
 * 
 */


error_reporting(E_ALL);
ob_start(); 
header('Content-type: text/html; charset=utf-8');

$otladka=0;
$otladka2=0;
$otladka3=0;
$reset=0;
$delete=0;
      
            
if (isset($_COOKIE['advertise'])) {
     $ads_in_cookie=$_COOKIE['advertise'];
     $temp_array=unserialize($ads_in_cookie);

     
    } 
else {

$ads_in_cookie="a:0:{}";

if (setcookie("advertise",$ads_in_cookie,time()+ 3600 * 24 * 7))
// сразу же и устанавливает куки
    {

                }

}
            
   

if ($reset) {
   setcookie("advertise",$advertise,time()- 3600 * 24 * 7);
    
}      

if (isset($_POST['form'])) {
    if ($_POST['form']=="Записать изменения") {
// сохранить элемент
        $temp_array[$_GET['id']]=$_POST;
        $ads_in_cookie=serialize($temp_array);
        setcookie("advertise",$ads_in_cookie,time()+ 3600 * 24 * 7);


        $_POST=null;

}
    if ($_POST['form']=="Назад") {
        $_POST=null;
        unset($_GET);

        header("Location:/test/dz7_1.php");
}
}

  

// если гет заполнен, значит запросили удаление или просмотр 

if (isset($_GET["id"])) { 
    
    
    if (isset($_GET["del"])) {
    
    
    if (isset($temp_array[$_GET["id"]])) {
    
    unset($temp_array[$_GET["id"]]);
    unset($_GET["id"]);
    
    
     // после удаления 1 элемента, последовательность индексов нарушается.
     // пересоберу массив
     
     $amount=count($temp_array);
     $array=array();
     for ($i=0; $i<$amount; $i++) {
         
         $array[$i]=current($temp_array);
         next($temp_array);
         
     }
     
     
  
     
     $temp_array=$array;
     
      // надо элемент в куках убрать
     
     $ads_in_cookie=serialize($temp_array);
     

    setcookie("advertise",$ads_in_cookie,time()+ 3600 * 24 * 7);
    header("Location:/test/dz7_1.php");
 
    
    }
    }
    
    if (isset($_GET["edit"])) {
        
        show_form($_GET["id"]);
        output_advertise();
        
    }
    
}


// если заполнен пост

elseif (count($_POST)) {  
    if (isset($_POST['main_form'])) {
if ($_POST['main_form']=='Добавить') {
        

        
        $temp_array=unserialize($ads_in_cookie);

        array_push($temp_array,$_POST);

        $ads_in_cookie=serialize($temp_array);
        setcookie("advertise",$ads_in_cookie,time()+ 3600 * 24 * 7);
               
        
        output_begin_html();
        output_form();
        output_advertise();
}
    }
}


else {
    
    
            output_begin_html();
        output_form();
    output_advertise();
    
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

function show_form($id) {
    
 echo '<form  method="post">';
 $checked="";
 
 global $temp_array;
 
 if ($temp_array[$id]["private"]) {
     
     // если 1, то частная, если 0, то компания
     
    echo '<div class="form-row-indented">
    <label class="form-label-radio">
        <input type="radio" checked value="1" name="private">Частное лицо
        
    </label>
    
    <label class="form-label-radio">
        <input type="radio" value="0" name="private">Компания
        
    </label> </div>';
    
     
 }
 
 else {
     
         echo '<div class="form-row-indented">
    <label class="form-label-radio">
        <input type="radio"  value="0" name="private">Частное лицо
        
    </label>
    
    <label class="form-label-radio">
        <input type="radio" checked value="1" name="private">Компания
        
    </label> </div>';
     
    }

    echo '<div class="form-row"> 
    <label for="fld_seller_name" class="form-label">
    <b id="your-name">Ваше имя</b></label>
    <input type="text" maxlength="40" class="form-input-text" value="'
    .$temp_array[$id]['seller_name'].'" name="seller_name" 
    id="fld_seller_name">
    </div>';
    

    
    echo '<div class="form-row"> 
    <label for="fld_email" class="form-label">Электронная почта</label>
        <input type="text" class="form-input-text" value="'
        .$temp_array[$id]["email"].'" name="email" id="fld_email">
    </div>';
 

if (isset($temp_array[$id]["allow_mails"])) { 
    $checked="checked";
}
else {
    
    $checked="";
    
}
 
 echo '     <div class="form-row-indented">
    <label class="form-label-checkbox" for="allow_mails"> 
    <input type="checkbox" value="1" '.$checked.' name="allow_mails" id="allow_mails"
    class="form-input-checkbox">
    <span class="form-text-checkbox">Я не хочу получать вопросы по объявлению по e-mail</span> 
    </label> </div>';
 

    
     echo '    <div class="form-row"> 
    <label id="fld_phone_label" for="fld_phone" class="form-label">Номер телефона</label> 
    <input type="text" class="form-input-text" value="'
    .$temp_array[$id]["phone"].'" name="phone" id="fld_phone">
    </div>';
 
    
    echo    '<div id="f_location_id" class="form-row form-row-required">
    <label for="region" class="form-label">Город</label> 
    <select title="Выберите Ваш город" name="location_id" id="region" class="form-input-select"> 
    <option value="">-- Выберите город --</option>
    <option class="opt-group" disabled="disabled">-- Города --</option>';

    
     $string = ' <option data-coords=",," value="641780">Новосибирск</option>  !
            <option data-coords=",," value="641490">Барабинск</option>   !
            <option data-coords=",," value="641510">Бердск</option>   !
            <option data-coords=",," value="641600">Искитим</option>   !
            <option data-coords=",," value="641630">Колывань</option>   !
            <option data-coords=",," value="641680">Краснообск</option>   !
            <option data-coords=",," value="641710">Куйбышев</option>  ! 
            <option data-coords=",," value="641760">Мошково</option>   !
            <option data-coords=",," value="641790">Обь</option>   !
            <option data-coords=",," value="641800">Ордынское</option>   !
            <option data-coords=",," value="641970">Черепаново</option>   !
            <option id="select-region" value="0">Выбрать другой...</option> ';

$options=array();
$options=explode('!',$string);

     foreach ($options as $elem) {
         
         if (stristr($elem,$temp_array[$id]["location_id"])) {
             
            $elem=ltrim($elem);
            echo substr_replace($elem,' selected="" ', 7,0);
            
         }
            
        else {
            
            echo $elem;
            
            }
             
             
     }
         
     
     
    echo '</select></div>';
    

    
$string = '     <option value="2028">Берёзовая роща</option>!
    <option value="2018">Гагаринская</option>!
    <option value="2017">Заельцовская</option>!
    <option value="2029">Золотая Нива</option>!
    <option value="2019">Красный проспект</option>!
    <option value="2027">Маршала Покрышкина</option>!
    <option value="2021">Октябрьская</option>!
    <option value="2025">Площадь Гарина-Михайловского</option>!
    <option value="2020">Площадь Ленина</option>!
    <option value="2024">Площадь Маркса</option>!
    <option value="2022">Речной вокзал</option>!
    <option value="2026">Сибирская</option>!
    <option value="2023">Студенческая</option>';

$options=explode('!',$string);

echo '    <div id="f_metro_id"> 
    <select title="Выберите станцию метро" name="metro_id" id="fld_metro_id" 
    class="form-input-select"> <option value="">-- Выберите станцию метро --</option>';



     foreach ($options as $elem) {
         
         if (stristr($elem,$temp_array[$id]["metro_id"])) {
             
            $elem=ltrim($elem);
            echo substr_replace($elem,' selected="" ', 7,0);
            
         }
            
        else {
            
            echo $elem;
            
            }
             
             
     }
         
    echo '</select> </div> ';
     

$string = '<option value="">-- Выберите категорию --</option> !
   <optgroup label="Транспорт"> !
   <option value="9">Автомобили с пробегом</option> !
   <option value="109">Новые автомобили</option> !
   <option value="14">Мотоциклы и мототехника</option> !
   <option value="81">Грузовики и спецтехника</option> !
   <option value="11">Водный транспорт</option> !
   <option value="10">Запчасти и аксессуары</option> !
   </optgroup> !
   <optgroup label="Недвижимость"> !
   <option value="24">Квартиры</option> !
   <option value="23">Комнаты</option> !
   <option value="25">Дома, дачи, коттеджи</option> !
   <option value="26">Земельные участки</option> !
   <option value="85">Гаражи и машиноместа</option> !
   <option value="42">Коммерческая недвижимость</option> !
   <option value="86">Недвижимость за рубежом</option> !
   </optgroup> !
   <optgroup label="Работа"> !
   <option value="111">Вакансии (поиск сотрудников)</option> !
   <option value="112">Резюме (поиск работы)</option> !
   </optgroup> !
   <optgroup label="Услуги"> !
   <option value="114">Предложения услуг</option> !
   <option value="115">Запросы на услуги</option> !
   </optgroup> !
   <optgroup label="Личные вещи"> !
   <option value="27">Одежда, обувь, аксессуары</option> !
   <option value="29">Детская одежда и обувь</option> !
   <option value="30">Товары для детей и игрушки</option> !
   <option value="28">Часы и украшения</option> !
   <option value="88">Красота и здоровье</option> !
   </optgroup> !
   <optgroup label="Для дома и дачи"><option value="21">Бытовая техника</option> !
   <option value="20">Мебель и интерьер</option> !
   <option value="87">Посуда и товары для кухни</option> !
   <option value="82">Продукты питания</option> !
   <option value="19">Ремонт и строительство</option> !
   <option value="106">Растения</option> !
   </optgroup> !
   <optgroup label="Бытовая электроника"> !
   <option value="32">Аудио и видео</option> !
   <option value="97">Игры, приставки и программы</option> !
   <option value="31">Настольные компьютеры</option> !
   <option value="98">Ноутбуки</option> !
   <option value="99">Оргтехника и расходники</option> !
   <option value="96">Планшеты и электронные книги</option> !
   <option value="84">Телефоны</option> !
   <option value="101">Товары для компьютера</option> !
   </optgroup> !
   <optgroup label="Хобби и отдых"> !
   <option value="33">Билеты и путешествия</option> !
   <option value="34">Велосипеды</option> !
   <option value="83">Книги и журналы</option> !
   <option value="36">Коллекционирование</option> !
   <option value="38">Музыкальные инструменты</option> !
   <option value="102">Охота и рыбалка</option> !
   <option value="39">Спорт и отдых</option> !
   <option value="103">Знакомства</option> !
   </optgroup> !
   <optgroup label="Животные"> !
   <option value="89">Собаки</option> !
   <option value="90">Кошки</option> !
   <option value="91">Птицы</option> !
   <option value="92">Аквариум</option> !
   <option value="93">Другие животные</option> !
   <option value="94">Товары для животных</option> !
   </optgroup> !
   <optgroup label="Для бизнеса"> !
   <option value="116">Готовый бизнес</option> !
   <option value="40">Оборудование для бизнеса</option> !
   </optgroup> !

';

$options=explode('!',$string);

echo ' <div class="form-row"> 
   <label for="fld_category_id" class="form-label">Категория</label> 
   <select title="Выберите категорию объявления" name="category_id" 
   id="fld_category_id" class="form-input-select">';



     foreach ($options as $elem) {
         
         if (stristr($elem,$temp_array[$id]["category_id"])) {
             
            $elem=ltrim($elem);
            echo substr_replace($elem,' selected="" ', 7,0);
            
         }
            
        else {
            
            echo $elem;
            
            }
             
             
     }
   
    
 
   

   
    echo '</select> </div> ';

   
   
 


echo '<div id="f_title" class="form-row f_title"> 
    <label for="fld_title" class="form-label">Название объявления</label> 
    <input type="text" maxlength="50" class="form-input-text-long" value="'
    .$temp_array[$id]["title"].'" name="title" id="fld_title">
    </div>';
    
echo '    <div class="form-row"> 
    <label for="fld_description" class="form-label" id="js-description-label">Описание объявления</label>
    <textarea maxlength="3000" name="description" id="fld_description" class="form-input-textarea">'
    .$temp_array[$id]["description"].'</textarea> </div>';
    
echo '    <div id="price_rw" class="form-row rl"> 
    <label id="price_lbl" for="fld_price" class="form-label">Цена</label>
    <input type="text" maxlength="9" class="form-input-text-short" 
    value="'.$temp_array[$id]["price"].'" name="price" id="fld_price">&nbsp;<span id="fld_price_title">руб.</span>
    <a class="link_plain grey right_price c-2 icon-link" id="js-price-link" 
    href="/info/pravilnye_ceny?plain"><span>Правильно указывайте цену</span></a> </div>';

echo '    <div class="form-row-indented form-row-submit b-vas-submit" id="js_additem_form_submit">
        <div class="vas-submit-button pull-left"> <span class="vas-submit-border"></span> 
        <span class="vas-submit-triangle"></span> 
    <input type="submit" value="Записать изменения" id="form_submit" name="form" class="vas-submit-input">
<input type="submit" value="Назад" id="form_submit" name="form" class="vas-submit-input">
</div>
    
    </div>';    
         
    echo '</form>';

    
}







function output_form() {

echo '<form  method="post">
    
    
    <div class="form-row-indented"> <label class="form-label-radio"><input type="radio" checked="" value="1" name="private">Частное лицо</label> <label class="form-label-radio"><input type="radio" value="0" name="private">Компания</label> </div>
    <div class="form-row"> <label for="fld_seller_name" class="form-label">
    <b id="your-name">Ваше имя</b></label>
        <input type="text" maxlength="40" class="form-input-text" value="" name="seller_name"
        id="fld_seller_name">
    </div>


    <div class="form-row"> <label for="fld_email" class="form-label">Электронная почта</label>
        <input type="text" class="form-input-text" value="" name="email" id="fld_email">
    </div>
    

    <div class="form-row-indented"> <label class="form-label-checkbox" for="allow_mails"> <input type="checkbox" value="1" name="allow_mails" id="allow_mails" class="form-input-checkbox"><span class="form-text-checkbox">Я не хочу получать вопросы по объявлению по e-mail</span> </label> </div>
    <div class="form-row"> <label id="fld_phone_label" for="fld_phone" class="form-label">Номер телефона</label> <input type="text" class="form-input-text" value="" name="phone" id="fld_phone">
    </div>
    


    <div id="f_location_id" class="form-row form-row-required"> 
    <label for="region" class="form-label">Город</label> 
    <select title="Выберите Ваш город" name="location_id" id="region"
    class="form-input-select"> <option value="">-- Выберите город --</option>
    
            <option class="opt-group" disabled="disabled">-- Города --</option>
            <option selected="" data-coords=",," value="641780">Новосибирск</option>   <option data-coords=",," value="641490">Барабинск</option>   <option data-coords=",," value="641510">Бердск</option>   <option data-coords=",," value="641600">Искитим</option>   <option data-coords=",," value="641630">Колывань</option>   <option data-coords=",," value="641680">Краснообск</option>   <option data-coords=",," value="641710">Куйбышев</option>   <option data-coords=",," value="641760">Мошково</option>   <option data-coords=",," value="641790">Обь</option>   <option data-coords=",," value="641800">Ордынское</option>   <option data-coords=",," value="641970">Черепаново</option>   <option id="select-region" value="0">Выбрать другой...</option> </select> <div id="f_metro_id"> <select title="Выберите станцию метро" name="metro_id" id="fld_metro_id" class="form-input-select"> <option value="">-- Выберите станцию метро --</option><option value="2028">Берёзовая роща</option><option value="2018">Гагаринская</option><option value="2017">Заельцовская</option><option value="2029">Золотая Нива</option><option value="2019">Красный проспект</option><option value="2027">Маршала Покрышкина</option><option value="2021">Октябрьская</option><option value="2025">Площадь Гарина-Михайловского</option><option value="2020">Площадь Ленина</option><option value="2024">Площадь Маркса</option><option value="2022">Речной вокзал</option><option value="2026">Сибирская</option><option value="2023">Студенческая</option></select> </div> <div id="f_district_id"> <select title="Выберите район города" name="district_id" id="fld_district_id" class="form-input-select" style="display: none;"> <option value="">-- Выберите район города --</option></select> </div> <div id="f_road_id"> <select title="Выберите направление" name="road_id" id="fld_road_id" class="form-input-select" style="display: none;"> <option value="">-- Выберите направление --</option><option value="56">Бердское шоссе</option><option value="57">Гусинобродское шоссе</option><option value="53">Дачное шоссе</option><option value="55">Краснояровское шоссе</option><option value="54">Мочищенское шоссе</option><option value="52">Ордынское  шоссе</option><option value="58">Советское шоссе</option></select> </div> </div>
   
<div class="form-row"> <label for="fld_category_id" class="form-label">Категория</label> <select title="Выберите категорию объявления" name="category_id" id="fld_category_id" class="form-input-select"> <option value="">-- Выберите категорию --</option><optgroup label="Транспорт"><option value="9">Автомобили с пробегом</option><option value="109">Новые автомобили</option><option value="14">Мотоциклы и мототехника</option><option value="81">Грузовики и спецтехника</option><option value="11">Водный транспорт</option><option value="10">Запчасти и аксессуары</option></optgroup><optgroup label="Недвижимость"><option value="24">Квартиры</option><option value="23">Комнаты</option><option value="25">Дома, дачи, коттеджи</option><option value="26">Земельные участки</option><option value="85">Гаражи и машиноместа</option><option value="42">Коммерческая недвижимость</option><option value="86">Недвижимость за рубежом</option></optgroup><optgroup label="Работа"><option value="111">Вакансии (поиск сотрудников)</option><option value="112">Резюме (поиск работы)</option></optgroup><optgroup label="Услуги"><option value="114">Предложения услуг</option><option value="115">Запросы на услуги</option></optgroup><optgroup label="Личные вещи"><option value="27">Одежда, обувь, аксессуары</option><option value="29">Детская одежда и обувь</option><option value="30">Товары для детей и игрушки</option><option value="28">Часы и украшения</option><option value="88">Красота и здоровье</option></optgroup><optgroup label="Для дома и дачи"><option value="21">Бытовая техника</option><option value="20">Мебель и интерьер</option><option value="87">Посуда и товары для кухни</option><option value="82">Продукты питания</option><option value="19">Ремонт и строительство</option><option value="106">Растения</option></optgroup><optgroup label="Бытовая электроника"><option value="32">Аудио и видео</option><option value="97">Игры, приставки и программы</option><option value="31">Настольные компьютеры</option><option value="98">Ноутбуки</option><option value="99">Оргтехника и расходники</option><option value="96">Планшеты и электронные книги</option><option value="84">Телефоны</option><option value="101">Товары для компьютера</option><option value="105">Фототехника</option></optgroup><optgroup label="Хобби и отдых"><option value="33">Билеты и путешествия</option><option value="34">Велосипеды</option><option value="83">Книги и журналы</option><option value="36">Коллекционирование</option><option value="38">Музыкальные инструменты</option><option value="102">Охота и рыбалка</option><option value="39">Спорт и отдых</option><option value="103">Знакомства</option></optgroup><optgroup label="Животные"><option value="89">Собаки</option><option value="90">Кошки</option><option value="91">Птицы</option><option value="92">Аквариум</option><option value="93">Другие животные</option><option value="94">Товары для животных</option></optgroup><optgroup label="Для бизнеса"><option value="116">Готовый бизнес</option><option value="40">Оборудование для бизнеса</option></optgroup></select> </div>

<div id="f_title" class="form-row f_title"> <label for="fld_title" class="form-label">Название объявления</label> <input type="text" maxlength="50" class="form-input-text-long" value="" name="title" id="fld_title"> </div>
    <div class="form-row"> <label for="fld_description" class="form-label" id="js-description-label">Описание объявления</label> <textarea maxlength="3000" name="description" id="fld_description" class="form-input-textarea"></textarea> </div>
    <div id="price_rw" class="form-row rl"> <label id="price_lbl" for="fld_price" class="form-label">Цена</label> <input type="text" maxlength="9" class="form-input-text-short" value="0" name="price" id="fld_price">&nbsp;<span id="fld_price_title">руб.</span> <a class="link_plain grey right_price c-2 icon-link" id="js-price-link" href="/info/pravilnye_ceny?plain"><span>Правильно указывайте цену</span></a> </div>


    <div class="form-row-indented form-row-submit b-vas-submit" id="js_additem_form_submit">
        <div class="vas-submit-button pull-left"> <span class="vas-submit-border"></span> 
        <span class="vas-submit-triangle"></span> 
        <input type="submit" value="Добавить" id="form_submit" name="main_form" 
        class="vas-submit-input"> </div>
    </div>
</form>
</body>';
}




function output_advertise() {
    
    /*    3) Под формой создать вывод всех объявлений, содержащихся в сессии по шаблону:
   Название объявления | Цена | Имя | Удалить
   
   5) При нажатии на «Удалить», объявление удаляется из сессии
   
   */  
    
    global $temp_array;

        echo "<br><br><br><b>Ваши объявления</b>";
    echo "<br>Название объявления | Цена | Имя | Удалить";
   
    
    if (isset($temp_array)) {

      $amount=count($temp_array);    

    
    foreach ($temp_array as $key => $value) {
    
        echo '<p>'
        .'<a href=/test/dz7_1.php?edit=1&id='.$key.'>'.$temp_array[$key]['title'].'</a> | '
        .$temp_array[$key]['price'].' | '
        .$temp_array['seller_name'].' | <a href=/test/dz7_1.php?del=1&id='.$key.'>Удалить</a></p>';
        
    
    }
    
    }
       
        
    } 
    
    
ob_end_flush(); 
    
?>
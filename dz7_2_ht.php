<?php

header('Content-type: text/html; charset=utf-8');
$otladka0=0;
$otladka=0;
$otladka2=0;
$reset=0;
$delete=0;
$ads_f='ads.txt';
$current_php_script='dz7_2_ht';

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
?>



<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>avito.ru</title>
</head>
<body>
    
<!-- ФОРМА -->    
    
<form  method="post">
<div class="form-row-indented"> 
<label class="form-label-radio">
<input type="radio" <?php echo $checkedPrivate ?> value='1' name="private">Частное лицо
</label> 
    <label class="form-label-radio">
<input type="radio" <?php echo $checkedCompany ?> value='0' name="private">Компания</label> </div>

<!-- ИМЯ -->
    
<div class="form-row"> 
<label for="fld_seller_name" class="form-label">
<b id="your-name">Ваше имя</b></label>
<input type="text" maxlength="40" class="form-input-text" 
       value="<?php echo $seller_name ?>" name="seller_name" id="fld_seller_name">
</div>


<div class="form-row"> <label for="fld_email" class="form-label">Электронная почта</label>
    <input type="text" class="form-input-text"
           value="<?php echo $email ?>" name="email" id="fld_email">
</div>
    
    
    
    
    
<div class="form-row-indented"> <label class="form-label-checkbox" for="allow_mails">
<input type="checkbox" <?php echo $checked_allow_mails ?> value="1" name="allow_mails" id="allow_mails" 
   class="form-input-checkbox">
<span class="form-text-checkbox">Я не хочу получать вопросы по объявлению по e-mail</span>
    </label> </div>
    
<!-- ТЕЛЕФОН -->
    
<div class="form-row"> <label id="fld_phone_label" 
for="fld_phone" class="form-label">Номер телефона</label> 
<input type="text" class="form-input-text" value="<?php echo $phone ?>" name="phone" id="fld_phone">
</div>
    



<!-- ГОРОД -->

<div id="f_location_id" class="form-row form-row-required"> 
<label for="region" class="form-label">Город</label> 
<select title="Выберите Ваш город" name="location_id" id="region" class="form-input-select"> 
<option value="">-- Выберите город --</option>
<option class="opt-group" disabled="disabled">-- Города --</option>

<?php foreach ($cities as $city => $value): ?>
    
<option 
    
       <?php if ($location_id==$value ): ?>
            <?php echo $selected ?> 
    <?php endif ?>
    
    data-coords=",," 
    value="<?php echo $value ?>"
    ><?php echo $city ?>

</option>    
    

<?php endforeach ?>

</select></div>




<!-- МЕТРО -->

<div id="f_metro_id"> 
    <select title="Выберите станцию метро" name="metro_id" id="fld_metro_id" 
    class="form-input-select"> <option value="">-- Выберите станцию метро --</option>'

<?php foreach ($tube_stations as $tube_station => $value): ?>
    
<option 
    
       <?php if ($tube_station_id==$value ): ?>
            <?php echo $selected ?> 
    <?php endif ?> 
    
    value="<?php echo $value ?>"
    ><?php echo $tube_station ?>

</option>    
    

<?php endforeach ?>

</select> </div>



<!-- КАТЕГОРИЯ -->

<div class="form-row"> 
<label for="fld_category_id" class="form-label">Категория</label> 
<select title="Выберите категорию объявления" name="category_id" 
id="fld_category_id" class="form-input-select">
<option value="">-- Выберите категорию --</option>

<?php foreach ($categories as $key => $category):?>
    
<optgroup label="<?php echo $key ?>"> 
    
        <?php foreach ($category as $key2 => $value):?>
    <option 
        
       <?php if ($category_id==$value ): ?>
            <?php echo $selected ?> 
        <?php endif ?> 
        
        value="<?php echo $value ?>"><?php echo $key2 ?></option>
        <?php endforeach ?>

</optgroup>

<?php endforeach ?>

</select> </div>



<!-- НАЗВАНИЕ ОБЪЯВЛЕНИЯ -->

<div id="f_title" class="form-row f_title"> 
<label for="fld_title" class="form-label">Название объявления</label> 
<input type="text" maxlength="50" class="form-input-text-long" 
value="<?php echo $title ?>" name="title" id="fld_title"> </div>






<!-- ОПИСАНИЕ ОБЪЯВЛЕНИЯ -->

<div class="form-row"> 
<label for="fld_description" class="form-label" id="js-description-label">Описание объявления</label>
<textarea maxlength="3000" name="description" 
          id="fld_description" class="form-input-textarea"><?php echo $description ?></textarea> </div>

          
          
          
          
          
<!-- ЦЕНА ОБЪЯВЛЕНИЯ -->

<div id="price_rw" class="form-row rl"> 
<label id="price_lbl" for="fld_price" class="form-label">Цена</label> 
<input type="text" maxlength="9" class="form-input-text-short" value="<?php echo $price ?>" 
name="price" id="fld_price">&nbsp;<span id="fld_price_title">руб.</span> 
<a class="link_plain grey right_price c-2 icon-link" id="js-price-link" 
   href="/info/pravilnye_ceny?plain"><span>Правильно указывайте цену</span></a> 
</div>






<!-- КНОПКИ  -->
    <div class="form-row-indented form-row-submit b-vas-submit" id="js_additem_form_submit">
        <div class="vas-submit-button pull-left"> <span class="vas-submit-border"></span> 
        <span class="vas-submit-triangle"></span> 

            <?php if ($post_edit) {

echo '<input type="submit" value="Записать изменения" id="form_submit" name="form" 
class="vas-submit-input">
<input type="submit" value="Назад" id="form_submit" name="form" class="vas-submit-input">
</div>';

}

else {

    echo '<input type="submit" value="Добавить" id="form_submit" name="main_form" 
        class="vas-submit-input"> ';
}         ?>
        
        </div>
    </div>
</form>
         
 <?php if ($amount_ads): ?>  
<br><br><br><b>Ваши объявления</b>
<br><p>Название объявления | Цена | Имя | Удалить</p>
    
<?php foreach ($temp_array as $key => $value): ?> 
    
<p><a href=/test/<?php echo $current_php_script ?>.php?edit=1&id=<?php echo $key ?>><?php echo $temp_array[$key]['title'] ?></a> | 
        <?php echo $temp_array[$key]['price'] ?> | 
        <?php echo $temp_array[$key]['seller_name'] ?> | 
        <a href=/test/<?php echo $current_php_script ?>.php?del=1&id=<?php echo $key ?>>Удалить</a></p>
<?php endforeach ?>
<?php endif ?>    
</body>
    </html>
    

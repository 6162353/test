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

header('Content-type: text/html; charset=utf-8');


$reset=0;
$delete=0;
$ads_f='ads.txt';
$current_php_script='dz9';


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
$db_user='dz9';
$db_name='dz9';
$db_server='localhost';


$conn = mysql_connect(
$db_server, $db_user,$db_user)
or die("Невозможно установить соединение: ". mysql_error());

mysql_select_db($db_name);
mysql_query('SET NAMES utf8');



/*
Теперь в $cities то же, что я раньше объявлела в скрипте:

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
 * 
 * Остальные переменные определим аналогично

*/

$query='select * from cities order by id ASC';

$result_query = mysql_query($query) or die('Запрос не удался');

while ($result = mysql_fetch_assoc($result_query)) {
    
    $cities[$result['city']]=$result['id'];
}



$tube_station_id='';

/* МЕТРО $tube_stations  */

$query='select * from tube_stations order by tube_station ASC';

$result_query = mysql_query($query) or die('Запрос не удался');

while ($result = mysql_fetch_assoc($result_query)) {
$tube_stations[$result['tube_station']]=$result['id'];
}





$category_id='';


$query='select * from categories order by id ASC';
$result_query = mysql_query($query) or die('Запрос не удался');
while ($result = mysql_fetch_assoc($result_query)) {

$subquery='select * from subcategories where category='.$result['id'].' order by subcategory';
$result_subquery = mysql_query($subquery) or die('Запрос не удался');


    while ($result2 = mysql_fetch_assoc($result_subquery)) {

    $subcategory[$result2['subcategory']]=$result2['id'];

    }

$categories[$result['category']]=$subcategory;

//обнуляем
mysql_free_result($result_subquery);
$subcategory=array();


}



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



$smarty->display($current_php_script.'.tpl');

mysql_free_result($result_query);
mysql_close($conn);

?>


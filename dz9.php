<?php

/* dz9.php
 * 
 Задание dz_8.php переделать с помощью хранения информации в БД
    Для категорий и городов сделать отдельные таблицы
    Для каждого объявления использовать одну строку в БД

    Затем сдаете задачу в планфиксе.
    Затем выполняете всё с помощью модуля mysqli

    Затем снова сдаете задачу в планфиксе.
 */

$otladka=1;
$otladka2=0;


$project_root=$_SERVER['DOCUMENT_ROOT'];

if ($otladka2) {
echo '$project_root='.$project_root.'<br>';
}


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

$mysql_last_id='';


$conn = mysql_connect(
$db_server, $db_user,$db_user)
or die("Невозможно установить соединение: ". mysql_error());

mysql_select_db($db_name);
mysql_query('SET NAMES utf8');



/*
Теперь в $cities то же, что я раньше объявляла в скрипте:

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
через бд
*/


if ($reset) {
$GLOBALS["_POST"]=null;


unlink('ads.txt');
}



$query='select * from ads order by id ASC';

$result_query = mysql_query($query) or die('Запрос из ads не удался');

if ($result = mysql_fetch_assoc($result_query)) {
    
$temp_array[]=$result;

        if ($otladka2) {
            echo '$temp_array после 1 строки запроса=\n';
            var_dump($temp_array);
        }



while ($result = mysql_fetch_assoc($result_query)) {
    $temp_array[]=$result;
    
            if ($otladka2) {
            echo '$temp_array после while c 2 строки запроса=\n';
            var_dump($temp_array);
        }
    }
}


/*if (file_exists('ads.txt')) {
    $ads_t=file_get_contents('ads.txt');
    $temp_array=unserialize($ads_t);
    
    $ads_h=fopen($ads_f,'r+');

    } */

else {


/*$ads_h=fopen($ads_f,'w+');
$ads_t='a:0:{}';
fwrite($ads_h,$ads_t);*/
$temp_array=array();

        }
        

        
        

if (isset($_POST['form'])) {
    if ($_POST['form']=="Записать изменения") {
// сохранить элемент
        
//$temp_array[$_GET['id']]=$_POST;


/*$ads_t=serialize($temp_array);
        fseek($ads_h,0);
        fwrite($ads_h,$ads_t); */

// записать изменение в базу

if (isset($_POST['allow_mails'])) {
            
        $allow_mails=$_POST['allow_mails'];
        }
        
        else {
            
            $allow_mails='0';
            
        }

        //Изменили значение
        
        $query='UPDATE ads SET '.
        'title="'.$_POST['title'].'", price="'.$_POST['price']. 
        '", user_name="'.$_POST['seller_name'].'", email="'.$_POST['email'].
        '", tel="'.$_POST['phone'].'", descr="'.$_POST['description'].
        '", id_city="'.$_POST['location_id'].'", id_tube_station="'.$_POST['metro_id'].
        '", id_subcategory="'.$_POST['category_id'].'", private="'.$_POST['private'].
        '", send_to_email="'.$allow_mails.  
        '" WHERE id='.$_GET['id'].';';
        
if ($otladka2) {
                echo '<p><b>$query строка запроса= </b></p>';
        var_dump($query);
}
        

        $result_query = mysql_query($query) or die('Изменение не удалось');
        
        // обновляем в temp_array
        
        $query='select * from ads where ads.id='.$_GET["id"].';';

$result_query = mysql_query($query) or die('Получение измененного элемента не удалось');        
        
if ($otladka2) {
                echo '<p><b>$temp_array до вставки обновленного элемента= </b></p>';
        var_dump($temp_array);
}


foreach ($temp_array as $key => $value) {
    
        if ($otladka2) {
                echo '<p><b>$key= </b></p>';
        var_dump($key);
}
    
        if ($temp_array[$key]['id']==$_GET["id"]) {
            
            $temp_array[$key]=mysql_fetch_assoc($result_query);
            
        }
    }
       
        
        
$_POST=null;
}
    if ($_POST['form']=="Назад") {
$_POST=null;
unset($_GET);
//fclose($ads_h);
header('Location:/test/'.$current_php_script.'.php');
}
}

// если гет заполнен, значит запросили удаление или просмотр
if (isset($_GET["id"])) {
    if (isset($_GET["del"])) {
    //if (isset($temp_array[$_GET["id"]])) {


$query='delete from ads where ads.id='.$_GET["id"].';';

$result_query = mysql_query($query) or die('Удаление выбранного элемента не удалось');        
        
if ($otladka2) {
                echo '<p><b>$temp_array до удаления элемента= </b></p>';
        var_dump($temp_array);
}


foreach ($temp_array as $key => $value) {
    
        if ($otladka2) {
                echo '<p><b>$key= </b></p>';
        var_dump($key);
}
    
        if ($temp_array[$key]['id']==$_GET["id"]) {
            
            unset($temp_array[$key]);
            
        }
    }

if ($otladka2) {
                echo '<p><b>$temp_array после удаления элемента= </b></p>';
        var_dump($temp_array);
}        
        
        

unset($_GET["id"]);


/*$ads_t=  serialize($temp_array);


     
        fseek($ads_h,0);
        fwrite($ads_h,$ads_t);
   
fclose($ads_h); */
header('Location:/test/'.$current_php_script.'.php');


  

}


    if (isset($_GET["edit"])) {
        
        $id=$_GET['id'];
        $post_edit=1;
        
        foreach ($temp_array as $value) {
            
            
        if ($value['id']==$id) {
            
        if ($otladka2) {
                echo '<p><b>var_dump($value)= </b></p>';
        var_dump($value);
}    
            
            
            
        if ($value['private']=='1') {
            
            $checkedPrivate = 'checked';
            $checkedCompany = '';
        }
        
        else {
            
                $checkedPrivate = '';
            $checkedCompany = 'checked';
            
        }
        
        $seller_name = $value['user_name'];
        $email= $value['email'];
        
        if ($value['send_to_email']=='0' or $value['send_to_email']=='' ) {
            
            $checked_allow_mails = '';
        }
        
        else {
            
            $checked_allow_mails = 'checked';
            
        }
        
 
        $phone=$value['tel'];
        
        $location_id=$value['id_city'];
        $tube_station_id=$value['id_tube_station'];
        $category_id=$value['id_subcategory'];
        $title=$value['title'];
        $description=$value['descr'];
        $price=$value['price'];
        }
        
        }

}
}
// если заполнен пост

    elseif (count($_POST)) {
if (isset($_POST['main_form'])) {
if ($_POST['main_form']=='Добавить') {
        

        //array_push($temp_array,$_POST);
        
    if ($otladka2) {
                echo '<p><b>var_dump($_POST)= </b></p>';
        var_dump($_POST);
}
    
        // allow_mails приходит от формы только тогда, когда установлен checkbox
        // а так вообще нет этой переменной, если он не установлен.
        if (isset($_POST['allow_mails'])) {
            
        $allow_mails=$_POST['allow_mails'];
        }
        
        else {
            
            $allow_mails='';
            
        }

        //вставили значение
        
        $query='INSERT into ads '.
        '(title, price, user_name, email, tel, descr, id_city, '.
        'id_tube_station, id_subcategory, private, send_to_email) '.
        'VALUES ("'.$_POST['title'].'", "'.$_POST['price'].'", "'.$_POST['seller_name'].'", "'
        .$_POST['email'].'", "'.$_POST['phone'].'", "'.$_POST['description'].'", "'
        .$_POST['location_id'].'", "'.$_POST['metro_id'].'", "'.$_POST['category_id'].'", "'
        .$_POST['private'].'", "'.$allow_mails.'" );';
        
            if ($otladka2) {
                echo '<p><b>var_dump($query)= </b></p>';
        var_dump($query);
        
                        echo '<p><b>var_dump($temp_array)= </b></p>';
        var_dump($temp_array);
        
}

        $result_query = mysql_query($query) or die('Вставка в ads не удалась');
        
        

        /*if (isset($_POST['allow_mails'])) {
        
         $query='INSERT into ads '.
        '(sent_to_email) '.
        'VALUES ('.$_POST['allow_mails'].')';

        $result_query = mysql_query($query) or die('Вставка allow_mails не удалась');       
        
        
        } */
        
        /*
        $ads_t=serialize($temp_array);

        $ads_h=fopen($ads_f,'r+');
        fseek($ads_h,0);
        fwrite($ads_h,$ads_t);
        */
        
        // добавляем к temp_array вставленное значение, для мгновенного отображения
        
        if ($otladka2) {
            $mysql_last_id=mysql_insert_id();
                echo '<p><b>$mysql_last_id= </b></p>';
        var_dump($mysql_last_id);
        }
        
        $mysql_last_id=mysql_insert_id();
        $query='SELECT * from ads WHERE id='.$mysql_last_id.';';
        $result_query = mysql_query($query) or die('Запрос из ads последнего объявления не удался');
        $temp_array[]= mysql_fetch_assoc($result_query); 
        
        if ($otladka2) {
            
                echo '<p><b>$$temp_array= </b></p>';
        var_dump($temp_array);
        
        }
        

        
        

}
}

}

if (isset($temp_array)) {
        

      $amount_ads=count($temp_array); 

}

    
//fclose($ads_h); 

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

if (!is_bool($result_query)) {
mysql_free_result($result_query);
}
mysql_close($conn);

?>


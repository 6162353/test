<?php

/* 
 Lesson 4
 */




header('Content-type: text/html; charset=utf-8');



$ini_string='
[игрушка мягкая мишка белый]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';
    
[одежда детская куртка синяя синтепон]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';
    
[игрушка детская велосипед]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';

';


$bd=parse_ini_string($ini_string, true);
//print_r($bd);

/*
 * - Вам нужно вывести корзину для покупателя, где указать: 
 * 1) Перечень заказанных товаров, их цену, кол-во и остаток на складе
 * 
 * Судя по следующим заданиям хочется следующее устройство Корзины:
 * ====
1)Корзина
 * таблица с заказанными товарами и выпавшими скидочными купонами

2)уведомление, что каких-то товаров нет
3)Уведомление о добавочной скидке на определенный вид товара, скидочные акции

Итоговая таблица с товаром в наличии, цены со скидками

Всего товаров:
Конечная сумма:
Сэкономлено: 
=========
*/

/*1)Корзина
 * таблица с заказанными товарами и выпавшими скидочными купонами
*/

echo '<h1>Корзина</h1>';
echo '<p>Вы заказали:</p>';
//echo '<br>'  Шапка;
echo '<table border="1" width="960px">'
. '<tr>'
        . '<td width="50%">Наименование товара</td><td width="10%">Цена</td><td width="10%">Кол-во</td>'
        . '<td width="10%">На складе</td><td width="10%">Скидочный купон</td>'
.'</tr>';



$amount1=count($bd);
$elem=current($bd);
$net_na_sklade=array();
$amount_itogo=array();
$skidka_itogo=array(); // можно менять скидку в исходоном массиве или добавлять элементы в исходный
// я пока попроще сделаю, как идёт. 

// Вывод первой таблицы, таблицы заказа - наименование - кол-во - на складе - скидка

for ($i=0;  $i<$amount1 ; $i++ ) {
    
    $skidka=0;
    
    
        /*
        Для вывода акции по товару детский велосипед
    // запоминаем, больше ли трех заказано этого товара. 
    */
    
    $amount_itogo[key($bd)]=v_nalichii($elem['количество заказано'],$elem['осталось на складе']);

    // скидку реализуем через switch, если нужно что-то добавлять - это проще, чем if
    //И нас есть такое условие, использовать этот оператор
    
    
    switch ($elem['diskont']) {
        
        
        
        case 'diskont2':
            $skidka_itogo[key($bd)]=0.2;
            break;
        
        case 'diskont1':
            $skidka_itogo[key($bd)]=0.1;
            break;
        
        case 'diskont0':
            $skidka_itogo[key($bd)]=0;
            break;    
        
    }
    
    
if ($elem['количество заказано']!='0') {
 
    echo '<tr>'
        .'<td width="50%">'.key($bd).'</td><td width="10%">'.$elem['цена'].' руб.</td>'
        .'<td width="10%">'.$elem['количество заказано'].'</td>'
        .'<td width="10%">'.$elem['осталось на складе'].'</td>'
        . '<td width="10%">'.v_prozenti_str($skidka_itogo[key($bd)]).'</td>';
    

    // для вывода уведомлений об отсутствии товара, запоминаем каких товаров не оказалось на складе
    
        if ($elem['осталось на складе']==0) {
            array_push($net_na_sklade,key($bd));
        }
   
    }
    
    $elem=next($bd);

}
echo '</table>';



/*  /* - Вам нужно сделать секцию "Уведомления", где необходимо извещать покупателя о том,
 *  что нужного количества товара не оказалось на складе
 * */
//2)уведомление, что каких-то товаров нет
// Так как просмотр массива с товарами мы уже сделали, то вычисление, что товара нет, должно
// происходить там, здесь происходит только вывод


$amount_sklad=count($net_na_sklade);
    
if ($amount_sklad) {
    
    //echo '<p><b>Уведомление!</b></p>';
    echo '<p><b>Уведомление! На складе нет следующих позиций:</b></p>';
    for ($i=0; $i<$amount_sklad; $i++ ) {
        echo '<p>'.$net_na_sklade[$i].'</p>';
    }
    
    
}

// 3)Уведомление о добавочной скидке на определенный вид товара, скидочные акции
/*
Вам нужно сделать секцию "Скидки", где известить покупателя о том, что если он заказал "игрушка 
детская велосипед" в количестве >=3 штук, то на эту позицию ему 
 * автоматически дается скидка 30% (соответственно цены в корзине пересчитываются тоже автоматически)
*/

// Тоже самое, массив мы уже проходили, нужно там запомнить. что велосипедов было больше 3
  
    if ($amount_itogo["игрушка детская велосипед"]>=3) {
        echo '<p><b>Акция!</b></p>';
    echo '<p>Вы заказали товар "игрушка детская велосипед" более 2 штук. Вы получаете скидку на данный товар 30%.</p>';
        //echo '<p>Вы получаете скидку на данный товар 30%.</p>';
        $skidka_itogo["игрушка детская велосипед"]=0.3;
        
        
        
    }

/*  2) В секции ИТОГО должно быть указано: сколько всего наименовний было заказано, 
 * каково общее количество товара, какова общая сумма заказа
 *
 */

echo '<br><br><h2>Итого:</h2>';
//echo '<br>';
echo '<table border="1" width="960px">'
. '<tr>'
        . '<td width="30%">Заказаны следующие наименования</td><td width="10%">Кол-во в наличии</td>'
        . '<td width="10%">Цена за 1шт.</td>'
        .'<td width="10%">Итоговая цена без скидки</td>'
        . '<td width="10%">Итоговая скидка за 1шт.</td>'
        .'<td width="10%">Итоговая цена за 1шт.</td>'
        .'<td width="10%">Итоговая цена</td>'
        .'<td width="10%">Итоговая экономия</td>'
.'</tr>'
        ;

$amount2=count($amount_itogo);
$zena_itogo_per_elem=array();
$zena_itogo=array();
$zena_itogo_without_disckont=array();
$economia_itogo=array();
$elem=reset($bd);


for ($j=0; $j<$amount2; $j++) {
    

    array_push($zena_itogo_per_elem,$elem['цена']-($elem['цена']*$skidka_itogo[key($bd)]));
    array_push($zena_itogo,$amount_itogo[key($bd)]*$zena_itogo_per_elem[$j]);   
    array_push($economia_itogo,($elem['цена']-$zena_itogo_per_elem[$j])*$amount_itogo[key($bd)]);
    array_push($zena_itogo_without_disckont,$elem['цена']*$amount_itogo[key($bd)]);
    
    
    
    if ($amount_itogo[key($bd)]) {
    
    echo '<tr>'
        . '<td width="30%">'.key($bd).'</td><td width="10%">'.$amount_itogo[key($bd)].'</td>'
        . '<td width="10%">'.$elem['цена'].'</td>'
            . '<td width="10%">'.$zena_itogo_without_disckont[$j].'</td>'
            . '<td width="10%">'.v_prozenti_str($skidka_itogo[key($bd)]).'</td>'
        .'<td width="10%">'.$zena_itogo_per_elem[$j].' руб.</td>'
        .'<td width="10%">'.$zena_itogo[$j].' руб.</td>'
        .'<td width="10%">'.$economia_itogo[$j].' руб.</td>' 
        .'</tr>'
            ;

    
    }
    
    $elem=next($bd);
    
}

echo '</table>';

echo '<br><p><b>Общее количество товаров: '.array_sum($amount_itogo).' штук.</b></p>';
echo '<p>Общая сумма заказа без скидок: <b>'.array_sum($zena_itogo_without_disckont).' руб.</b></p>';
echo '<br><p><b>Общая сумма заказа: '.array_sum($zena_itogo).' руб.</b></p>';
echo '<p><b>Экономия с заказа: '.array_sum($economia_itogo).' руб.</b></p>';


/*
3) у каждого товара есть автоматически генерируемый скидочный купон diskont, 
 * используйте переменную функцию, чтобы делать скидку на итоговую цену в корзине
 * diskont0 = скидок нет, diskont1 = 10%, diskont2 = 20%
 * 
 * Это тоже нужно где-то отображать, думаю это нужно отражать в начальной таблице.
*/

function v_nalichii($zakazano,$na_sklade)
{   
    static $elem_sale=0;


    if ($zakazano<=$na_sklade) {
            
            $elem_sale=$zakazano;
        }
        
        else { 
            $elem_sale=$na_sklade;
        }
       
    return $elem_sale;
}

function v_prozenti_str($skidka)
{   
    static $skidka_str='';

    
    switch ($skidka) {
        
        case 0.3:
            $skidka_str='30%';
            break;
        
        case 0.2:
            $skidka_str='20%';
           break;
        
        case 0.1:
            $skidka_str='10%';
           break;
        
        case 0:
            $skidka_str='Нет ';
            break;    
        
    }            
    return $skidka_str;
}


?>


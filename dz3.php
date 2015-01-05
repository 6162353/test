<?php

header('Content-type: text/html; charset=utf-8');



$date=array(4);

mt_srand(time());

$now=time();

$date2=array();

for ($i=0; $i<=4; $i++) {
    $date[$i]=mt_rand(0,$now);
    $date2[$i]= getdate($date[$i]);
    
}

$amount=count($date2[0]);
  
$date_day=array();
$date_month=array(); 

for ($i=0; $i<=4; $i++) {
    
    $date_day[$i] = $date2[$i]['mday'];
    $date_month[$i] = $date2[$i]['mon'];
    
    
    }
    
echo '<br><p> the lowest day is '.min($date_day).'</p>';
echo '<p> the greatest month is '.max($date_month).'</p>';


sort($date);

$selected=array_pop($date);

echo '<br><p>$selected is '.date("d.m.y H:i:s",$selected).'</p>';

date_default_timezone_set('America/New_York');
echo '<p> Time in New York is '.date("d.m.y H:i:s",time()+60*60).'</p>';



?>
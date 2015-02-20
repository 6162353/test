<?php



$ads_f=fopen('ads.txt','w+');

$ads_t='a:0:{}';
fwrite($ads_f,$ads_t);



$ads_t2=file_get_contents('ads.txt');

echo $ads_t2;

echo var_dump(file_exists('ads.txt'));


/*
chgrp('ads.txt','www-data');

echo __DIR__;
echo __DIR__.'/ads.txt';

chown( __DIR__.'/ads.txt','www-data');

//echo file_exists('ads.txt');

echo var_dump(file_exists('ads.txt'));

fclose($ads_f);*/

?>
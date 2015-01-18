<?php
header('Content-type: text/html; charset=utf-8');
$otladka=1;

$bd[][]=array();

            if ($otladka) { 
                                echo '<p><b>var_dump($bd)= </b></p>';
        var_dump($bd);    
        }


$advertise=array( "title" => "Котенок", "price" => 200);

            if ($otladka) { 
                                echo '<p><b>var_dump($advertise)= </b></p>';
        var_dump($advertise);    
        }
        

/*

for ($i=0; $i++; $i<count($bd); ) {
    
    var_dump($bd[i]);

};  */
//Точка с запятой в конце условия цикла - ошибка

$bd['count']=0;

    
            if ($otladka) { 
                                echo '<p><b>var_dump($bd["count"])= </b></p>';
        var_dump($bd['count']);    
        }

$bd['count']++;

            if ($otladka) { 
                                echo '<p><b>var_dump($bd["count"])= </b></p>';
        var_dump($bd['count']);    
        }
        
$bd[0]["advertise"]=$advertise;

            if ($otladka) { 
                                echo '<p><b>var_dump($bd)= </b></p>';
        var_dump($bd);    
        }
        
        

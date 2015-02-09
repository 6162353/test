<?php

ob_start(); 


$otladka=1;
$otladka2=0;
$reset_session=0;
$delete=0;
$temp_array=array();

header('Content-type: text/html; charset=utf-8');


if (isset($_COOKIE['advertise'])) {
     $advertise=$_COOKIE['advertise'];
     //$count=$_SESSION['count'];
     
    if ($otladka) { 
                    echo 'Куки установлена с пред. раза var_dump($_COOKIE)= \n';
    var_dump($_COOKIE);    
    } 
    
    if ($otladka) { 
                    echo '$advertise= \n';
    var_dump($advertise);    
    }     

     
     
    } 
else {

$advertise="1";

if (setcookie("advertise",$advertise,time()+ 3600 * 24 * 7))
// сразу же и устанавливает куки
    {
    
        echo "куки установлен\n";
        if ($otladka) {

            echo "Cookie успешно установлен!\n";

        }




    if ($otladka) {

            echo "var_dump(Cookie)= \n";
            echo var_dump($_COOKIE["advertise"]);


        }


                }

}

if ($reset_session) {
   setcookie("advertise",$advertise,time()- 3600 * 24 * 7);

       if ($otladka) {

            echo "После удаления сессии var_dump(Cookie)= \n";
            echo var_dump($_COOKIE["advertise"]);


        }
    
    
}

/*


            


*/
ob_end_flush(); 

?>


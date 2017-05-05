<?php
$root = "./";
include 'includes.php'; 

$Adao = new AchievementsDAO(LocalDBClientBuilder::get());//DynamoDbClientBuilder::get());

if(!empty($_GET['email'])){
    $email = $_GET['email'];
    
    if(empty($_GET['ninja']) && empty($_GET['curieux'])){
        $ninja = $Adao->getNinja($email);
        $curious = $Adao->getCurious($email);
        $items =  array();
        if($ninja>=2)
            $items[]="ninja";
        if ($curious>=2)
            $items[]="curious";
        header('Content-Type: application/json');
        $response = json_encode($items);
        echo $response;
    }
    else{
        if(!empty($_GET['ninja'])){
        $ninja = $_GET['ninja'];
        $Adao->updateNinja($email, $ninja);
        }
        
        if(!empty($_GET['curieux'])){
         $curious = $_GET['curieux'];
         $Adao->updateCurious($email, $curious);
        }
        
        echo $ninja;
        
        
        echo 'a';
    }
}
?>


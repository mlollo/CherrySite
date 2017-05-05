<?php
$root = "./";
include 'includes.php'; 

$Adao = new AchievementsDAO(LocalDBClientBuilder::get());//DynamoDbClientBuilder::get());

if(!empty($_GET['email'])){
    $email = $_GET['email'];
    if(empty($_GET['avatar'])){
        $avatar = $Adao->getAvatar($email);

        header('Content-Type: application/json');

        $response = json_encode(array($avatar));
        echo $response;
    }
    else{
        $avatar = $_GET['avatar'];
        echo $avatar;
        $Adao->updateAvatar($email, $avatar);
        //echo 'a';
    }
}
?>


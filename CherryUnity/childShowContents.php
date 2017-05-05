<?php session_start() ?>
<!doctype html>
<html>
    
<head>
    <?php include 'head.php' ?>
    <title>Content </title>
</head>

<body>
    <?php include 'nav.php' ?>
    <h1>Gestion de contenus de l'enfant</h1>
    
    <?php    
    $root = './';
    include "includes.php";
    
    $contentDao = new ContentDAO(LocalDBClientBuilder::get());//DynamoDbClientBuilder::get());
    $childDao = new ChildDAO(LocalDBClientBuilder::get());//DynamoDbClientBuilder::get());
    $email = $_SESSION['email'];
    $child = $childDao->get($email);
       
    // URL parameter
    // parameter 'type', possible values : {teacher, family, doctor}
    $type = $_GET['type'];
    
    // use method getContentyType ??
    if($type == 'teacher') {
        $contents = $child->getTeachingContent();
    } else if ($type == 'family') {
        $contents = $child->getFamilyContent();
    } else if ($type == 'doctor') {
        $contents = $child->getMedicalContent();
    }
        
    $length = count($contents);
    
    echo '<ul>';
    for ($i = 0; $i < $length; $i++) {
        $contentInfo = $contents[$i];
        
        $name = $contentInfo['M']['name']['S'];
        $owner = $contentInfo['M']['owner']['S'];
        $date = $contentInfo['M']['date']['S'];
        $content = $contentDao->get($name, $owner);
        
        $notified = $child->isNotified($name, $type);
        
        if ($notified) {$class = 'class="read"';} 
        else {$class = 'class="unread"';}
        
        if ($content != null) {
            echo '<li>'. '<a '.$class.' href=downloadFile.php?name='.$name.'&type='.$type.'>'.$name.'</a>' .'</li>';
        }
        /*  
         * vérifier que la date a bien été dépassé avant
         * de proposer le contenu
         */
    }
    echo '</ul>';
    ?>
    
    <?php include 'footer.php' ?>

</body>
</html>
<?php
    session_start();

    include "includes.php";

    $name = $_GET['name'];
    $type = $_GET['type'];
    
    if (!empty($type)) {
        $email = $_SESSION['email'];
        $childDAO = new ChildDAO(LocalDBClientBuilder::get());//DynamoDbClientBuilder::get());
        $child = $childDAO->get($email);
        $child->readContent($name, $type);
        $childDAO->update($child);
        echo '<pre>';print_r($child->getContentByType($type)); echo '</pre></br>';
    }
    
    $s3 = new S3Access(S3ClientBuilder::get());
    $result = $s3->getFile($name);
    
    header("Content-Type: {$result['ContentType']}");
    header("Content-Disposition: attachment; filename=\"$name\"");
    
    echo $result['Body'];
    
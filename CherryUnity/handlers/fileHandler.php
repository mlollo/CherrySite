<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf8">
    <title>Upload</title>
    <?php 
        session_start();
        $root = "../";
        require "../includes.php";
    ?>
</head>

<body>
<?php
    //get the children from the request

    $children =  array();
    $length = count($_POST['children']);
    for($i = 0; $i < $length; $i++) {
        $string = $_POST['children'][$i];
      //  print 'DEBUG>> : $string vaut '.$string;
        $email = split(",", $string)[0];
      //  print 'DEBUG>> : $email vaut '.$email;
        $date_en = split(",", $string)[1];
        $date = new Date($date_en, "en");
        $date_in = $date->toString("in");

        $date_end = split(",", $string)[2];
        console.log($date_end);
        $date_nd = new Date($date_end, "en");
        $date_ind = $date_nd->toString("in");
       // print 'DEBUG>> : $date vaut '.$date_in."MM";
        $children[] = array('email' => $email, 'dateStart' => $date_in, 'dateEnd' => $date_ind);
      //  print 'DEBUG>> : $children[0] vaut '.$children[0]['dateStart']."MM";
        //$children[] = array('email' => "enfant@gmail.com", 'date' => "01/01/1901");
    }

    $size = count($_FILES['files']['tmp_name']);
    
    for($i = 1; $i < $size; $i++){//Iterate over the files(start 1)
        // UPLOAD SUR EC2
        
        //pour Tomcat
 /*       $ds = DIRECTORY_SEPARATOR;
        $storeFolder = 'uploads';
        $name = $_FILES['files']['name'][$i];
        
        if (!empty($_FILES)) {

            $tempFile = $_FILES['files']['tmp_name'][$i];
            $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;            
            $targetFile =  $targetPath.$name;
        }
        //fin pour tomcat
        /*$path = "/var/www/";//"/var/www/html/";
        $name = $_FILES['files']['name'][$i];
        $path = $path.$name;*/
        
        //echo "   deplacer : ".$_FILES['files']['tmp_name'][$i]."    vers : ".$targetFile." - ";
    //    echo move_uploaded_file($_FILES['files']['tmp_name'][$i], $targetFile);// $path);
        

        // UPLOAD SUR S3
        $s3 = new S3Access(LocalDBClientBuilder::get());//S3ClientBuilder::get());
        //$url = $s3->createFile($name, $targetFile);//$path);
        //$url = "http:/localhost/PhpProject_test/downloadFile.php?name=".$_FILES['files']['name'][$i]."&type=".$_SESSION['type'];
        move_uploaded_file($_FILES['files']['tmp_name'][$i], "C:\\xampp\\htdocs\\Cherry\\CherryUnity\\uploads\\".$_FILES['files']['name'][$i] );
        $url = "http://localhost/Cherry/CherryUnity/uploads/".$_FILES['files']['name'][$i];
        //echo '       !!! test !!!  -'.$url.'_        ';
        
        // INSERT SUR DYNAMO
        $emailOwner = $_SESSION['email'];
        $type = $_SESSION['type'];
        $contentDao = new ContentDAO(LocalDBClientBuilder::get());//DynamoDbClientBuilder::get());
        $content = new Content();
        $content->setUrl($url);
        $content->setEmailOwner($emailOwner);
        $content->setName($_FILES['files']['name'][$i]);
        $content->setType($type);
        $contentDao->create($content, $children);
         
    }
    
    ?>
</body>
</html>

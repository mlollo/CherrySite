<?php
// Désactiver le rapport d'erreurs
    error_reporting(0);
    session_start();

$root = "./";
require "includes.php";

//print_r($_GET);

$name = htmlspecialchars($_GET['name']);
$owner = htmlspecialchars($_GET['owner']);
$ajouter = htmlspecialchars($_GET['ajouter']);

if(!$ajouter)
{
    //si il y a un 'name' de transmis
    if($name && !$owner)
    {
        $_SESSION['switch']= 1;//htmlspecialchars($_GET['name']);
        //echo $name."<br/>MARCHE<br/>";

        //recherche un contenue ayant comme titre $name et owner "admin_off"
        $contentDao = new ContentDAO(LocalDBClientBuilder::get());
        $contentDAOExist = $contentDao->get($name, "admin_off");
        $contentExist = new Content();
        //recupere les valeurs
        $contentExist = $contentDAOExist;   
        $urlExist = $contentExist->getUrl();
        $ownerExist = $contentExist->getEmailOwner();
        //print_r ($contentExist);

        //si le contenue est trouve (qu'il y a bien une url)
        if($urlExist) {
            
            //le owner est "admin_off" ==> le change en "admin_on" (pour lancer la video)
            $contentExist->setEmailOwner("admin_on");
            $ownerExist = $contentExist->getEmailOwner();
            $children =  array();
            //$children[] = array('email' => $_POST['child'], 'dateStart' => $_POST['date_debut'], 'dateEnd' => $_POST['date_fin']);
            $contentDao->UpDate($contentExist, $children);
             echo $urlExist; 
            $contentDao0->delete($name, "admin_off");
            //print_r ($contentExist);

        }
        else 
            echo "Pas de contenue ayant comme titre \"".$name."\" et détenue par \"admin_off\"";



    }
    //si il y a un 'name' & 'owner' de transmis
    else if($owner && $name)
    {
        //$_SESSION['switch']= 0;
        $contentDao0 = new ContentDAO(LocalDBClientBuilder::get());
        $contentDAOExist0 = $contentDao0->get($name, $owner);
        $contentExist0 = new Content();
        //recupere les valeurs
        $contentExist0 = $contentDAOExist0;   
        $urlExist0 = $contentExist0->getUrl();
        $ownerExist0 = $contentExist0->getEmailOwner();

        if($urlExist0)
        {
            $contentExist0->setEmailOwner($owner);
            $ownerExist0 = $contentExist0->getEmailOwner();
            $children0 =  array();
            //$children[] = array('email' => $_POST['child'], 'dateStart' => $_POST['date_debut'], 'dateEnd' => $_POST['date_fin']);
            $contentDao0->UpDate($contentExist0, $children0);
            echo "stop de la lecture de : ".$name;
            $contentDao0->delete($name, "admin_on");




            /*

         echo "<br/><br/>";

        $contentDao02 = new ContentDAO(LocalDBClientBuilder::get());
        $contents02 = $contentDao02->getContentsOfUser("admin_off");
        print_r($contents02);*/

        }
        else 
        {
            echo "Pas de contenue ayant comme titre \"".$name."\" et détenue par \"".$owner."admin_off\"";
        }
    }
    else
    {
        echo "Pas de valeur transmise ...<br/>En lecture : ";

       //Affiche tous les contenue ayant en owner = admin_on
        $email = "admin_on";
        $contentDao = new ContentDAO(LocalDBClientBuilder::get());
        $contents = $contentDao->getContentsOfUser($email);
        //print_r($contents);
        $length = count($contents);
        if($length == 0)
            echo "aucun document lu";
        for ($i = 0; $i < $length; $i++) 
        {
            $content = $contents[$i];
            $url = $content->getUrl();
            echo $url;
        }
        //DEBUG !!!
        /*
        echo "<br/>Document potentiellement lu :<br/>";
            $contentDao2 = new ContentDAO(DynamoDbClientBuilder::get());
            $contents2 = $contentDao2->getContentsOfUser("admin_off");
            print_r($contents2);

            echo "<br/><br/>Document lu";

            $contentDao_2 = new ContentDAO(DynamoDbClientBuilder::get());
            $contents_2 = $contentDao_2->getContentsOfUser("admin_on");
            print_r($contents_2);*/


    }
}
//si il y a un ajout d'un slide
else
{
        ?>
    <html>
    <head>
        <meta charset="utf8">
        <title>Ajout d'une presentation</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <script type='text/javascript' src='script.js'></script>
        <script type="text/javascript" src="js/bootstrap-filestyle.min.js"> </script>
        <?php 
            $root = "./";

            include 'head.php' ;
            require "includes.php";



        ?>

        <style type="text/css">
            .btn-file {
            position: relative;
            overflow: hidden;
            }
            .btn-file input[type=file] {
                position: absolute;
                top: 0;
                right: 0;
                min-width: 100%;
                min-height: 100%;
                font-size: 100px;
                text-align: right;
                filter: alpha(opacity=0);
                opacity: 0;
                outline: none;
                background: white;
                cursor: inherit;
                display: block;
            }
        </style>
    </head>

    <body>
    <?php
    include 'nav.php' ;
    include 'includes.php'; 
    
    if(!$_POST)
    {
        ?>
        <form method="POST" action="WS_video.php?ajouter=true" enctype="multipart/form-data" style="margin-left: 20px;" <?php echo 'onsubmit="return testcheck('.$nbre_enfant.')"'; ?>>
            <div class="input-group" style="margin-bottom: 20px;">
                    <span class="input-group-btn">
                        <span class="btn btn-primary btn-file">
                            Choisissez un fichier &hellip; <input type="file" name="avatar" multiple required>
                        </span>
                    </span>
                    <input type="text" class="form-control" readonly style="width: 500px;">
            </div>
             

            <button id="submit" class="btn btn-success" name="Valider" value="Valider" >Valider</button>
       </form>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>  
        <script src="js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script type="text/javascript">
         $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
          });

          $(document).ready( function() {
              $('.btn-file :file').on('fileselect', function(event, numFiles, label) {

                  var input = $(this).parents('.input-group').find(':text'),
                      log = numFiles > 1 ? numFiles + ' files selected' : label;

                  if( input.length ) {
                      input.val(log);
                  } else {
                      if( log ) alert(log);
                  }

              });
          });


          $( document ).ready(function() {
                    $(".datepicker" ).datepicker();
                }); 



         </script>
            <?php
    }
    //si il y a un post
    else {
        //print_r($_POST);
        //print_r($_FILES);
        echo "<div hidden>";
        $name = $_FILES['avatar']['name'];
        $email_owner = "admin_off";
        $_type = "admin";
        $children =  array();
        
        // UPLOAD SUR S3
        $s3 = new S3Access(S3ClientBuilder::get());
        $url = $s3->createFile($name, $_FILES['avatar']['tmp_name']);//$path);
        
        move_uploaded_file($_FILES['avatar']['tmp_name'], "C:\\xampp\\htdocs\\PhpProject_test\\uploads\\".$_FILES['avatar']['name'] );
        $url = "http://localhost/PhpProject_test/uploads/".$_FILES['avatar']['name'];
        
        // INSERT SUR DYNAMO
        $contentDao = new ContentDAO(LocalDBClientBuilder::get());
        $content = new Content();
        $content->setUrl($url);
        $content->setEmailOwner($email_owner);
        $content->setName($name);
        $content->setType($_type);
        $contentDao->create($content, $children);
        echo "</div>La slide a été ajouter : <a href='https://s3-eu-west-1.amazonaws.com/cherry-shared-content2/".$name."'>".$name."</a>";
    }
        ?>
        
   </body>

    <footer class="footer">
                <div class="container-fluid">
                    <img  height="60px" src="img/logo.jpg"/> 
                </div>
            </footer>
    </html>

    <?php
}



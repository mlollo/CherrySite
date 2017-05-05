<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
$_SESSION = array();
if(isset($_SESSION)) 
    { 
        session_destroy();
    }

?>
<!doctype html>
<html>
<head>
    <?php include 'head.php' ?>
    <title>Deconnection </title>
</head>

<body>
    <?php// include 'nav.php' ?>

    <div class="container">
        Vous vous êtes déconnecté. Redirection vers la <a href="index.php"> page d'accueil </a> ...
        <?php header('Refresh:1; url=index.php');  ?>
    </div>

    <?php include 'footer.php' ?>

</body>
</html>








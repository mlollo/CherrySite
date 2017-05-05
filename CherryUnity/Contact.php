<?php 
 // Désactiver le rapport d'erreurs
    error_reporting(0);
    session_start();
    ?>
<!doctype html>
<html>
    <head>  
        <meta charset="utf8">
        <title>Contact</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <script type='text/javascript' src='script.js'></script>
    </head>

<body>
    <?php include 'nav.php' ?>
    
    <div class="container">
        <h1 style="margin-left: 27px;">Contact</h1>

        <div class="jumbotron">
            <p style="text-align: center; color: white;"><img  height="300px" src="img/contact.png" style="text-align: center;     margin-top: -47px;"/> </p>
            <p style='color: white;'><span class="glyphicon glyphicon-globe" style="margin: 0 15px 0 5px;"></span><a href="http://www.asso-prima.org/" style='color: #134044;'>www.asso-prima.org</a></p>
            <p style='color: white;'><span class="glyphicon glyphicon-envelope" style="margin: 0 15px 0 5px;"></span>projet.cherry@gmail.com</p>
            <p style='color: white;'><span class="glyphicon glyphicon-envelope" style="margin: 0 15px 0 5px;"></span>contact.prima@laposte.net</p>
            <p style='color: white;'><span class="glyphicon glyphicon-link" style="margin: 0 15px 0 5px;"></span>/projetcherry</p>
            <p style='color: white;'><span class="glyphicon glyphicon-link" style="margin: 0 15px 0 5px;"></span>@projetcherry</p>
        </div>    
    </div>
    
    <?php include 'footer.php' ?>

   </body>
</html>
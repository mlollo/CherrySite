<?php 
 // Désactiver le rapport d'erreurs
    error_reporting(0);
    session_start();
    ?>
<!doctype html>
<html>
    <head>  
        <meta charset="utf8">
        <title>About</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <script type='text/javascript' src='script.js'></script>
    </head>

<body>
    <?php include 'nav.php' ?>
    
    <div class="container">
    <h1 style="margin-left: 27px; margin-bottom: 20px;">A propos du Projet Cherry</h1>
    <div class="jumbotron">
        <p style="text-align: center;"><img  height="60px" src="img/logo_cherry.png" style="text-align: center; height: 150px;"/> </p>
    <p>&nbsp;</p>
    <p class="text-muted" style="text-align: justify; color: white;">Le projet Cherry est un projet communautaire visant à développer les usages en milieu hospitalier permettant de rompre l&rsquo;isolement des enfants.</p>
    <p class="text-muted" style="text-align: justify; color: white;">Notre projet utilise le robot <a href="https://www.poppy-project.org/" style='color: #134044;'>Poppy</a> comme compagnon pour les enfants de maternelle/primaire hospitalisés. Cherry est là pour compenser une rupture sociale lors de l’hospitalisation. Il sert d&rsquo;intermédiaire entre l&rsquo;enfant, ses amis, sa famille et son enseignant et peut ainsi discuter avec lui ou encore lui proposer des jeux.</p>
    <p class="text-muted" style="text-align: justify; color: white;">Il agit également sur un plan pédagogique, afin d’inciter l&rsquo;enfant à interagir avec l’espace scolaire, en lui proposant des quizz ou des jeux pédagogiques.</p>
    <p class="text-muted" style="text-align: justify; color: white;">Un dernier axe exploité consiste à assister le personnel hospitalier dans l’éducation thérapeutique. En effet, un message est parfois mieux accepté par l&rsquo;enfant s’il est délivré par le robot plutôt que par un adulte en blouse blanche.</p>
    </div></div>

    
    <?php include 'footer.php' ?>

   </body>
</html>
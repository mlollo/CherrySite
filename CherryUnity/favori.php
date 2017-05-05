<?php 
 // Désactiver le rapport d'erreurs
    error_reporting(0);
    session_start();
    ?>
<!doctype html>
<html>
    
<head>
    <?php include 'head.php' ?>
    <title>Content </title>
</head>

<body>
    <?php include 'nav.php' ?>
   <!-- <h1 style="margin-left: 27px;">Exécution d'un sc&eacute;nario</h1>
    <form class="formB" action="Scenario.php">
        <button type="submit" class="btn btn-primary" style="margin-bottom: 25px; margin-left:40px;">Choisir le scénario</button>
        <div class="dropdown" style="margin-bottom: 33px; margin-left:15px;">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Choisir un scénario&nbsp;
                <span class="caret"></span></button>
            <ul class="dropdown-menu">
                <li value="ListeEnfants"><a href="">Liste des Enfants&nbsp;</a></li>
            </ul>
          </div>
        
    </form>-->
    <div id='contenue' class="row" style='margin: 25px 0px 0px 27px'>
        <div class="col-sm-8" style="margin-bottom: 50px; background-color: #66B9C1;     padding: 10px;">
            <h1 style="margin-left: 27px;     margin-bottom: 30px;"><span class="glyphicon glyphicon-file"></span> Gestion des Favoris pour l'enfant</h1>
        </div>
        <div class="col-sm-2" style="margin-bottom: 50px;"></div>
    </div>
    
    
    <?php    
    $root = './';
    include "includes.php";
    $email = $_SESSION['email'];
    $childDao = new ChildDAO(LocalDBClientBuilder::get());
    $children = $childDao->getChildren($email);
    $list_children = array();
    $get="";
    foreach($children as $child)
    {
        $list_children[] = $child->getFirstname().'&nbsp;'.$child->getLastname();
        $get .= 'child[]='.$child->getFirstname().'___'.$child->getLastname().'&';

    }
    echo '<div class="container" style="border: solid 2px;">';
        echo '<div class="row">';
            echo '<div class="col-sm-offset-1">';
                echo "<select name='id' style='margin-top: 10px'>";
                echo '<option value="ListeEnfants"><a href="#">Liste des Enfants&nbsp;</a></option><option class="divider"></option>';
                foreach ($list_children as $child)
                {
                    if($child != ""){
                        echo '<option value="'.$child.'"><a href="#">'.$child.'&nbsp;</a></option>';
                    } 
                }
                echo "</select>";
                echo '<input type="text" name="dessinA" style="margin-top: 10px; margin-left: 25px;" id="dessinA"></input>';
                echo '<label for="dessinA" style="margin-left: 5px">Dessin animé favori</label>';
            echo '</div>';
        echo '</div>';
    echo '</div>';


?>
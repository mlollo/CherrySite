<?php
// Désactiver le rapport d'erreurs
    error_reporting(0);
    session_start();
    ?>
<html>
<head>
    <meta charset="utf8">
    <title>Insertion de contenu texte</title>
    <?php 
        session_start();
        $root = "./";
        require "includes.php";
    ?>
</head>

<body>
    
    <?php


 print_r($_POST);echo "<br/><br/>";
//echo '<br/>email : '.$_SESSION['email'].' et type : '.$_SESSION['type'].'<br/>';

// INSERT SUR DYNAMO
        $emailOwner = $_SESSION['email'];
        $type = $_SESSION['type'];
        $contentDao = new ContentDAO(LocalDBClientBuilder::get());
        $content = new Content();
        //url reprensente le contenu texte
        if($_POST['contenueTexte'] != "")
            $url =  $_POST['contenueTexte'];
        //si c'est un excel
        else 
        {
            //le reconstruit
            $ligne0 = array();
            $tab = array();
            $ligne0[] = $_POST['contenueTexte0'];
            $ligne0[] = $_POST['contenueTexte1'];
            $ligne0[] = $_POST['contenueTexte2'];
            
            $tab[] = $ligne0;
            
            for($i=3; $i<=$_POST['contenueTexteNBRE']; $i+=4)
            {
                $ligne = array();
                //behave
                //$ligne[] = $_POST['contenueTexte'.$i];
                if($_POST['Behave'][($i-3)]!="")
                    $ligne[] = $_POST['Behave'][($i-3)];
                else
                    $ligne[] = $_POST['contenueTexte'.$i];
                //text
                $ligne[] = $_POST['contenueTexte'.($i+1)];
                //slide
            /*   echo "<br/><br/> LA TEST !!!!<br/><br/>";
                
                echo $_POST['Slide'][($i-3)];
                echo $_POST['contenueTexte'].($i+2);*/
                if($_POST['Slide'][($i-3)] != "")
                {
                    echo $_POST['Slide'][($i-3)];
                    $ligne[] = $_POST['Slide'][($i-3)];
                }
                else
                    $ligne[] = $_POST['contenueTexte'.($i+2)];
                    
                
                $tab[] = $ligne;
            }
            
           /* echo "<br/><br/>LA :<br/><br/>";
            print_r($tab);*/
            
            
            echo "<div hidden>";     
            $url = print_r($tab, true);
            $url_excel = print_r($tab);
            echo "</div>";
        }
        echo $url;
        $content->setUrl($url);
        $content->setEmailOwner($emailOwner);
        $name = $_POST['titreTexte'];
        $content->setName($name);
        $content->setType($type);
        
        /*
        echo $content->getUrl();
        echo $content->getEmailOwner();
        echo $content->getName();
        echo $content->getType();*/
        
       $children =  array();
       foreach ($_POST['child'] as $a_child)
        {
            $children[] = array('email' => $a_child, 'dateStart' => $_POST['date_debut'], 'dateEnd' => $_POST['date_fin']);
        }
        //$children[] = array('email' => $_POST['child'], 'dateStart' => $_POST['date_debut'], 'dateEnd' => $_POST['date_fin']);
        print_r($children);
        //$length = count($_POST['children']);
        
        //si ce contenu existe      
        //getItem
        $contentDAOExist = $contentDao->get($name, $emailOwner);
        //print_r($contentDAOExist);
        $contentExist = new Content();
        $contentExist = $contentDAOExist;
        $urlExist = $contentExist->getUrl();
        $typeExist = $contentExist->getType();
        $dateExistDebut = $_POST['dateDebut0'];
        $dateExistFin = $_POST['dateFin0'];
        echo "<br/><br/>URL EXISTANTE :<br/>".$urlExist."<br/><br/>";        
        /*echo "<br/>URL :<br/>".$url;
        echo "<br/>URL EXCEL :<br/>".$url_excel."<br/>";
        echo "<br/>URL EXIST :<br/>".$urlExist."<br/>";
        for($o=0; $o<strlen($url); $o++)
        {
            if($url[$o]!=$urlExist[$o])
                echo $url[$o]."!=".$urlExist[$o]."<br/>";
            echo $url[$o];
        }*/
                
      if($urlExist != "")
        {
            if($type = $typeExist && $url == $urlExist && $dateExistDebut ==$_POST['date_debut'] && $dateExistFin == $_POST['date_fin'] )
            {
                //indique que ce contenu existe deja
                echo '<p>Ce contenu existe déjà, donc il n\'a pas été re-créé.</p><br/>';
            }
            else if($type = $typeExist)
            {
                echo "Update<br/>";
                

                //alors le met a jour
                $contentDao->UpDate($content, $children);
                echo '<p>Ce contenu a été correctement mis à jour !</p><br/>';
            }
        }
        else
        {
            //sinon le creer        
            //creer un element a la table 'Contents'
            $contentDao->create($content, $children);
            echo '<p>Votre texte a bien été enregistré.</p><br/>';
        }

        
        ?>
    
    <a href=adultShowContents.php>Revenir à la page de Gestion de contenus</a>
</body>
</html>


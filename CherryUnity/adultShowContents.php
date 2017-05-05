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
    <div id='contenue' style='margin: 25px 0px 0px 27px'>
   <div class="col-sm-6" style="margin-bottom: 60px;">
       <div style='background-color: #66B9C1;     padding: 10px;'>
    <h1 style="margin-left: 27px;     margin-bottom: 30px;"><span class="glyphicon glyphicon-file"></span> Gestion des Documents pour l'enfant</h1>
    
    
    <?php    
    $root = './';
    include "includes.php";
    
    $contentDao = new ContentDAO(LocalDBClientBuilder::get());
    
    $name_fileToDelete = $_GET['name'];
    $owner_fileToDelete = $_GET['owner'];
    // DELETE File if needed
    if (!empty($name_fileToDelete) &&
        !empty($owner_fileToDelete)) {
        $s3 = new S3Access(S3ClientBuilder::get());
        $s3->deleteFile($name_fileToDelete);
        $contentDao->delete($name_fileToDelete, $owner_fileToDelete);
    }

    /*
    echo "<a href=\"./listOfChildren.php\">Calendriers des enfants</a></br></br>";
    echo "<a href=\"./drop.php\">Ajouter un fichier</a></br></br>";
    echo "<a href=\"./contenueTexte.php\">Créer un contenue texte</a></br></br>";
    */
    echo '<div style="margin-left:15px;">';
    echo '<form class="formB" action="listOfChildren.php"><button type="submit" class="btn btn-default" name="Valider" onclick >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;&nbsp;&nbsp;&nbsp; Calendriers des enfants&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button></form>';
    echo '<form class="formB" action="drop.php"><button type="submit" class="btn btn-default" name="Valider" onclick >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-share"></span>&nbsp;&nbsp;&nbsp;&nbsp; Ajouter un fichier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button></form>';
    echo '<form class="formB" action="contenueTexte.php"><button type="submit" class="btn btn-default" name="Valider" onclick >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;&nbsp;&nbsp; Créer un contenu texte&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button></form>';
    echo '<form class="formB" action="favori.php"><button type="submit" class="btn btn-default" name="Valider" onclick >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;&nbsp;&nbsp; Ajouter des favoris&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button></form>';
    echo '<form class="formB" action="gestionEnfants.php"><button type="submit" class="btn btn-default" name="Valider" onclick >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;&nbsp;&nbsp; Gestion des enfants&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button></form>';
   // echo '<form class="formB" action="Excel.php"><button type="submit" class="btn btn-default" name="Valider" onclick ><span class="glyphicon glyphicon-share"></span> Ajouter un Excel de description d\'un scénario</button></form>';
    echo '</div></div>';
    
    $userDao = new UserDAO(LocalDBClientBuilder::get());
    $email = $_SESSION['email'];
    $user = $userDao->get($email);
    
    $contents = $contentDao->getContentsOfUser($email);

    $childDao = new ChildDAO(LocalDBClientBuilder::get());
    $children = $childDao->getChildren($email);
    $list_children = array();
    $get="";
    foreach($children as $child)
    {
        $list_children[] = $child->getFirstname().'&nbsp;'.$child->getLastname();
        $get .= 'child[]='.$child->getFirstname().'___'.$child->getLastname().'&';
    }
   
    echo "<div style='background-color: #CDF5F9;     padding: 10px;     margin-bottom: 25px;'>";
    
    $length = count($contents);
    if($length<=1 && $length>0)
        echo '<div style="margin-bottom: 10px; margin-top: 35px;"><h3>Voici le document que vous mettez à disposition :</h3></div>';
    else if($length>0)
        echo '<div style="margin-bottom: 10px; margin-top: 35px;"><h3>Voici les documents que vous mettez à disposition :</h3></div>';
    
    
    /*echo '<div class="dropdown" style="margin-bottom: 33px; margin-left:15px;">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" >Liste des Enfants&nbsp;
                <span class="caret"></span></button>
            <ul class="dropdown-menu">
                <li value="ListeEnfants"><a href="#">Liste des Enfants&nbsp;</a></li>
                <li class="divider"></li>';
    foreach ($list_children as $child)
    {
        echo '<li value="'.$child.'"><a href="#">'.$child.'&nbsp;</a></li>';
        //&nbsp;
    }
    echo '<li class="divider"></li>'
        . '<li value="'.$children.'"><a href="gestionEnfants.php?'.$get.'">Gérer les Enfants&nbsp;</a></li>';
    echo '</ul>
          </div>';*/

    for ($i = 0; $i < $length; $i++) {
        $content = $contents[$i];
        $name = $content->getName();
        $owner = $content->getEmailOwner();
        $url = $content->getUrl();
        $url_post = $url;
        if ($content != null) 
            {
                            //si ce n'est pas un excel
                if(($url[0]!='A'&&$url[1]!='r'&&$url[2]!='r'&&$url[3]!='a'&&$url[4]!='y')&& ($url[1]!='A'&&$url[2]!='r'&&$url[3]!='r'&&$url[4]!='a'&&$url[5]!='y') && ($url[2]!='A'&&$url[3]!='r'&&$url[4]!='r'&&$url[5]!='a'&&$url[6]!='y'))
                 {   
                    echo '<ul class="list_contents">';
                    //si l'url ressemble a 52.49.63.136/...
                    if($url[0]=='5')
                    {
                        echo '<li>'
                            . $name
                            .' : '
                            . '&nbsp;&nbsp;&nbsp;<a href=downloadFile.php?name='.$name.'>Download</a>' 
                            . '&nbsp;&nbsp;&nbsp;<a href=adultShowContents.php?name='.$name.'&owner='.$owner.'>Supprimer</a></br>'
                            . '</li>';
                    }
                    else
                    {
                        $valeurs = array();
                        $valeurs[] = $name;
                        $valeurs[] = $_SESSION['email'];
                        $valeurs[] = $url;
                        $valeurs[] = $_SESSION['type'];
                        $childDao = new ChildDAO(LocalDBClientBuilder::get());
                        $children = $childDao->getChildren($email);
                        $index=0;
                        //print_r($children);
                        $compte=0;
                        foreach($children as $child)
                        {
                            $contentsChild = $child->getContentByType($_SESSION['type']);
                            //print_r($contentsChild);
                            foreach ($contentsChild as $leContent)
                            {
                                $nameDuContenue = $leContent['M']['name']['S'];
                                if($nameDuContenue == $name)
                                {
                                    $index = $compte;
                                    $mail_enfants[] = $child->getEmail();
                                }
                            }    
                            $compte++;
                        }
                        //print_r($mail_enfants);
                        $child_mail = $children[$index]->getEmail();
                        $valeurs[] = $child_mail;
                        $temp = $children[$index]->getContentByType($_SESSION['type']);
                        $index2 = 0;
                        $compte = 0;
                        foreach ($temp as $cont)
                        {
                            if($cont['M']['name']['S'] == $name)
                                $index2 = $compte;
                            $compte++;
                        }
                        $dateStart = $temp[$index2]['M']['dateStart']['S'];
                        $valeurs[] = $dateStart;
                        $dateEnd = $temp[$index2]['M']['dateEnd']['S'];
                        $valeurs[] = $dateEnd;

                        //print_r($valeurs);

                        //$valeur = serialize($valeurs);
                        echo '<li>'
                            . $name
                            .' : '
                            . '&nbsp;&nbsp;&nbsp;<a href=adultShowContents.php?name='.$name.'&owner='.$owner.'>Supprimer</a></br>'
                            . '<ul><div style="font-style: italic;">Période de diffusion : &nbsp;&nbsp;du '
                            . $dateStart
                            . '&nbsp;&nbsp;&nbsp;au&nbsp;&nbsp;&nbsp;'
                            .$dateEnd
                            .'<br/>Enfants ayant accès :<br/>';
                        $nbe = 0;
                        foreach($children as $child)
                        {
                            $contentsChild = $child->getContentByType($_SESSION['type']);
                            //print_r($contentsChild);



                            foreach ($contentsChild as $leContent)
                            {
                                $nameDuContenue = $leContent['M']['name']['S'];
                                if($nameDuContenue == $name)
                                {
                                    echo '<ul><li>'.$child->getFirstname().'&nbsp;'.$child->getLastname().'</li></ul>';
                                    $nbe++;
                                }
                            } 
                        }
                        if($nbe== 0)
                                echo "<ul>Ce contenu n'est lié à aucun enfant !</ul>";

                        if($url[0]=='h' && $url[1]=='t' && $url[2]=='t' && $url[3]=='p' && $url[4]==':')
                            $url = "<a href='".$url."'>".$url."</a>";
                        

                        //si url est trop long, le coupe...
                        $tempo = "";
                        if(strlen($url) > 260)
                        {
                            $tempo = "<br/><button type='button' class='btn btn-info' data-toggle='collapse' data-target='#demo' style='width: 180px;'>"
                                    . "<span class='glyphicon glyphicon-search' style='margin-right: 6px;'></span>";
                            for($u=0; $u<strlen($url); $u++)
                            {
                                if($u<=25)
                                    $tempo .= $url[$u];
                            }
                            $tempo .= " ...</button><div id='demo' class='collapse'>".$url."</div>";//
                            $url = $tempo;
                        }

                        echo'</div></ul><ul style="text-align:justify; margin-right:50px;"><p>'
                            .$url
                            .'<form class="formB" action="contenueTexte.php" method="POST">'
                            .'<input name="valeur[]" value="'.$name.'" hidden>'
                            .'<input name="valeur[]" value="'.$_SESSION['email'].'" hidden>'
                            .'<input name="valeur[]" value="'.$url_post.'" hidden>'
                            .'<input name="valeur[]" value="'.$_SESSION['type'].'" hidden>';
                            foreach ($mail_enfants as $un_mail)
                            {
                                echo '<input name="mail[]" value="'.$un_mail.'" hidden>';
                            }
                        echo '<input name="valeur[]" value="'.$dateStart.'" hidden>'
                            .'<input name="valeur[]" value="'.$dateEnd.'" hidden>'
                            .'<button type="submit" class="btn btn-default" name="Modifier" onclick style="width: 181px;"><span class="glyphicon glyphicon-edit" style="margin-right: 6px; "></span>Modifier ce contenu</button></form>'
                            .$scenario
                            .'<br/>'
                            .'</p></ul>'
                            .'</li></ul>';
                    }
                }
            }
    }
    if ($content != null) 
        echo '</ul>';
        
    //POUR 1 ENFANT
     $childDao = new ChildDAO(LocalDBClientBuilder::get());
     $children = $childDao->getChildren($email);
     $index=0;
     $compteur = 0;
     //echo "UN ENFANT";
      
     foreach ($children as $child)
     {
         $nbr_c_affichee = 0;
         $nomEnfant = $child->getFirstname().'&nbsp;'.$child->getLastname();
         $contentsEnfant = $child->getContentByType($_SESSION['type']);
         
         echo '<div id ="'.$nomEnfant.'&nbsp;" value="'.$nomEnfant.'" hidden>';
         //echo '<div id ="'.$nomEnfant.'&nbsp;" value="'.$nomEnfant.'" >';
         $child_mail = $child->getEmail();
         //echo $child_mail."<br/>";
         
         foreach ($contentsEnfant as $contentE)
            {
             //si le contenu enfant concerne la personne connectee
             if($contentE['M']['owner']['S'] == $_SESSION['email'])
             {
                 $url = "";
                 //trouve le contenu medecin ayant le meme nom pour recuperer l'url
                 foreach ($contents as $c)
                 {
                     if($c->getName() == $contentE['M']['name']['S'] )
                         $url = $c->getUrl();
                 }
                // echo $url;
                
                 if($url[0]!= 'A'  &&  $url[1]!= 'r'  &&  $url[2]!= 'r'  &&  $url[3]!= 'a'  &&  $url[4]!= 'y'  /*&&  $url[5]== ':'  &&  $url[6]== '/'  &&  $url[7]== '/'*/)
                 {
                     $nbr_c_affichee++;
                 
                    echo "<ul style='text-align:justify; margin-right:50px;'><li>"
                    .$contentE['M']['name']['S']
                    ." : "
                    ."&nbsp;&nbsp;&nbsp;<a href='adultShowContents.php?name=".$contentE['M']['name']['S']."&owner=".$contentE['M']['owner']['S']."'>Supprimer</a></br/>"
                    ."<ul><div style='font-style: italic;'>Période de diffusion : &nbsp;&nbsp;du "
                    .$contentE['M']['dateStart']['S']
                    ."&nbsp;&nbsp;&nbsp;au&nbsp;&nbsp;&nbsp;"
                    .$contentE['M']['dateEnd']['S']
                    ."</div>";

                    $scenario="";;
                    if(($url[0]=='A'&&$url[1]=='r'&&$url[2]=='r'&&$url[3]=='a'&&$url[4]=='y')|| ($url[1]=='A'&&$url[2]=='r'&&$url[3]=='r'&&$url[4]=='a'&&$url[5]=='y') || ($url[2]=='A'&&$url[3]=='r'&&$url[4]=='r'&&$url[5]=='a'&&$url[6]=='y'))
                    {                       
                       //decoupe par info
                       $translate = explode("[",$url );
                       $translArray = array();

                       //enleve l'index
                       foreach ($translate as $str)
                       {

                           if($str[1]==']')
                           {
                               $str = substr ($str, 5);          
                               $translArray[] = $str;
                           }
                           else
                           {
                               $str = substr ($str, 6);
                               $translArray[] = $str;
                           }

                       }

                       //enleve espace genant et "))"
                       $translArray[2] = substr($translArray[2], 0, -12);
                       $translArray[3] = substr($translArray[3], 0, -11);
                       $translArray[4] = substr($translArray[4], 0, -7);                             
                       $translArray[count($translArray)-1] = substr($translArray[count($translArray)-1], 0, -2);

                       $etape = 1;
                       $url = "";
                       for($ligne = 2; $ligne < count($translArray) -4; $line+=4)
                       {
                           $url.= "    --- &Eacute;tape n° ".$etape." :<br/>";
                           $url.= $translArray[2]." : ".$translArray[$ligne+4]."<br/>";
                           $url.= $translArray[3]. ": ".$translArray[$ligne+1+4]."<br/>";
                           //enleve la ')' de fin
                           $pos = strpos($translArray[$ligne+2+4], ')');
                           if($pos!==FALSE)
                           {
                               $translArray[$ligne+2+4] = str_replace(')', '', $translArray[$ligne+2+4]);
                           }

                           $url.= $translArray[4]. ": ".$translArray[$ligne+2+4]."<br/>";
                           $ligne += 4;
                           $etape++;
                       }
                       $scenario = '<form class="formB" action="Scenario.php" method="POST">'
                           . '<button type="submit" class="btn btn-success" name="Valider" onclick style="width: 180px;">'
                           . '<span class="glyphicon glyphicon-play" style="margin-right: 6px;"></span>'
                           . 'Jouer ce scénario&nbsp;&nbsp;</button>'
                           . '<input name="url_post" value="'.$url_post.'" hidden>'
                           . '<input name="url" value="'.$url.'" hidden>'
                           . '</form>';
                   }
                   else if(($url[0]== 'h'  &&  $url[1]== 't'  &&  $url[2]== 't'  &&  $url[3]== 'p'  &&  $url[4]== 's'  &&  $url[5]== ':'  &&  $url[6]== '/'  &&  $url[7]== '/'))
                   {
                       $url = "<a href='".$url."'>".$url."</a>";
                   }

                   //si url est trop long, le coupe...
                   $tempo = "";
                   if(strlen($url) > 260)
                   {
                       $tempo = "<br/><button type='button' class='btn btn-info' data-toggle='collapse' data-target='#demo' style='width: 180px;'>"
                           . "<span class='glyphicon glyphicon-search' style='margin-right: 6px;'></span>";
                       for($u=0; $u<strlen($url); $u++)
                       {
                           if($u<=25)
                               $tempo .= $url[$u];
                       }
                       $tempo .= " ...</button><div id='demo' class='collapse'>".$url."</div>";//
                       $url = $tempo;
                   }


                    echo $url
                    ."<p><form class='formB' action='contenueTexte.php' method='POST'>"
                    ."<input name='valeur[]' value='".$contentE['M']['name']['S']."' hidden>"
                    ."<input name='valeur[]' value='".$_SESSION['email']."' hidden>"
                    ."<input name='valeur[]' value='".$url_post."' hidden>"
                    ."<input name='valeur[]' value='".$_SESSION['type']."' hidden>"
                    ."<input name='valeur[]' value='".$child_mail."' hidden>"
                    ."<input name='valeur[]' value='".$contentE['M']['dateStart']['S']."' hidden>"
                    ."<input name='valeur[]' value='".$contentE['M']['dateEnd']['S']."' hidden>"
                    ."<button type='submit' class='btn btn-default' name='Modifier' onclick '>Modifier ce contenue</button></form><br/>"
                    ."</p>"
                    ."</ul></li></ul>";
                 }
                 
             }
           }
           //echo $nbr_c_affichee;
           if($nbr_c_affichee==0)
               echo "<p>Aucun document n'est disponible pour cet enfant.</p>";
         echo '</div>';
         
         //echo "<div id ='".$nomEnfant."_' hidden>TEST + id = ".$nomEnfant."</div> ";
     }
     echo '</div>';
          
     ?>
    </div>
        
        <div class="col-sm-6" style="margin-bottom: 60px; border-left: 1px solid gainsboro;">
            <div style='background-color: #6ED397;     padding: 10px;'>
            <h1 style="margin-left: 27px;     margin-bottom: 30px;"><span class="glyphicon glyphicon-blackboard"></span> Gestion des Scénarios de Présentation</h1>
            <?php
                $contentDao = new ContentDAO(LocalDBClientBuilder::get());
    
                $name_fileToDelete = $_GET['name'];
                $owner_fileToDelete = $_GET['owner'];
                // DELETE File if needed
                if (!empty($name_fileToDelete) &&
                    !empty($owner_fileToDelete)) {
                    $s3 = new S3Access(S3ClientBuilder::get());
                    $s3->deleteFile($name_fileToDelete);
                    $contentDao->delete($name_fileToDelete, $owner_fileToDelete);
                }
                /*
                echo "<a href=\"./listOfChildren.php\">Calendriers des enfants</a></br></br>";
                echo "<a href=\"./drop.php\">Ajouter un fichier</a></br></br>";
                echo "<a href=\"./contenueTexte.php\">Créer un contenue texte</a></br></br>";
                */
                echo '<div style="margin-left:15px;">';
                echo '<form class="formB" action="listOfChildren.php"><button type="submit" class="btn btn-default" name="Valider" onclick >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;&nbsp;&nbsp;&nbsp; Calendriers des enfants&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button></form>';
                echo '<form class="formB" action="Excel.php"><button type="submit" class="btn btn-default" name="Valider" onclick ><span class="glyphicon glyphicon-share"></span> Ajouter un Excel de description d\'un scénario</button></form>';
                echo '<form class="formB" action="Excel.php"><button type="submit" class="btn btn-default" name="Valider" onclick >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;&nbsp;&nbsp; Créer un scénario&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button></form>';
                echo '</div></div>';

                $userDao = new UserDAO(LocalDBClientBuilder::get());
                $email = $_SESSION['email'];

                $user = $userDao->get($email);

                //$contents = $contentDao->getContentsOfUser($email);

                echo "<div style='background-color: #CEFAE0;     padding: 10px;     margin-bottom: 25px;'>";

               /* $length = count($contents);
                if($length<=1 && $length>0)
                    echo '<div style="margin-bottom: 10px; margin-top: 35px;"><h3>Voici le scénario que vous possédez :</h3></div>';
                else if($length>0)
                    echo '<div style="margin-bottom: 10px; margin-top: 35px;"><h3>Voici les scénarios que vous possédez :</h3></div>'; */

                $childDao = new ChildDAO(LocalDBClientBuilder::get());
                $children = $childDao->getChildren($email);
                $list_children = array();
                $get="";
                foreach($children as $child)
                {
                    $list_children[] = $child->getFirstname().'&nbsp;'.$child->getLastname();
                    $get .= 'child[]='.$child->getFirstname().'___'.$child->getLastname().'&';
                }
                echo '<div class="dropdown" style="margin-bottom: 33px; margin-left:15px;">
                        <button class="btn btn-primary dropdown-toggle2" type="button" data-toggle="dropdown" >Liste des Enfants&nbsp;
                            <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li value="ListeEnfants"><a href="#">Liste des Enfants&nbsp;</a></li>
                            <li class="divider"></li>';
                foreach ($list_children as $child)
                {
                    echo '<li value="'.$child.'"><a href="#">'.$child.'&nbsp;</a></li>';
                    //&nbsp;
                }
                echo '<li class="divider"></li>'
                    . '<li value="'.$children.'"><a href="gestionEnfants.php?'.$get.'">Gérer les Enfants&nbsp;</a></li>';
                echo '</ul>
                      </div>';
                
                
                for ($i = 0; $i < $length; $i++) {
        $content = $contents[$i];
        $name = $content->getName();
        $owner = $content->getEmailOwner();
        $url = $content->getUrl();
        $url_post = $url;
        if ($content != null) 
            {
                //si c'est un excel
                if(($url[0]=='A'&&$url[1]=='r'&&$url[2]=='r'&&$url[3]=='a'&&$url[4]=='y')|| ($url[1]=='A'&&$url[2]=='r'&&$url[3]=='r'&&$url[4]=='a'&&$url[5]=='y') || ($url[2]=='A'&&$url[3]=='r'&&$url[4]=='r'&&$url[5]=='a'&&$url[6]=='y'))
                 {  
                    echo '<ul class="list_contents">';
                    //si l'url ressemble a 52.49.63.136/...
                    if($url[0]=='5')
                    {
                        echo '<li>'
                            . $name
                            .' : '
                            . '&nbsp;&nbsp;&nbsp;<a href=downloadFile.php?name='.$name.'>Download</a>' 
                            . '&nbsp;&nbsp;&nbsp;<a href=adultShowContents.php?name='.$name.'&owner='.$owner.'>Supprimer</a></br>'
                            . '</li>';
                    }
                    else
                    {
                        $valeurs = array();
                        $valeurs[] = $name;
                        $valeurs[] = $_SESSION['email'];
                        $valeurs[] = $url;
                        $valeurs[] = $_SESSION['type'];
                        $childDao = new ChildDAO(LocalDBClientBuilder::get());
                        $children = $childDao->getChildren($email);
                        $index=0;
                        //print_r($children);
                        $compte=0;
                        foreach($children as $child)
                        {
                            $contentsChild = $child->getContentByType($_SESSION['type']);
                            //print_r($contentsChild);
                            foreach ($contentsChild as $leContent)
                            {
                                $nameDuContenue = $leContent['M']['name']['S'];
                                if($nameDuContenue == $name)
                                {
                                    $index = $compte;
                                    $mail_enfants[] = $child->getEmail();
                                }
                            }    
                            $compte++;
                        }
                        //print_r($mail_enfants);
                        $child_mail = $children[$index]->getEmail();
                        $valeurs[] = $child_mail;
                        $temp = $children[$index]->getContentByType($_SESSION['type']);
                        $index2 = 0;
                        $compte = 0;
                        foreach ($temp as $cont)
                        {
                            if($cont['M']['name']['S'] == $name)
                                $index2 = $compte;
                            $compte++;
                        }
                        $dateStart = $temp[$index2]['M']['dateStart']['S'];
                        $valeurs[] = $dateStart;
                        $dateEnd = $temp[$index2]['M']['dateEnd']['S'];
                        $valeurs[] = $dateEnd;

                        //print_r($valeurs);

                        //$valeur = serialize($valeurs);
                        echo '<li>'
                            . $name
                            .' : '
                            . '&nbsp;&nbsp;&nbsp;<a href=adultShowContents.php?name='.$name.'&owner='.$owner.'>Supprimer</a></br>'
                            . '<ul><div style="font-style: italic;">Période de diffusion : &nbsp;&nbsp;du '
                            . $dateStart
                            . '&nbsp;&nbsp;&nbsp;au&nbsp;&nbsp;&nbsp;'
                            .$dateEnd
                            .'<br/>Enfants ayant accès :<br/>';
                        $nbe = 0;
                        foreach($children as $child)
                        {
                            $contentsChild = $child->getContentByType($_SESSION['type']);
                            //print_r($contentsChild);



                            foreach ($contentsChild as $leContent)
                            {
                                $nameDuContenue = $leContent['M']['name']['S'];
                                if($nameDuContenue == $name)
                                {
                                    echo '<ul><li>'.$child->getFirstname().'&nbsp;'.$child->getLastname().'</li></ul>';
                                    $nbe++;
                                }
                            } 
                        }
                        if($nbe== 0)
                                echo "<ul>Ce contenu n'est lié à aucun enfant !</ul>";

                        //si l'url est un excel
                        $scenario="";;
                        if(($url[0]=='A'&&$url[1]=='r'&&$url[2]=='r'&&$url[3]=='a'&&$url[4]=='y')|| ($url[1]=='A'&&$url[2]=='r'&&$url[3]=='r'&&$url[4]=='a'&&$url[5]=='y') || ($url[2]=='A'&&$url[3]=='r'&&$url[4]=='r'&&$url[5]=='a'&&$url[6]=='y'))
                     {                        
                            //decoupe par info
                            $translate = explode("[",$url );
                            $translArray = array();

                            //enleve l'index
                            foreach ($translate as $str)
                            {

                                if($str[1]==']')
                                {
                                    $str = substr ($str, 5);          
                                    $translArray[] = $str;
                                }
                                else
                                {
                                    $str = substr ($str, 6);
                                    $translArray[] = $str;
                                }

                            }

                            //enleve espace genant et "))"
                            $translArray[2] = substr($translArray[2], 0, -12);
                            $translArray[3] = substr($translArray[3], 0, -11);
                            $translArray[4] = substr($translArray[4], 0, -7);                             
                            $translArray[count($translArray)-1] = substr($translArray[count($translArray)-1], 0, -2);

                            $etape = 1;
                            $url = "";
                            $timeline = "";
                            $diapo_pecedent = "";
                            for($ligne = 2; $ligne < count($translArray) -4; $line+=4)
                            {
                                $url.= "    --- &Eacute;tape n° ".$etape." :<br/>";
                                $translArray[$ligne+4] = str_replace(' ', '', $translArray[$ligne+4]);
                                $translArray[$ligne+1+4] = trim($translArray[$ligne+1+4]);
                                $url.= $translArray[2]." : ".$translArray[$ligne+4]."<br/>";
                                $url.= $translArray[3]. ": ".$translArray[$ligne+1+4]."<br/>";
                                //enleve la ')' de fin
                                $pos = strpos($translArray[$ligne+2+4], ')');
                                if($pos!==FALSE)
                                {
                                    $translArray[$ligne+2+4] = str_replace(')', '', $translArray[$ligne+2+4]);
                                    $translArray[$ligne+2+4] = str_replace(' ', '', $translArray[$ligne+2+4]);
                                }
                                //TODO
                                $url.= $translArray[4]. ": ".$translArray[$ligne+2+4]."<br/>";
                                $diapo = " {{http://localhost/PhpProject_test/uploads/".$translArray[$ligne+2+4]."}}";
                                //si les diapos sont identiques
                                if(strcmp($diapo, $diapo_pecedent) == 0)
                                    $timeline.=" [[".$translArray[$ligne+4]."]]".$translArray[$ligne+1+4];
                                else
                                {

                                    /*if($diapo_pecedent!="")
                                        $timeline.="::";*/
                                    $timeline.=$diapo."[[".$translArray[$ligne+4]."]]".$translArray[$ligne+1+4];
                                }


                                $ligne += 4;
                                $etape++;
                                $diapo_pecedent = $diapo;
                            }
                            $scenario = '<form class="formB" action="TimeLine.php" method="POST">'
                                    . '<button type="submit" class="btn btn-default" onclick style="width: 180px;">'
                                    . '<span class="glyphicon glyphicon-pencil" style="margin-right: 6px;"></span>'
                                    . 'Editer le scénario&nbsp;&nbsp;</button>'
                                    . '<input name="name" value="'.$name.'" hidden>'
                                    . '<input name="timeline" value="'.$timeline.'" hidden>'
                                    . '</form>'
                                    .'<form class="formB" action="Scenario.php" method="POST">'
                                    . '<button type="submit" class="btn btn-success" name="Valider" onclick style="width: 180px;">'
                                    . '<span class="glyphicon glyphicon-play" style="margin-right: 6px;"></span>'
                                    . 'Jouer ce scénario&nbsp;&nbsp;</button>'
                                    . '<input name="url_post" value="'.$url_post.'" hidden>'
                                    . '<input name="url" value="'.$url.'" hidden>'
                                    . '</form>';


                        }
                        else if(($url[0]== 'h'  &&  $url[1]== 't'  &&  $url[2]== 't'  &&  $url[3]== 'p'  &&  $url[4]== ':'  &&  $url[5]== '/'  ))
                        {
                            $url = "<a href='".$url."'>".$url."</a>";
                        }

                        //si url est trop long, le coupe...
                        $tempo = "";
                        if(strlen($url) > 260)
                        {
                            $tempo = "<br/><button type='button' class='btn btn-info' data-toggle='collapse' data-target='#demo2' style='width: 180px;'>"
                                    . "<span class='glyphicon glyphicon-search' style='margin-right: 6px;'></span>";
                            for($u=0; $u<strlen($url); $u++)
                            {
                                if($u<=25)
                                    $tempo .= $url[$u];
                            }
                            $tempo .= " ...</button><div id='demo2' class='collapse'>".$url."</div>";//
                            $url = $tempo;
                        }

                        echo'</div></ul><ul style="text-align:justify; margin-right:50px;"><p>'
                            .$url
                            .'<form class="formB" action="contenueTexte.php" method="POST">'
                            .'<input name="valeur[]" value="'.$name.'" hidden>'
                            .'<input name="valeur[]" value="'.$_SESSION['email'].'" hidden>'
                            .'<input name="valeur[]" value="'.$url_post.'" hidden>'
                            .'<input name="valeur[]" value="'.$_SESSION['type'].'" hidden>';
                            foreach ($mail_enfants as $un_mail)
                            {
                                echo '<input name="mail[]" value="'.$un_mail.'" hidden>';
                            }
                        echo '<input name="valeur[]" value="'.$dateStart.'" hidden>'
                            .'<input name="valeur[]" value="'.$dateEnd.'" hidden>'
                            .'<button type="submit" class="btn btn-default" name="Modifier" onclick style="width: 181px;"><span class="glyphicon glyphicon-edit" style="margin-right: 6px; "></span>Modifier ce contenu</button></form>'
                            .$scenario
                            .'<br/>'
                            .'</p></ul>'
                            .'</li></ul>';
                    }
                }
            }
    }
    if ($content != null) 
        echo '</ul>';
    
    //POUR 1 ENFANT
     $childDao = new ChildDAO(LocalDBClientBuilder::get());
     $children = $childDao->getChildren($email);
     $index=0;
     $compteur = 0;
     foreach ($children as $child)
     {
         $nbr_c_affichee = 0;
         $nomEnfant = $child->getFirstname().'&nbsp;'.$child->getLastname();
         echo '<div id ="'.$nomEnfant.'&nbsp;" value="'.$nomEnfant.'" hidden>';
         $child_mail = $child->getEmail();
         $contentsEnfant = $child->getContentByType($_SESSION['type']);
         foreach ($contentsEnfant as $contentE)
            {
             //si le contenu enfant concerne la personne connectee
             if($contentE['M']['owner']['S'] == $_SESSION['email'])
             {
                 $url = "";
                 //trouve le contenu medecin ayant le meme nom pour recuperer l'url
                 foreach ($contents as $c)
                 {
                     if($c->getName() == $contentE['M']['name']['S'] )
                         $url = $c->getUrl();
                 }
                 
                 if(($url[0]=='A'&&$url[1]=='r'&&$url[2]=='r'&&$url[3]=='a'&&$url[4]=='y')|| ($url[1]=='A'&&$url[2]=='r'&&$url[3]=='r'&&$url[4]=='a'&&$url[5]=='y') || ($url[2]=='A'&&$url[3]=='r'&&$url[4]=='r'&&$url[5]=='a'&&$url[6]=='y'))
                 {
                     $nbr_c_affichee++;
                    echo "<ul style='text-align:justify; margin-right:50px;'><li>"
                    .$contentE['M']['name']['S']
                    ." : "
                    ."&nbsp;&nbsp;&nbsp;<a href='adultShowContents.php?name=".$contentE['M']['name']['S']."&owner=".$contentE['M']['owner']['S']."'>Supprimer</a></br/>"
                    ."<ul><div style='font-style: italic;'>Période de diffusion : &nbsp;&nbsp;du "
                    .$contentE['M']['dateStart']['S']
                    ."&nbsp;&nbsp;&nbsp;au&nbsp;&nbsp;&nbsp;"
                    .$contentE['M']['dateEnd']['S']
                    ."</div>";

                    $scenario="";;
                    if(($url[0]=='A'&&$url[1]=='r'&&$url[2]=='r'&&$url[3]=='a'&&$url[4]=='y')|| ($url[1]=='A'&&$url[2]=='r'&&$url[3]=='r'&&$url[4]=='a'&&$url[5]=='y') || ($url[2]=='A'&&$url[3]=='r'&&$url[4]=='r'&&$url[5]=='a'&&$url[6]=='y'))
                    {                       
                       //decoupe par info
                       $translate = explode("[",$url );
                       $translArray = array();

                       //enleve l'index
                       foreach ($translate as $str)
                       {

                           if($str[1]==']')
                           {
                               $str = substr ($str, 5);          
                               $translArray[] = $str;
                           }
                           else
                           {
                               $str = substr ($str, 6);
                               $translArray[] = $str;
                           }

                       }

                       //enleve espace genant et "))"
                       $translArray[2] = substr($translArray[2], 0, -12);
                       $translArray[3] = substr($translArray[3], 0, -11);
                       $translArray[4] = substr($translArray[4], 0, -7);                             
                       $translArray[count($translArray)-1] = substr($translArray[count($translArray)-1], 0, -2);

                       $etape = 1;
                       $url = "";
                       for($ligne = 2; $ligne < count($translArray) -4; $line+=4)
                       {
                           $url.= "    --- &Eacute;tape n° ".$etape." :<br/>";
                           $url.= $translArray[2]." : ".$translArray[$ligne+4]."<br/>";
                           $url.= $translArray[3]. ": ".$translArray[$ligne+1+4]."<br/>";
                           //enleve la ')' de fin
                           $pos = strpos($translArray[$ligne+2+4], ')');
                           /*if($pos!==FALSE)
                           {
                               $translArray[$ligne+2+4] = str_replace(')', '', $translArray[$ligne+2+4]);
                           } */
                           if(isset($translArray[$ligne+2+4]))
                           {
                               $translArray[$ligne+2+4] = str_replace(')', '', $translArray[$ligne+2+4]);
                           }

                           $url.= $translArray[4]. ": ".$translArray[$ligne+2+4]."<br/>";
                           $ligne += 4;
                           $etape++;
                       }
                       $scenario = '<form class="formB" action="Scenario.php" method="POST">'
                           . '<button type="submit" class="btn btn-success" name="Valider" onclick style="width: 180px;">'
                           . '<span class="glyphicon glyphicon-play" style="margin-right: 6px;"></span>'
                           . 'Jouer ce scénario&nbsp;&nbsp;</button>'
                           . '<input name="url_post" value="'.$url_post.'" hidden>'
                           . '<input name="url" value="'.$url.'" hidden>'
                           . '</form>';
                   }
                   else if(($url[0]== 'h'  &&  $url[1]== 't'  &&  $url[2]== 't'  &&  $url[3]== 'p'  &&  $url[4]== 's'  &&  $url[5]== ':'  &&  $url[6]== '/'  &&  $url[7]== '/'))
                   {
                       $url = "<a href='".$url."'>".$url."</a>";
                   }

                   //si url est trop long, le coupe...
                   $tempo = "";
                   if(strlen($url) > 260)
                   {
                       $tempo = "<br/><button type='button' class='btn btn-info' data-toggle='collapse' data-target='#demo' style='width: 180px;'>"
                           . "<span class='glyphicon glyphicon-search' style='margin-right: 6px;'></span>";
                       for($u=0; $u<strlen($url); $u++)
                       {
                           if($u<=25)
                               $tempo .= $url[$u];
                       }
                       $tempo .= " ...</button><div id='demo' class='collapse'>".$url."</div>";//
                       $url = $tempo;
                   }


                    echo $url
                    ."<p><form class='formB' action='contenueTexte.php' method='POST'>"
                    ."<input name='valeur[]' value='".$contentE['M']['name']['S']."' hidden>"
                    ."<input name='valeur[]' value='".$_SESSION['email']."' hidden>"
                    ."<input name='valeur[]' value='".$url_post."' hidden>"
                    ."<input name='valeur[]' value='".$_SESSION['type']."' hidden>"
                    ."<input name='valeur[]' value='".$child_mail."' hidden>"
                    ."<input name='valeur[]' value='".$contentE['M']['dateStart']['S']."' hidden>"
                    ."<input name='valeur[]' value='".$contentE['M']['dateEnd']['S']."' hidden>"
                    ."<button type='submit' class='btn btn-default' name='Modifier' onclick '>Modifier ce contenue</button></form><br/>"
                    ."</p>"
                    ."</ul></li></ul>";
                 }
                 
             }
           }
           
           //echo $nbr_c_affichee;
           if($nbr_c_affichee==0)
               echo "<p>Aucune présentation n'est disponible pour cet enfant.</p>";
         echo '</div>';
         
         //echo "<div id ='".$nomEnfant."_' hidden>TEST + id = ".$nomEnfant."</div> ";
     }
                

                echo "</div>";
            ?>
        </div>
    </div>
    
    <?php //include 'footer.php' ?>

     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">
         $(".dropdown-menu li a").click(function(){
            $(".dropdown-toggle2:first-child").html($(this).text()+' <span class="caret"></span>');
            //console.log($(".dropdown-toggle:first-child").html($(this).text()+' <span class="caret"></span>').text());
            
            var nomEnfant = "#"+$(".dropdown-toggle2:first-child").html($(this).text()+' <span class="caret"></span>').text();
            nomEnfant = nomEnfant.toString();
            console.log(nomEnfant);
            var choice = document.getElementsByClassName("dropdown-menu");
            var i;
            for (i = 0; i < choice.length; i++) 
            {
                var listEnfant;
                for (var member in choice[i]){
                    if(member == "innerText")
                        listEnfant = choice[i][member]
                }
                   
                listEnfant = listEnfant.split(listEnfant[18]);
                //console.log(listEnfant);        
                
                for(var e in listEnfant)
                {
                    //console.log(listEnfant[e]);   
                    console.log(listEnfant[e].indexOf("Enfants"));
                    if(e!= 0 && listEnfant[e] != "" && listEnfant[e] != "Liste" && listEnfant[e] != "des" && (listEnfant[e].indexOf("Enfants")<=-1 || listEnfant[e].indexOf("Enfants")>7) && listEnfant[e] != "Gérer les Enfants ")
                    {
                        var id = listEnfant[e].toString();   
                        console.log(id);

                        id = "#"+id;
                        id2 = id+"2";
                        //console.log(id);
                        $(id).hide();
                        $(id2).hide();
                    }
                }
            }   
            
            
            if($(".dropdown-toggle:first-child").html($(this).text()+' <span class="caret"></span>').text() != "Liste des Enfants  ")
            {
               $(".list_contents").hide();
                $(nomEnfant).show();
                $(nomEnfant+"2").show();
                
            }
            else
            {
                $(".list_contents").show();
            }
          });

    </script>
</body>
</html><?php 
 // Désactiver le rapport d'erreurs
    error_reporting(0);
    session_start();
    ?>

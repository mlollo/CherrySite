<?php
// Désactiver le rapport d'erreurs
    error_reporting(0);
    session_start();

$root = "./";
require "includes.php";

$ecoute = htmlspecialchars($_GET['ecoute']);


    //recherche un contenue ayant comme titre $name et owner "admin_off"
            $contentDao = new ContentDAO(LocalDBClientBuilder::get());
            $contentDAOExist = $contentDao->get("ecoute", "admin_ecoute");
            $contentExist = new Content();
            //recupere les valeurs
            $contentExist = $contentDAOExist;   
            $urlExist = $contentExist->getUrl();
            $ownerExist = $contentExist->getEmailOwner();
            //print_r ($contentExist);

            //si le contenue est trouve (qu'il y a bien une url)
            if($ecoute) {
                echo $ecoute;
                $_SESSION['switch']= 1;//$ecoute;
                //le owner est "admin_off" ==> le change en "admin_on" (pour lancer la video)
                $contentExist->setUrl($ecoute);
                $children =  array();
                //$children[] = array('email' => $_POST['child'], 'dateStart' => $_POST['date_debut'], 'dateEnd' => $_POST['date_fin']);
                $contentDao->UpDate($contentExist, $children);
                // echo $urlExist; 
                $contentDao0->delete($name, "admin_off");
                
            }
            else {
                echo $urlExist;
                //$_SESSION['switch']= 0;
            }
            
            

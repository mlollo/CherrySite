<?php
 // Désactiver le rapport d'erreurs
    error_reporting(0);
    session_start();

    include 'head.php';
    $root = './';
    include "includes.php";
    
    //print_r($_GET);
 
    if($_GET['email'])
        $email = $_GET['email'];

    $childDao = new ChildDAO(LocalDBClientBuilder::get());
    $child = $childDao->get($email);
    $reponse = getContentsChild($child);
    //print_r($child);
    
    $data = array();
    $sous_data = array();
    $c = 0;
    for($i=0; $i<count($reponse); $i+=2)
    {
        
        $sous_data["titre"]=$reponse[$i];
        //si c'est un excel
        if(($reponse[$i+1][0]=='A'&&$reponse[$i+1][1]=='r'&&$reponse[$i+1][2]=='r'&&$reponse[$i+1][3]=='a'&&$reponse[$i+1][4]=='y')
                || ($reponse[$i+1][1]=='A'&&$reponse[$i+1][2]=='r'&&$reponse[$i+1][3]=='r'&&$reponse[$i+1][4]=='a'&&$reponse[$i+1][5]=='y')
                        || ($reponse[$i+1][2]=='A'&&$reponse[$i+1][3]=='r'&&$reponse[$i+1][4]=='r'&&$reponse[$i+1][5]=='a'&&$reponse[$i+1][6]=='y'))
        { 
            //decoupe par info
                        $translate = explode("[",$reponse[$i+1] );
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
                             
                        $etape=array();
                        $info_etape = array();
                        $url = "";
                        $e2 = 0;
                        for($ligne = 2; $ligne < count($translArray) -4; $ligne+=4)
                        {
                            $info_etape["num_etape"] = $e2 + 1;
                            $info_etape["Behave"] = $translArray[$ligne+4];
                            $info_etape["Text"] = $translArray[$ligne+1+4];
                            //enleve la ')' de fin
                            $pos = strpos($translArray[$ligne+2+4], ')');
                            if($pos!==FALSE)
                            {
                                $translArray[$ligne+2+4] = str_replace(')', '', $translArray[$ligne+2+4]);
                            }
                            $info_etape["Slide"] = $translArray[$ligne+2+4];

                            $etape["_".$e2] = $info_etape;

                            $e2++;
                            //print_r($info_etape);
                           
                        }
                        //print_r($etape);
                        //$json = json_encode($etape);
                        //echo $json;
                        
                        $reponse[$i+1] = $etape;
        }
        $sous_data["url"]=$reponse[$i+1];
        
        $data["_".$c]=$sous_data;
        $c++;
    }
    //print_r($data);
    $transfere = json_encode($data);
   // echo $transfere;
    //echo "<br/>FIN";
    $_POST["json"] = $transfere;
    print_r($_POST['json']);
   
    
    function getContentsChild($child)
{
    $contentsFamilial = $child->getContentByType("family");
    $contentsPedagogique = $child->getContentByType("teacher");
    $contentsMedical = $child->getContentByType("doctor");

    $reponse = array();
    if(count($contentsMedical)>0)
    {
        //$reponse[]= 'medical_';
        foreach ($contentsMedical as $contentM)
        {
            //print_r($contentM);
            $owner = $contentM['M']['owner']['S'];
            $name = $contentM['M']['name']['S'];
            $contentDao = new ContentDAO(LocalDBClientBuilder::get());
            $contents = $contentDao->getContentsOfUser($owner);
            foreach ($contents as $c)
            {
                $name2 = $c->getName();
               //echo $name2.' =? '.$name;
                if($name2 == $name)
                {
                    $reponse[] = $name;
                    $reponse[]=$c->getUrl();
                }
                //echo $c->getUrl();
                //echo 'temp  '.$reponse;
            }
            //print_r($contents);
        }
    }
    if(count($contentsFamilial)>0)
    {
        //$reponse[]= 'family_';
        foreach ($contentsFamilial as $contentF)
        {
            $owner = $contentF['M']['owner']['S'];
            $name = $contentF['M']['name']['S'];
            $contentDao = new ContentDAO(LocalDBClientBuilder::get());
            $contents = $contentDao->getContentsOfUser($owner);
            foreach ($contents as $c)
            {
                $name2 = $c->getName();
               //echo $name2.' =? '.$name;
                if($name2 == $name)
                {
                    $reponse[] = $name;
                    $reponse[]=$c->getUrl();
                }
                //echo $c->getUrl();
                //echo 'temp  '.$reponse;
            }
        }
    }
    if(count($contentsPedagogique)>0)
    {
        //$reponse[]= 'teaching_';
        foreach ($contentsPedagogique as $contentP)
       {
            $owner = $contentP['M']['owner']['S'];
            $name = $contentP['M']['name']['S'];
            $contentDao = new ContentDAO(LocalDBClientBuilder::get());
            $contents = $contentDao->getContentsOfUser($owner);
            foreach ($contents as $c)
            {
                $name2 = $c->getName();
               //echo $name2.' =? '.$name;
                if($name2 == $name)
                {
                    $reponse[] = $name;
                    $reponse[]=$c->getUrl();
                }
                //echo $c->getUrl();
                //echo 'temp  '.$reponse;
            }
        }
    }
    
    //print_r($reponse);
    return $reponse;
}

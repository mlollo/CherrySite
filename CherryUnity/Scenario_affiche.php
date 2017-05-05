<?php
// Désactiver le rapport d'erreurs
    error_reporting(0);
    //session_start();
    
    //print_r($_GET);
    //echo "<br/><br/>";
        
    //echo($_GET['json']);
    
    $data = explode("___",  urldecode(gzuncompress($_GET['json'])));
    //echo "<br/>DATA<br/>";
    //print_r($data);
   echo "<br/>JSON DECODE<br/>";
    for($i=0; $i<count($data); $i++)
    {
        var_dump( json_decode($data[$i]));
    }
    
    
    
    
    
    
?>
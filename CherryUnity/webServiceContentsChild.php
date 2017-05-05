<?php
error_reporting(0);
session_start();

$root = "./";
include 'includes.php'; 


//print_r($_SESSION);
$childDao = new ChildDAO(LocalDBClientBuilder::get());
$email = $_SESSION['email'];
$child = $childDao->get($email);
//print_r($child);
$reponse = getContentsChild($child);
header('Content-Type: application/json');
$response = json_encode($reponse);

echo $reponse;

function getContentsChild($child)
{
    $contentsFamilial = $child->getContentByType("family");
    $contentsPedagogique = $child->getContentByType("teacher");
    $contentsMedical = $child->getContentByType("doctor");


    $reponse = '["';
    if(count($contentsMedical)>0)
    {
        $reponse.= 'medical:';
        foreach ($contentsMedical as $contentM)
        {
            //print_r($contentM);
            $reponse.= $contentM['M']['name']['S'].'&';
        }
    }
    if(count($contentsFamilial)>0)
    {
        $reponse.= 'family:';
        foreach ($contentsFamilial as $contentF)
        {
            $reponse.= $contentF['M']['name']['S'].'&';
        }
    }
    if(count($contentsPedagogique)>0)
    {
        $reponse.= 'teaching:';
        foreach ($contentsPedagogique as $contentP)
       {
            $reponse.= $contentP['M']['name']['S'].'&';
        }
    }
    $reponse.= '"]';
    
    return $reponse;
}

/*
function getNewContentAvailable($child){
    $newContents = array();
    $teaching = $child->getTeachingContent();
    $medical = $child->getMedicalContent();
    $family = $child->getfamilyContent();

    if (isNewContent($teaching))
        {
            $newContents[]= "teaching";
            foreach($child->getTeachingContent() as $element)
            {
                foreach ($element as $elem2)
                {
                    $newContents[]= $elem2["name"];
                }
            }
        } 
        //$newContents[]= "teaching";

    if (isNewContent($medical))
        {
            $newContents[]= "medical";
            foreach($child->getMedicalContent() as $element)
            {
                foreach ($element as $elem2)
                {
                    $newContents[]= $elem2["name"];
                }
            }
        }   
        //$newContents[]= "medical";


    if (isNewContent($family))
        {
            $newContents[]= "family";
            foreach($child->getfamilyContent() as $element)
            {
                foreach ($element as $elem2)
                {
                    $newContents[]= $elem2["name"];
                }
            }
        } 
        //$newContents[]= "family";
    
    return $newContents;
}

function isNewContent($contents){
    foreach($contents as $content ){
        if($content['M']['notified']['N'] == 0)
            return true;         
    }
    return false;
}

echo 'bou';
/*
$childDao = new ChildDAO(LocalDBClientBuilder::get());
if(!empty($_GET['email']))
$email = $_GET['email'];
$child = $childDao->get($email);
$contents = getNewContentAvailable($child);
header('Content-Type: application/json');
$response = json_encode($contents);
echo $response;




/*session_start();

$root = "./";
include 'includes.php'; 


function getNewContentAvailable($child){
    $newContents = array();
    $teaching = $child->getTeachingContent();
    $medical = $child->getMedicalContent();
    $family = $child->getfamilyContent();

    if (isNewContent($teaching))
    {
        $type= "teaching_";
        //$contents = $child->getTeachingContent();
    }
    if (isNewContent($medical))
    {
        $type= "medical_";
        //$contents = $child->getMedicalContent();
    }
    if (isNewContent($family))
    {
        $type= "family_";
        //$contents = $child->getFamilyContent();   
    }
    
    $length = count($contents);
    
    for ($i = 0; $i < $length; $i++) {
        $contentInfo = $contents[$i];
        
        $name = $contentInfo['M']['name']['S'];
        $allName += $name + "&"; 
    }
    
    //$newContents[] = $type + $allName;
    
    return $newContents;
}

function isNewContent($contents){
    foreach($contents as $content ){
        if($content['M']['notified']['N'] == 0)
            return true;         
    }
    return false;
}
 
$childDao = new ChildDAO(LocalDBClientBuilder::get());//DynamoDbClientBuilder::get());
if(!empty($_GET['email']))
$email = $_GET['email'];
$child = $childDao->get($email);
$contents = getNewContentAvailable($child);
header('Content-Type: application/json');
$response = json_encode($contents);
echo $response;
*/
?>



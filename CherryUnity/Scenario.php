<?php
// Désactiver le rapport d'erreurs
    error_reporting(0);
    session_start();
    
    if(count($_POST)==0)
        $_POST = $_SESSION['post'];
    else
        $_SESSION['post']= $_POST;
    //print_r($_SESSION);
    
    function make_curl_request($method, $url, $params)
    {        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
                array(
            'Content-Type: application/json',
            'Access-Control-Allow-Methods: GET, POST',
            'Access-Control-Allow-Origin: *'
                    )
        );
        
        if($method == "POST")
        {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }
        
        return json_decode(curl_exec($ch));
    }
    ?>
<html>
<head>
    <meta charset="utf8">
    <title>Ajout d'un excel de description de scénario</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
   <!-- <script type='text/javascript' src='script.js'></script>-->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <?php 
        $root = "./";
        
        include 'head.php' ;
        require "includes.php";
    ?>

</head>

<body>
    <?php include 'nav.php' ;
    include 'includes.php';
    
    
    //print_r($_POST);
    //print_r($_POST['url_post']);echo "<br/><br/>";
    //echo "<br/><br/>";
    //print_r($_POST['url']);echo "<br/><br/>ALL 2 :<br/>";
    
    $all = explode( "--- ", $_POST['url']);    
    $etape = array();
    for($i=1; $i< count($all); $i++)
    {
        $etape[] = $all[$i];
    }
    
   /* echo "->".$etape[0][14];
    echo $etape[0][15];
    echo $etape[0][16];
    echo $etape[0][17];   
    echo $etape[0][18]."<-";*/
    
    $br = $etape[0][14].$etape[0][15].$etape[0][16].$etape[0][17].$etape[0][18];
    
    $all2 = explode($br,$_POST['url'] );
    
   /* echo "<br/> [0]";
    echo $all2[0];
    echo "<br/> [1]";
    echo $all2[1];
    echo "<br/>";
    echo $all2[2];
    echo "<br/>";
    echo $all2[3];
    echo "<br/>";
    echo $all2[4];*/
    
    //print_r($all2);echo "<br/><br/>";
    $arrayStep = array();
    $arrayBehave = array();
    $arrayText = array();
    $arraySlide = array();
    for($i=0; $i<count($all2); $i += 4)
    {
        $all2[$i] = str_replace("--- ", "", $all2[$i]);
        $nbEtape = str_replace("n"."° ", "", $all2[$i]);
        $nbEtape = str_replace("Étape", "", $nbEtape);
        $nbEtape = str_replace(" ", "", $nbEtape);
        $nbEtape = str_replace(":", "", $nbEtape);
        if($nbEtape != ""){
           $arrayStep[]=$nbEtape; 
        }
        
        $all2[$i+1] = str_replace("Behave : ", "", $all2[$i+1]);
        $variable = substr($all2[$i+1], 0, strpos($all2[$i+1], "+"));
        $arrayBehave[] = $variable;
        $all2[$i+2] = str_replace("Text : ", "", $all2[$i+2]);
        $all2[$i+2] = str_replace("Text  : ", "", $all2[$i+2]);
        $arrayText[] = $all2[$i+2];
        $all2[$i+3] = str_replace("Slide        : ", "", $all2[$i+3]);
        $all2[$i+3] = str_replace("Slide         : ", "", $all2[$i+3]);
        $arraySlide[] = $all2[$i+3];
        
     /*//TEST TEXT
        echo $all2[$i+2][0]."__";
        echo $all2[$i+2][1]."__";
        echo $all2[$i+2][2]."__";
        echo $all2[$i+2][3]."__";
        echo $all2[$i+2][4]."__";
        echo $all2[$i+2][5]."__";
        echo $all2[$i+2][6]."__";
        echo $all2[$i+2][7]."__";
        echo $all2[$i+2][8]."__";
        echo $all2[$i+2][9]."__";
        echo $all2[$i+2][10]."__";
        echo $all2[$i+2][11]."__";
        echo $all2[$i+2][12]."__";
        echo $all2[$i+2][13]."__";
        echo $all2[$i+2][14]."__";
        echo $all2[$i+2][15]."__";
        echo $all2[$i+2][16]."__";
        echo $all2[$i+2][17]."__";
        echo $all2[$i+2][18]."__";
        echo $all2[$i+2][19]."__";
        echo $all2[$i+2][20]."__";
        echo $all2[$i+2][21]."__";
        echo $all2[$i+2][22]."__";
        
        */
        /*
        //TEST SLIDE
        echo $all2[$i+3][0]."__";
        echo $all2[$i+3][1]."__";
        echo $all2[$i+3][2]."__";
        echo $all2[$i+3][3]."__";
        echo $all2[$i+3][4]."__";
        echo $all2[$i+3][5]."__";
        echo $all2[$i+3][6]."__";
        echo $all2[$i+3][7]."__";
        echo $all2[$i+3][8]."__";
        echo $all2[$i+3][9]."__";
        echo $all2[$i+3][10]."__";
        echo $all2[$i+3][11]."__";
        echo $all2[$i+3][12]."__";
        echo $all2[$i+3][13]."__";
        echo $all2[$i+3][14]."__";
        echo $all2[$i+3][15]."__";
        echo $all2[$i+3][16]."__";
        echo $all2[$i+3][17]."__";
        echo $all2[$i+3][18]."__";
        echo $all2[$i+3][19]."__";
        echo $all2[$i+3][20]."__";
        echo $all2[$i+3][21]."__";
        echo $all2[$i+3][22]."__";
        
        */
        
        
        
        
        
        
        
    }
    
    //print_r($all2);echo "<br/><br/>";
    //print_r($arrayStep);
    $datas = array();
    $sous_data = array();
    $chaineData = "";
    $e=0;
    for($i=0; $i<count($all2); $i += 4)
    {
        if($all2[$i]!="")
        {
            $sous_data["num_etape"] = $all2[$i];
            $sous_data["Behave"] = $all2[$i+1];
            $sous_data["Text"] = $all2[$i+2];
            $sous_data["Slide"] = $all2[$i+3];

            $datas["_".$e] = $sous_data;
            
            $e++;
        }
    }  
    /*for($i=0; $i<count($arrayStep); $i++) {
        $step = $arrayStep[$i] - 1;
        $chaineData.=',"_'.$step.'":{"Behave":"'.$arrayBehave[$i].'","Text":"'.$arrayText[$i].'", "Slide":"'.$arraySlide[$i].'",
            "Robot":"sogeti", "Language":""}';
    } */
    //print_r($datas);
    $transfere = json_encode($datas);
    //print "chaine".$chaineData."fin chaine";
    
   
    ?>
    <div class='container'>
        
    <?php
    
    
    //echo $string;
    $data = explode("___", $string); 
    //echo "<br/>DATA<br/>";
    //print_r($data);
    $gtran = str_replace("'", "&acute;", $transfere);
    //echo "<br/>DATA<br/>";
    //print_r($data);
   
   // print_r($gtran);    
    $hidden ="";
    $show = "hidden";
    if(isset($_GET['json']))
    {
        
        make_curl_request("POST", "http://".$ip.":8080/jsonreader", $gtran );
        $hidden = "hidden";
        $show = "";
    }
    if(isset($_GET['stop']))
    {
        
        $show = "hidden";
        $hidden = "";
    }
    ?>
    <?php 
    $chaineStep = "'";
    $chaineBehave = "'";
    $chaineText = "'";
    $chaineSlide = "'";
        for($j=0; $j<count($arrayStep); $j++) {
            $chaineStep.=$arrayStep[$j].";";
            $chaineBehave.=$arrayBehave[$j].";";
            $chaineText.=$arrayText[$j].";";
            $chaineSlide.=$arraySlide[$j].";";

        }
        $chaineStep .= "'";
        $chaineBehave .= "'";
        $chaineText .= "'";
        $chaineSlide .= "'";
        echo $chaineStep;
        echo "\n".$chaineBehave;
        echo "\n".$chaineText;
        echo "\n".$chaineSlide;
     ?>
        <div style="padding: 20px; margin: 10px 0 50px 120px;" class="row">
            <div class="col-sm-3">
            <div style="background-color: limegreen; width: 180px; height: 40px; padding: 10px 0 0 0;" <?php echo $hidden; ?>>
                <a href='Scenario.php?json=true' onclick="LancePrez(<?php echo $chaineStep ?>, <?php echo $chaineBehave ?>, <?php echo $chaineText ?>, <?php echo $chaineSlide ?>)" style="color:white; margin: 0px 0px 0px 20px;"><span class="glyphicon glyphicon-play" style="margin-right: 6px;"></span>Jouer ce scénario </a>
            </div></div>
            <div class="col-sm-3">
            <div style="background-color: firebrick; width: 215px; height: 40px; padding: 10px 0 0 0;" <?php echo $show; ?>>
                <a href='Scenario.php?stop=true' style="color:white; margin: 0px 0px 0px 20px;" onclick="StopRobot()"><span class="glyphicon glyphicon-stop" style="margin-right: 6px;"></span>Stopper la présentation </a>
            </div></div>
        </div>
        
    <?php    
   
    //affichage
    $tab_url = explode("---", $_POST["url"]);
    //print_r($tab_url);
    
    echo "<h1 style='margin-left: 25px'>Description du Scénario :</h1>";
    foreach ($tab_url as $une_etape)
    {
        $mvt_robot = "http://".$ip.":8080/test/behave?name=";
        if(strpos($une_etape, "question_behave")!== false)
        {
            $img = "img/question_behave.png";
            $mvt = "question_behave";
        }
        else if(strpos($une_etape, "swap_behave")!== false)
        {
            $img = "img/swap_behave.png";
            $mvt = "swap_behave";
        }
        else if(strpos($une_etape, "point_arm_left_behave ")!== false)
        {
            $img = "img/point_arm_left_behave.png";
            $mvt = "point_arm_left_behave";
        }
        else if(strpos($une_etape, "left_arm_up_behave")!== false)
        {
            $img = "img/left_arm_up_behave.png";
            $mvt = "left_arm_up_behave";
        }
        else if(strpos($une_etape, "rest_open_behave ")!== false)
        {
            $img = "img/rest_open_behave.png";
            $mvt = "rest_open_behave";
        }
        else if(strpos($une_etape, "head_idle_motion ")!== false)
        {
            $img = "img/head_idle_motion.png";
            $mvt = "head_idle_motion";
        }
        else if(strpos($une_etape, "double_me_behave ")!== false)
        {
            $img = "img/double_me_behave.png";
            $mvt = "double_me_behave";
        }
        else if(strpos($une_etape, "torso_idle_motion ")!== false)
        {
            $img = "img/torso_idle_motion.png";
            $mvt = "torso_idle_motion";
        }
        $mvt_robot.=$mvt;
        
        if($une_etape!=$tab_url[0])
            echo "<div class='col-sm-8'><p style='margin-left: 12px;margin-top: 15px;'>".$une_etape."</div><div class='col-sm-4'><a href='Scenario.php' onclick='LanceRobot(\"".$mvt."\")'><img  src='".$img."' style='height: 100px; margin-bottom: 15px;' /></a></div><br/><HR size=1 width ='80%' align=center><br/>";
    }
    
    //print_r($_POST['url']);
    echo '<div class="col-sm-8"><form class="formB" action="adultShowContents.php"><button type="submit" class="btn btn-danger" name="Valider" onclick style="margin: 0 0 20px 20px;" >Retour aux contenus</button></form>';
    echo '</div></p>';
    
    ?>
        
        </div>
    
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>  
    <script type="text/javascript">
       
        
        function LanceRobot(elemnt)
        {
            /*$.ajax({
                 url: "http://127.0.0.1:8080/test/behave?name=question_behave";
             });*/
        /*$.ajax({
                 url: "http://"+<?php echo '"'.$ip.'"'; ?>+":8080/test/behave?name="+elemnt,
                 timeout : 3000                 
            });
             console.log("ok : "+"http://"+<?php echo '"'.$ip.'"'; ?>+":8080/test/behave?name="+elemnt); */
        }

        function LancePrez(step, behave, text, slide) {
            //console.log('{"Path_to_WS":"http://localhost:80/PlateformeRobotPresentateur/WS_video.php"'+String(data)+"}");
            step = step.split(';');
            behave = behave.split(';');
            text = text.split(';');
            slide = slide.split(';');
            chaineData = '{"Path_to_WS":"http://localhost:80/PlateformeRobotPresentateur/WS_video.php"';

            for (i=0; i<step.length-1; i++) {
                stepNb = Number(step[i])-1;
                chaineData += ',"_' + stepNb + '":{"Behave":"'+ behave[i] + '","Text":"' + text[i] + '", "Slide":"' + slide[i] + '","Robot":"sogeti", "Language":""}';
            }
            chaineData += '}';
            $.ajax({
            url: "http://"+<?php echo '"'.$ip.'"'; ?>+"/jsonreader",
            cache: false,
            type: 'post',
            contentType: false,
            data: chaineData
            ,
            success: function(php_script_response){
                console.log("SUCCESS - play scenario on server : " + php_script_response.info);
                //alert(php_script_response); // display response from the PHP script, if any
            }
        }); 
        }
        
        function StopRobot()
        {
            /*$.ajax({
                 url: "http://127.0.0.1:8080/test/behave?name=question_behave";
             });*/
        $.ajax({
                 url: "http://192.168.1.103:8080/stop?presentation=off"
                 
            });
             
        }
        
        </script>

<footer class="footer">
            <div class="container-fluid">
                <img  height="60px" src="img/logo.jpg"/> 
            </div>
        </footer>
</html>

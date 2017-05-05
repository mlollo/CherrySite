<?php 
// Désactiver le rapport d'erreurs
    error_reporting(0);
    session_start();
    $root = "./";
    include 'includes.php'; 
    
    //pour le check presentation
    $_SESSION['switch']=0;
?>
<html>
    
<head>
    <?php include 'head.php' ?>
    <title>Maison </title>
    
    <style type="text/css">
        body {
            font-family: Helvetica, Verdana, Arial, sans-serif;
            background-color: white;
            color: black;
            text-align: center;
        }
        
        a{
            text-align: center;
        }
        a:link, a:visited {
            color: #000;
        }
        a:active, a:hover {
            color: #666;
        }
        p.header {
            font-size: small;
        }
        p.header span {
            font-weight: bold;
        }
        p.footer {
            font-size: x-small;
        }
        div.content {
            margin: auto;
            /*width: 480px;*/
        }
       
        div.missing {
            margin: auto;
            position: relative;
            top: 50%;
            width: 193px;
        }
        div.missing a {
            height: 63px;
            position: relative;
            top: -31px;
        }
        div.missing img {
            border-width: 0px;
        }
        div#unityPlayer {
            margin: auto;
            cursor: default;
            height: 320px;
            width: 480px;
        }
    </style>
</head>

<body>
    <?php //include 'nav.php'
    
      /*  //print_r($_SESSION);
        $childDao = new ChildDAO(DynamoDbClientBuilder::get());
        $email = $_SESSION['email'];
        $child = $childDao->get($email);
        //print_r($child);
        $contentsFamilial = $child->getContentByType("family");
        $contentsPedagogique = $child->getContentByType("teacher");
        $contentsMedical = $child->getContentByType("doctor");
        
        echo '["';
        if(count($contentsMedical)>0)
        {
            echo 'medical_';
            foreach ($contentsMedical as $contentM)
            {
                //print_r($contentM);
                echo $contentM['M']['name']['S'].'&';
            }
        }
        if(count($contentsFamilial)>0)
        {
            echo 'family_';
            foreach ($contentsFamilial as $contentF)
            {
                echo $contentF['M']['name']['S'].'&';
            }
        }
        if(count($contentsPedagogique)>0)
        {
            echo 'teaching_';
            foreach ($contentsPedagogique as $contentP)
            {
                echo $contentP['M']['name']['S'].'&';
            }
        }
        echo '"]';*/
    ?>
    
   <!-- <p class="header"><span>Unity Web Player | </span>WebPlayer</p>-->
    <div class="content">
        <div id="unityPlayer">
            <div class="missing">
                <a href="http://unity3d.com/webplayer/" title="Unity Web Player. Install now!">
                    <img alt="Unity Web Player. Install now!" src="http://webplayer.unity3d.com/installation/getunity.png" width="193" height="63" />
                </a>
            </div>
        </div>
        
        
        <div id="jeu_multiplication">
            <?php
                //if(l'enfant a demander au robot de jouer)
                //alors affiche le jeu
                //code du jeu :
                echo '<table style="margin:0 0 10px 0; width:244px; background:#fff; border:1px solid #F3F3F3;" cellspacing="0" cellpadding="0"><tr><td style="font-family:verdana; font-size:11px; color:#000; padding:40px 5px 5px 250px;"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="808" height="561"><param name="movie" value="http://www.jeuxclic.com/jeux/542729ad0f1e6.swf"><param name="quality" value="high"></param><param name="menu" value="false"></param><embed src="http://www.jeuxclic.com/jeux/542729ad0f1e6.swf" width="808" height="561" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" menu="false"></embed></object></td></tr></table>'
            ?>
        </div>
    </div>
    
     
 
    <p class="footer">« created with <a mimetype="application/octet-stream" href="http://unity3d.com/unity/" title="Go to unity3d.com">Unity</a> »</p>
    
   <!-- <div class="container">
        <div class="row">
            <p>Bienvenue chez toi.
            <?php
                /*$firstname = $_SESSION['name'];
                echo " " . $firstname;
                echo '<span id="unity" email='.$_SESSION['email'] . '> </span>'*/             
            echo "*".$_SESSION['email']."*";
                ?>
            </p>
        </div>
    </div>-->
    
    

    <?php include 'footer.php' ?>
    
    <script type="text/javascript" src="http://webplayer.unity3d.com/download_webplayer-3.x/3.0/uo/UnityObject.js"></script>
       <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">
       /*var varGlob = "";
       function recieveData(){
            var ajaxObject = new XMLHttpRequest();
            ajaxObject.open("GET", "data.php");
            ajaxObject.onload = function(){
               if(ajaxObject.readyState == 4 || ajaxObject.status == 200)
               {
                   //document.getElementById("update").innerHTML = ajaxObject.responseText;
                   varGlob = ajaxObject.responseText;
                   recieveData();
               }
            }
            ajaxObject.send();
          }
          recieveData();*/
    
        function GetUnity() {
            if (typeof unityObject != "undefined") {   

                return unityObject.getObjectById("unityPlayer");
            }
            return null;
        }
    
        if (typeof unityObject != "undefined") {
            unityObject.embedUnity("unityPlayer", "Build.unity3d", screen.width, screen.height);// 1350, 850);///*1130*/1288,650);//830, 480);                
        }   
       
      function gameReady(message){                    
          GetUnity().SendMessage("Camera/MyCanvas", "GetSessionId", $('#unity').attr("email"));     

      }
      function Check() {
          unityObject.getObjectById("unityPlayer").SendMessage("FPSController", "CheckPresentation", "Hello from a web page!");
          console.log("CheckPresentation");
      }
      
      function Ecoute() {
          unityObject.getObjectById("unityPlayer").SendMessage("FPSController", "Ecoute", "Hello from a web page!");
          console.log("Ecoute");
      }
      
       function StopPres() {
          unityObject.getObjectById("unityPlayer").SendMessage("FPSController", "StopPres", "Hello from a web page!");
          console.log("StopPres");
      }
      
      function checkTest(){
          
           setTimeout(function(){$.post("ajax/check.php", function(data){
                        console.log(data);                        //console.log("varGlob : "+varGlob );

			if(data!=0){
                            Check();
                            Ecoute();
                            //StopPres();
                            <?php $_SESSION['switch']=1;//1;// ?>
                            checkTest();
                        }
			else checkTest();
		});}, 3000);
	    }
       $(document).ready(function(e){ checkTest(); });     
       // de la ...
       /*$(document).ready(function()
            {
                /*$.ajax({
                     url: "http://127.0.0.1:8080/test/behave?name=question_behave";
                 });*/
               /* $.ajax({
                         url: "http://"+"<?php echo $ip; ?>"+":8080/users/define?adress="+"<?php echo $_SESSION['email'];?>"
                         


                });
                 console.log("ok : "+"http://"+"<?php echo $ip; ?>"+":8080/users/define?adress="+"<?php echo $_SESSION['email'];?>");

           }); 
           // a la : enleve, je ne sais pas si ca sert vraiment, cela cree une erreur si on ne remplace pas localhost par l'ip
      /*function LaunchPresentation(message){                    
          //var u = new UnityObject2(config);
         //u.getUnity().SendMessage("MyObject", "MyFunctionWeb", "hello !!!");
          GetUnity().SendMessage("MyObject", "MyFunctionWeb", "hello !!!");      

      }
      
   
   /* var u = new UnityObject2();
    u.observeProgress(function (progress) {
            var $missingScreen = jQuery(progress.targetEl).find(".missing");
            switch(progress.pluginStatus) {
                case "unsupported":
                    showUnsupported();
                break;
                case "broken":
                    alert("You will need to restart your browser after installation.");
                break;
                case "missing":
                    $missingScreen.find("a").click(function (e) {
                        e.stopPropagation();
                        e.preventDefault();
                        u.installPlugin();
                        return false;
                    });
                    $missingScreen.show();
                break;
                case "installed":
                    $missingScreen.remove();
                break;
                case "first":
                break;
            }
        });
        jQuery(function(){
            u.initPlugin(jQuery("#unityPlayer")[0], "Build.unity3d");
            setTimeout(function(){
                alert('coucou');
                console.log(Object.getOwnPropertyNames(u.getUnity()));
            },30000
            );
            alert(u);
            
        });*/

        
    
     //.SendMessage("Camera/MyCanvas", "GetSessionId", "sessionID"));
    </script>
    

    </body>
</html>





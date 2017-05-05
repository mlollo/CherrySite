<?php 
 // Désactiver le rapport d'erreurs
    error_reporting(0);
    session_start() ?>
<!doctype html>
<html>
    
<head>
    <meta charset="utf-8">
    <title>Création contenu</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    
        
    <?php include 'head.php' ;
    $root = './';
        
    /*print_r($_POST);
    
    echo '<br/><br/>';
    print_r($_POST['valeur']);*/
    ?>
    <title>Content </title>
</head>

<body>
    <?php
        include 'includes.php'; 
        $email = $_SESSION['email'];
        $childDao = new ChildDAO(LocalDBClientBuilder::get());
        $children = $childDao->getChildren($email);
        
        $nbre_enfant = 0;
        foreach($children as $child)
            {
                $nbre_enfant++;
            }

        include 'nav.php' 
      ?>
    
    <h1>Créer un nouveau contenu texte</h1>
    
    <form method="post" action="creerContenueText.php" id="form1" <?php echo 'onsubmit="return testcheck('.$nbre_enfant.')"'; ?> >
   <p>
       <div id="contenueTextArea" style="margin: 0px 0px 0px 100px;">
           <strong>Titre du texte :</strong>
           <textarea name="titreTexte" id="ameliorer" rows="1" cols="50"><?php
                     if($_POST['valeur'][0])
                         echo $_POST['valeur'][0];
                     ?></textarea>      
           <br /><br /><br />
           
           <?php
           //si pas de post valeur ou l'url est du texte et non une url
           if(!$_POST['valeur'] || ($_POST['valeur'][2][0]!= 'h'  &&  $_POST['valeur'][2][1]!= 't'  &&  $_POST['valeur'][2][2]!= 't'  &&  $_POST['valeur'][2][3]!= 'p'  &&  $_POST['valeur'][2][4]!= 's'  &&  $_POST['valeur'][2][5]!= ':'  &&  $_POST['valeur'][2][6]!= '/'  &&  $_POST['valeur'][2][7]!= '/'))
           {
           ?>
           <strong>Tapez votre texte ci-dessous :</strong>
           <br /><br />
           <?php
                     if($_POST['valeur'][0])
                     {
                        //si le texte correspond a l'extraction d'un excel, traduit les donnees a afficher
                         if($_POST['valeur'][2][0]=='A'&&$_POST['valeur'][2][1]=='r'&&$_POST['valeur'][2][2]=='r'&&$_POST['valeur'][2][3]=='a'&&$_POST['valeur'][2][4]=='y'&&$_POST['valeur'][2][5]=='('&&$_POST['valeur'][2][10]=='['&&$_POST['valeur'][2][11]=='0')
                         {
                             //echo $_POST['valeur'][2];
                             //decoupe par info
                             $translate = explode("[",$_POST['valeur'][2] );
                             $translArray = array();
                                                          
                             //enleve l'index
                             foreach ($translate as $str)
                             {
                                //enleve la ')' de fin
                                 if($str[strlen($str)- 5] == ')')
                                 {
                                     $str = explode(')', $str);
                                     $str = $str[0];
                                 }
                                 
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
                             
                             for($ligne = 2; $ligne < count($translArray) -4; $line+=4)
                             {
                                 echo "<input name='contenueTexte0' value='".$translArray[2]."' hidden>"
                                         . "<input name='contenueTexte1' value='".$translArray[3]."' hidden>"
                                         . "<input name='contenueTexte2' value='".$translArray[4]."' hidden>"
                                         . "<h4 style=' margin-left: 65px;'><span class='glyphicon glyphicon-pencil' style='margin-right: 10px;'></span>&Eacute;tape n° ".$etape." :</h4>";
                                 echo "<input name='contenueTexte".($ligne+1)."' id='ameliorer' rows='1' cols='100' style='margin-left: 20px;'value=".$translArray[$ligne+4]." hidden>";
                                 
                                 $name_img="";
                                 if(strpos($translArray[$ligne+4],"swap_behave")!==false)
                                     $name_img = "swap_behave.png";
                                 else if(strpos($translArray[$ligne+4],"head_idle_motion")!==false)
                                     $name_img = "head_idle_motion.png";
                                 else if(strpos($translArray[$ligne+4],"double_me_behave")!==FALSE)
                                     $name_img = "double_me_behave.png";
                                 else if(strpos($translArray[$ligne+4],"question_behave")!==FALSE)
                                     $name_img = "question_behave.png";
                                 else if(strpos($translArray[$ligne+4],"torso_idle_motion")!==FALSE)
                                     $name_img = "torso_idle_motion.png";
                                 else if(strpos($translArray[$ligne+4],"left_arm_up_behave")!==FALSE)
                                     $name_img = "left_arm_up_behave.png";
                                 else if(strpos($translArray[$ligne+4],"rest_open_behave")!==FALSE)
                                     $name_img = "rest_open_behave.png";
                                 else if(strpos($translArray[$ligne+4],"hunkers_behave")!==FALSE)
                                     $name_img = "hunkers_behave.png";
                                 else if(strpos($translArray[$ligne+4],"point_arm_left_behave")!==FALSE)
                                     $name_img = "point_arm_left_behave.png";
                                 else if(strpos($translArray[$ligne+4],"upper_body_idle_motion")!==FALSE)
                                     $name_img = "upper_body_idle_motion.png";
                                 
                                 
                                 echo '<div class="dropdown">
                                     <input type="hidden" name="Behave[]" class="Behave">
                                     '.$translArray[2].' : 
                                    <button class="btn btn-primary dropdown-toggle " type="button" data-toggle="dropdown" style="margin-left: 19px;">'.$translArray[$ligne+4].'                                    
                                    <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                      <li ><a href="#" name="swap_behave" style="height: 110px; line-height: 100px;">swap_behave&nbsp;<img  src="img/swap_behave.png" style="height: 100px; float: right;" /></a></li><li ><a href="#" name="head_idle_motion" style="height: 110px; line-height: 100px;">head_idle_motion&nbsp;<img  src="img/head_idle_motion.png" style="height: 100px; float: right;"/></a></li>
                                      <li ><a href="#" name="double_me_behave" style="height: 110px; line-height: 100px;">double_me_behave&nbsp;<img  src="img/double_me_behave.png" style="height: 100px; float: right;" /></a></li><li ><a href="#" name="question_behave" style="height: 110px; line-height: 100px;">question_behave&nbsp;<img  src="img/question_behave.png" style="height: 100px; float: right;" /></a></li>
                                      <li ><a href="#" name="torso_idle_motion" style="height: 110px; line-height: 100px;">torso_idle_motion&nbsp;<img  src="img/torso_idle_motion.png" style="height: 100px; float: right;" /></a></li>
                                      <li ><a href="#" name="left_arm_up_behave" style="height: 110px; line-height: 100px;">left_arm_up_behave&nbsp;<img  src="img/left_arm_up_behave.png" style="height: 100px; float: right;" /></a></li><li ><a href="#" name="rest_open_behave" style="height: 110px; line-height: 100px;">rest_open_behave&nbsp;<img  src="img/rest_open_behave.png" style="height: 100px; float: right;" /></a></li>
                                      <li ><a href="#" name="hunkers_behave" style="height: 110px; line-height: 100px;">hunkers_behave&nbsp;<img  src="img/hunkers_behave.png" style="height: 100px; float: right;"/></a></li>
                                      <li ><a href="#" name="point_arm_left_behave" style="height: 110px; line-height: 100px;">point_arm_left_behave&nbsp;<img  src="img/point_arm_left_behave.png" style="height: 100px; float: right;" /></a></li><li ><a href="#" name="upper_body_idle_motion" style="height: 110px; line-height: 100px;">upper_body_idle_motion&nbsp;<img  src="img/upper_body_idle_motion.png" style="height: 100px; float: right;" /></a></li>
                                      
                                    </ul>
                                    <img  class="img_associee" src="img/'.$name_img.'" style="height: 100px; margin-left: 40px;" />
                                  </div><br/>';
                                 echo "<div style='margin-bottom: 30px;'>".$translArray[3]. ": <textarea name='contenueTexte".($ligne+1+1)."' id='ameliorer' rows='2' cols='100' style='margin-left: 40px;margin-bottom: -31px;'>".$translArray[$ligne+1+4]."</textarea></div><br/>";
                                 
              /*                   echo '<div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Dropdown Example
                                        <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                          <li><a href="#">HTML</a></li>
                                          <li><a href="#">CSS</a></li>
                                          <li><a href="#">JavaScript</a></li>
                                        </ul>
                                      </div>';
               * 
               * 
               */
                                 $userDao = new UserDAO(LocalDBClientBuilder::get());
                                 $email = "admin_off";
                                 $user = $userDao->get($email);
                                 $contentDaoD = new ContentDAO(LocalDBClientBuilder::get());
                                 $contents = $contentDaoD->getContentsOfUser($email);
                                 //print_r($contents);
                                 
                                // echo "<div>".$translArray[4]. ": <textarea name='contenueTexte".($ligne+1+2)."' id='ameliorer' rows='1' cols='100' style='margin-left: 38px;'>".$translArray[$ligne+2+4]."</textarea></div><br/>";
                                 echo '<div class="dropdown">'
                                      .'<input name="contenueTexte'.($ligne+2+1).'" id="ameliorer" rows="1" cols="100" style="margin-left: 20px;" value='.$translArray[$ligne+2+4].' hidden>'
                                     .'<input type="hidden" name="Slide[]" class="Slide">
                                     '.$translArray[4].' : 
                                    <button class="btn btn-warning dropdown-toggle " type="button" data-toggle="dropdown" style="margin-left: 40px;">'.$translArray[$ligne+2+4].'                                    
                                    <span class="caret"></span></button>
                                    <ul class="dropdown-menu">';
                                 
                                 foreach($contents as $c)
                                 {
                                     echo '<li ><a href="#" name="'.$c->getName().'">'.$c->getName().'&nbsp;</a></li>';
                                 }
                                 
                                 echo '  </ul>
                                  </div><br/>';
                                 echo "<br/><HR size=1 width ='80%' align=center><br/>";
                                 $ligne += 4;
                                 $etape++;
                             }
                             echo "<input name='contenueTexteNBRE' value='".($ligne - 1)."' hidden>";
                             //print_r($translArray);
                             
                         }
                         else
                             echo "<textarea name='contenueTexte' id='ameliorer' rows='10' cols='150'>".$_POST['valeur'][2]."</textarea>";
                     }
                     else
                         echo "<textarea name='contenueTexte' id='ameliorer' rows='10' cols='150'>Tapez ici votre texte à diffuser !</textarea>";
                     ?> <br /><br />
           <?php
           }
           else
           {
               echo "<strong>Voici le lien du contenu :</strong>";
               if(($_POST['valeur'][2][0]== 'h'  &&  $_POST['valeur'][2][1]== 't'  &&  $_POST['valeur'][2][2]== 't'  &&  $_POST['valeur'][2][3]== 'p'  &&  $_POST['valeur'][2][4]== 's'  &&  $_POST['valeur'][2][5]== ':'  &&  $_POST['valeur'][2][6]== '/'  &&  $_POST['valeur'][2][7]== '/'))
                   echo "<p><a href='".$_POST['valeur'][2]."'>".$_POST['valeur'][2]."</a></p>";
           }
           ?>
           <br />
           
           <strong>Choisissez la période de diffusion de ce contenu :</strong>
           <br /><br />
           du : 
           <?php
                if($_POST['valeur'][0])
                {
                    echo '<input type="text" class="datepicker" name="date_debut" value="'.$_POST['valeur'][4].'" required>'
                         .'<input name="dateDebut0" value="'.$_POST['valeur'][4].'" hidden>';
                    
                }
                else
                    echo '<input type="text" class="datepicker" name="date_debut" required>' ;
            ?>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           au : 
           <?php
                if($_POST['valeur'][0])
                {
                    echo '<input type="text" class="datepicker" name="date_fin" value="'.$_POST['valeur'][5].'" required>'
                         .'<input name="dateFin0" value="'.$_POST['valeur'][5].'" hidden>';
                    
                }
                else
                    echo ' <input type="text" class="datepicker" name="date_fin" required>' ;
            ?>
           <br /><br /><br />
           
           <strong>Choisissez les enfants qui auront accès à ce contenu :</strong>
           </br></br>
           <?php
            $nbre_enfant = 0;
                foreach($children as $child)
                    {
                        //print_r($_POST);
                        $nbre_enfant++;
                        $check = '';
                        foreach ($_POST['mail'] as $post_mail)
                        {
                            
                            if($child->getEmail()== $post_mail)
                            {
                                $check = 'checked';
                            }
                        }
                        echo ' <p><input type="checkbox" name="child[]" id="checkbox'.$nbre_enfant.'" value="'.$child->getEmail().'" '.$check.'>&nbsp;&nbsp;'
                                    .$child->getFirstname().'&nbsp;'.$child->getLastname(). '</p>' ;
                    }
            ?>
           <br /><br /><br />
           
           <button id="submit" class="btn btn-default" name="Valider" value="Valider" >Valider</button>
       </div>
   </p>
</form>
    <div style="margin-bottom: 70px;">
        <form class="formB" action="adultShowContents.php" style=" margin: -44px 0px 0px 180px;">
            <button type="submit" class="btn btn-default" name="Annuler" onclick >Annuler</button>
        </form>
    </div>
    
    
    
    <?php include 'footer.php' ?>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>  
    <script src="js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>
            $( document ).ready(function() {
                $(".datepicker" ).datepicker();
            }); 
            
    </script>
    <script>
        function testcheck(nbr_enfant)
        {
            $test=false;
            for ($i=1; $i<=nbr_enfant; $i++)
            {
                $choix=document.getElementById('checkbox'+$i).checked;
                
                if ($choix==true)
                {
                  $test=true;
                  
                }
           }
           if ($test==true)
           {
                document.getElementById('form1').submit();
                return true;
           }else{
                alert("Choisissez au moins 1 enfant !");
                return false;
                
           }
        }
        
       $(document).ready(function() {
            $("ul li a").click(function() {
                text = $(this).parent('.dropdown-toggle').html($(this).text()+' <span class="caret"></span>').text();
                
                text2 = $(this).parents('.dropdown').find('.dropdown-toggle').html($(this).text()+' <span class="caret"></span>').text();
                $(this).parents(".dropdown").find('.Behave').val(text2);
                
                if(text2.indexOf('.PNG')>-1)
                {
                    console.log("c'est un diapo !");console.log(text2.indexOf('.PNG'));
                    $(this).parents(".dropdown").find('.Slide').val(text2);
                }
                else
                {
                    console.log("ce n'est pas un diapo :D");
                    //changer l'image ici !!!
                }
                if($(this).parents(".dropdown").find('.img_associee')){console.log( $(this).parents(".dropdown").find('.img_associee'));}
                $(this).parents(".dropdown").find('.img_associee').attr('src', 'img/raconte.png');
                //if($(this).parents(".dropdown").find('.img_associee').is(Image)){console.log(true);}else{console.log(false);}
            /*    console.log($(this).parents(".dropdown").find('.img_associee'));
                console.log(typeof ($(this).parents(".dropdown").find('.img_associee')));
                console.dir($(this).parents(".dropdown").find('.img_associee'));
               $(this).parents(".dropdown").find('.img_associee').html('swamp_behave&nbsp;<img src="img/raconte.png" style="height: 100px; float: right;">');*/
               //img.src = "img/raconte.png";
                              //$("input[name='Behave[]']").val(text2);
              //  $("input[name='enfantExistant']").val(text);
                $(this).parents('.dropdown').find('.dropdown-toggle').html($(this).text()+' <span class="caret"></span>');
                $(this).parents(".dropdown").find('.btn').val($(this).data('value'));
                
            });
        });

        $(".dropdown-menu li a").click(function(){
            //$(this+":first-child").html($(this).text()+' <span class="caret"></span>');
            $(this).parent('.dropdown-toggle').html($(this).text()+' <span class="caret"></span>');
        });
        
       $(document).ready(function(){
            $(".dropdown-toggle").dropdown();
        });
    </script>
    <script>
	$(document).ready(function(e) {
        $(".dropdown-menu > li > a").on("click", function(){
			var image = $(this).children('img').attr('src');
			
			$(this).parents('.dropdown').children('img.img_associee').attr('src', image);
		});
    });
</script>

</body>
</html>
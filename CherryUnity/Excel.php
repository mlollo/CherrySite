<?php
// Désactiver le rapport d'erreurs
    error_reporting(0);
    session_start();
    ?>
<html>
<head>
    <meta charset="utf8">
    <title>Ajout d'un excel de description de scénario</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script type='text/javascript' src='script.js'></script>
    <script type="text/javascript" src="js/bootstrap-filestyle.min.js"> </script>
    <?php 
        $root = "./";
        
        include 'head.php' ;
        require "includes.php";
        
        
        
    ?>
    
    <style type="text/css">
        .btn-file {
        position: relative;
        overflow: hidden;
        }
        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }
    </style>
</head>

<body>
    <?php include 'nav.php' ;
    include 'includes.php'; 
    
    $childDao = new ChildDAO(LocalDBClientBuilder::get());
    $children = $childDao->getChildren($_SESSION['email']);
        
    $nbre_enfant = 0;
    foreach($children as $child)
    {
        $nbre_enfant++;
    }
    ?>
     <br/>
     <h1 style="margin-left: 27px; margin-bottom: 30px;">Ajouter un document Excel pour créer une description d'un scénario</h1>
     <form class="form1" method="POST" action="ExcelValider.php" enctype="multipart/form-data" style="margin-left: 20px;" <?php echo 'onsubmit="return testcheck('.$nbre_enfant.')"'; ?>>
        <div class="input-group" style="margin-bottom: 20px;">
                <span class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                        Choisissez un fichier &hellip; <input type="file" name="avatar" multiple required>
                    </span>
                </span>
                <input type="text" class="form-control" readonly style="width: 500px;">
        </div>
         <strong>Choisissez la période de diffusion de ce contenu :</strong>
           <br /><br />
           du : 
           <input type="text" class="datepicker" name="date_debut" required>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           au : 
           <input type="text" class="datepicker" name="date_fin" required>
           <br /><br /><br />
           
           <strong>Choisissez les enfants qui auront accès à ce contenu :</strong>
           </br></br>
           <?php
            $nbre_enfant = 0;
                foreach($children as $child)
                    {
                    //print_r($_POST);
                        $nbre_enfant++;
                        if($child->getEmail()== $_POST['valeur'][4])
                        {
                            echo ' <p> <input type="checkbox" name="child[]" id="checkbox'.$nbre_enfant.'" value="'.$child->getEmail().'" checked>&nbsp;&nbsp;'. 
                            $child->getFirstname().'&nbsp;'.$child->getLastname(). '</p>' ;
                        }
                        else
                            echo ' <p> <input type="checkbox" name="child[]" id="checkbox'.$nbre_enfant.'" value="'.$child->getEmail().'">&nbsp;&nbsp;'. 
                            $child->getFirstname().'&nbsp;'.$child->getLastname(). '</p>' ;
                        
                    }
            ?>
           <br /><br /><br />
        <button id="submit" class="btn btn-success" name="Valider" value="Valider" >Valider</button>
   </form>
     
     <br/><br/><a href="adultShowContents.php" style="margin-left: 20px;">Revenir à la page de Gestion de contenus</a>
     
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>  
    <script src="js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript">
     $(document).on('change', '.btn-file :file', function() {
    var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
      });

      $(document).ready( function() {
          $('.btn-file :file').on('fileselect', function(event, numFiles, label) {

              var input = $(this).parents('.input-group').find(':text'),
                  log = numFiles > 1 ? numFiles + ' files selected' : label;

              if( input.length ) {
                  input.val(log);
              } else {
                  if( log ) alert(log);
              }

          });
      });
      
      
      $( document ).ready(function() {
                $(".datepicker" ).datepicker();
            }); 
            
            
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
     </script>
     
     
</body>

<footer class="footer">
            <div class="container-fluid">
                <img  height="60px" src="img/logo.jpg"/> 
            </div>
        </footer>
</html>

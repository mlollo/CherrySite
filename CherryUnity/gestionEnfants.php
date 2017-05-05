<?php

    error_reporting(0);
    session_start();
    
    //print_r($_POST);
       
?>
<html>
<head>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gérer les Enfants</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script type='text/javascript' src='script.js'></script>
    <script type="text/javascript" src="js/bootstrap-filestyle.min.js"> </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="sortable/bootstrap-table.css">
    <script src="sortable/bootstrap-table.js"></script>
    <script src="sortable/ga.js"></script>
    
    <?php 
        $root = "./";
        
        include 'head.php' ;
        require "includes.php";
    ?>

</head>

<body>
    <?php include 'nav.php' ;
        include 'includes.php';
    
        //print_r($_GET);
    
        if($_GET['child'])
            $les_enfants = $_GET['child'];
        else
        {
            $les_enfants = array();
            $childDao0 = new ChildDAO(LocalDBClientBuilder::get());
            $children0 = $childDao0->getChildren($_SESSION['email']);
            foreach($children0 as $child)
            {
                $les_enfants[]= $child->getFirstname().'___'.$child->getLastname();
            }

        }
        //print_r($les_enfants);
        
        
        
     ?>
    
    <div class="container">
        <?php
            if((strpos($_POST['enfantExistant'], "Choix d'un Enfant existant") !== FALSE) 
                    || (strpos($_POST['enfantExistant'], "ensemble des enfants existant") !== FALSE) )
            {
                echo "<h4 style=' margin: 15px 0 26px 70px; font-style: italic;'>Vous n'avez pas ajouté d'enfant à votre liste.</h4>";
            }
            else if($_POST['enfantExistant'] != "")
            {
                //recupere l'enfant en question
                $childDao = new ChildDAO(LocalDBClientBuilder::get());
                $children = $childDao->getALLChildren();
                            
                foreach($children as $child)
                {
                    if(strpos($child->getType(), "child")!==FALSE)
                    {
                        if(strpos($_POST['enfantExistant'], $child->getFirstname()) !==false)
                            {
                                if(strpos($_POST['enfantExistant'], $child->getLastname()) !==false)
                                {
                                    //change l'id
                                    //si c'est un medecin
                                    if($_SESSION['type']=="doctor")
                                    {
                                        //si le doctor n'est pas celui de l'enfant
                                        if($child->getDoctorId() != $_SESSION['email'])
                                        {
                                            //test : OK, echo $child->getDoctorId();
                                            //change l'id du proprio
                                            $child->setDoctorId($_SESSION['email']);
                                            
                                            $client = LocalDBClientBuilder::get();
                                            $response = $client->updateItem(array(
                                                'TableName' => 'Users',
                                                'Key' => array(
                                                        'email' => array('S' => $child->getEmail())
                                                    ),
                                                'ExpressionAttributeNames' => [
                                                    '#NA' => 'doctorId'
                                                ],
                                                'ExpressionAttributeValues' =>  [
                                                    ':val1' => array('S' => $child->getDoctorId())
                                                ] ,
                                                'UpdateExpression' => 'set #NA = :val1 '
                                                ));
                                            
                                            //ajoute a l'affichage
                                            $les_enfants[]= $child->getFirstname().'___'.$child->getLastname();
                                        }
                                    }
                                    else if($_SESSION['type']=="teacher")
                                    {
                                        //si le doctor n'est pas celui de l'enfant
                                        if($child->getTeacherId() != $_SESSION['email'])
                                        {
                                            //test : OK, echo $child->getDoctorId();
                                            //change l'id du proprio
                                            $child->setTeacherId($_SESSION['email']);
                                            
                                            $client = LocalDBClientBuilder::get();
                                            $response = $client->updateItem(array(
                                                'TableName' => 'Users',
                                                'Key' => array(
                                                        'email' => array('S' => $child->getEmail())
                                                    ),
                                                'ExpressionAttributeNames' => [
                                                    '#NA' => 'teacherId'
                                                ],
                                                'ExpressionAttributeValues' =>  [
                                                    ':val1' => array('S' => $child->getTeacherId())
                                                ] ,
                                                'UpdateExpression' => 'set #NA = :val1 '
                                                ));
                                            
                                            //ajoute a l'affichage
                                            $les_enfants[]= $child->getFirstname().'___'.$child->getLastname();
                                        }
                                    }
                                    else if($_SESSION['type']=="family")
                                    {
                                        //si le doctor n'est pas celui de l'enfant
                                        if($child->getFamilyId() != $_SESSION['email'])
                                        {
                                            //test : OK, echo $child->getDoctorId();
                                            //change l'id du proprio
                                            $child->setFamilyId($_SESSION['email']);
                                            
                                            $client = LocalDBClientBuilder::get();
                                            $response = $client->updateItem(array(
                                                'TableName' => 'Users',
                                                'Key' => array(
                                                        'email' => array('S' => $child->getEmail())
                                                    ),
                                                'ExpressionAttributeNames' => [
                                                    '#NA' => 'familyId'
                                                ],
                                                'ExpressionAttributeValues' =>  [
                                                    ':val1' => array('S' => $child->getFamilyId())
                                                ] ,
                                                'UpdateExpression' => 'set #NA = :val1 '
                                                ));
                                            
                                            //ajoute a l'affichage
                                            $les_enfants[]= $child->getFirstname().'___'.$child->getLastname();
                                        }
                                    }
                                }
                            }
                    }
                }
                echo "<h4 style=' margin: 15px 0 26px 70px; font-style: italic;'>".$_POST['enfantExistant']." a été ajouté à votre liste.</h4>";
            }
            else if($_POST['nom']!= "")
            {
                $array['email'] = array('S' => $_POST['mail']);
                $array['password'] = array('S' => $_POST['password']);
                $array['lastname'] = array('S' => $_POST['prenom']);
                $array['firstname'] = array('S' => $_POST['nom']);
                $array['type'] = array('S' => "child");
                if(!$_POST['MAJ'])
                {
                    if($_SESSION['type']=="doctor")
                    {
                        $teacher = $_POST['teacher'];
                        $family = $_POST['family'];
                        $doctor = $_SESSION['email'];
                    }
                    else if($_SESSION['type']=="teacher")
                    {
                        $teacher = $_SESSION['email'];
                        $family = $_POST['family'];
                        $doctor = $_POST['doctor'];
                    }
                    else if($_SESSION['type']=="family")
                    {
                        $teacher = $_POST['teacher'];
                        $family = $_SESSION['email'];
                        $doctor = $_POST['doctor'];
                    }
                    $array['teacherId'] = array('S' => $teacher);
                    $array['familyId'] = array('S' => $family);
                    $array['doctorId'] = array('S' => $doctor);
                }
                
                $client = LocalDBClientBuilder::get();

                $response = $client->getItem(array(
                'TableName' => 'Users',
                    'Key' => array(
                        'email' => array('S' => $_POST['mail'])
                    )
                ));
                

                if ((empty($response) || empty($response['Item']))) 
                {
                    if(!$_POST['MAJ'])
                    {
                    $client->putItem(array(
                        'TableName' => 'Users',
                        'Item' => $array
                    ));
                    echo "<h4 style=' margin: 15px 0 26px 70px; font-style: italic;'>".$_POST['nom']." ".$_POST['prenom']." a été créé et ajouté à votre liste.</h4>";
                    
                    //ajoute a l'affichage de la liste
                    $les_enfants[]= $_POST['nom'].'___'.$_POST['prenom'];
                    }
                    else
                    {
                        //MODIFICATION D'UN ENFANT (avec modification de l'e-mail):
                        //creation d'un nouvel enfant
                        if($_SESSION['type']=="doctor")
                        {
                            $array['doctorId'] = array('S' => $doctor);
                        }
                        else if($_SESSION['type']=="teacher")
                        {
                            $array['teacherId'] = array('S' => $teacher);
                        }
                        else if($_SESSION['type']=="family")
                        {
                            $array['familyId'] = array('S' => $family);
                        }
                        
                        $client = LocalDBClientBuilder::get();
                        $client->putItem(array(
                        'TableName' => 'Users',
                        'Item' => $array
                        ));
                        echo "<h4 style=' margin: 15px 0 26px 70px; font-style: italic;'>les informations de ".$_POST['nom']." ".$_POST['prenom']." ont étés modifiées.</h4>";

                        //ajoute a l'affichage de la liste
                        $les_enfants[]= $_POST['nom'].'___'.$_POST['prenom'];
                        
                        //et supprime l'ancien de la liste
                        //...mail_modif
                        //recupere l'enfant en question
                        $childDao = new ChildDAO(LocalDBClientBuilder::get());
                        $children = $childDao->getALLChildren();

                        foreach($children as $child)
                        {
                            if(strpos($child->getType(), "child")!==FALSE)
                            {
                                if($_POST['mail_modif']== $child->getEmail())
                                    {
                                        //change l'id
                                        //si c'est un medecin
                                        if($_SESSION['type']=="doctor")
                                        {
                                            //si le doctor n'est pas celui de l'enfant
                                            if($child->getDoctorId() == $_SESSION['email'])
                                            {
                                                //test : OK, echo $child->getDoctorId();
                                                //change l'id du proprio
                                                $child->setDoctorId("sans_mail");

                                                $client = LocalDBClientBuilder::get();
                                                $response = $client->updateItem(array(
                                                    'TableName' => 'Users',
                                                    'Key' => array(
                                                        'email' => array('S' => $child->getEmail())
                                                    ),
                                                    'ExpressionAttributeNames' => [
                                                        '#NA' => 'doctorId'
                                                    ],
                                                    'ExpressionAttributeValues' =>  [
                                                        ':val1' => array('S' => $child->getDoctorId())
                                                    ] ,
                                                    'UpdateExpression' => 'set #NA = :val1 '
                                                ));

                                                //retire a l'affichage
                                                $key = array_search($child->getFirstname().'___'.$child->getLastname(), $les_enfants);
                                                $tab_temp = array();
                                                for($k=0; $k<count($les_enfants); $k++)
                                                {
                                                    if($k != $key)
                                                        $tab_temp[] = $les_enfants[$k];
                                                }
                                                $les_enfants=$tab_temp;
                                                }
                                        }
                                        else if($_SESSION['type']=="teacher")
                                        {
                                            //si le doctor n'est pas celui de l'enfant
                                            if($child->getTeacherId() == $_SESSION['email'])
                                            {
                                                //test : OK, echo $child->getDoctorId();
                                                //change l'id du proprio
                                                $child->setTeacherId("sans_mail");

                                                $client = LocalDBClientBuilder::get();
                                                $response = $client->updateItem(array(
                                                    'TableName' => 'Users',
                                                    'Key' => array(
                                                        'email' => array('S' => $child->getEmail())
                                                    ),
                                                    'ExpressionAttributeNames' => [
                                                        '#NA' => 'teacherId'
                                                    ],
                                                    'ExpressionAttributeValues' =>  [
                                                        ':val1' => array('S' => $child->getTeacherId())
                                                    ] ,
                                                    'UpdateExpression' => 'set #NA = :val1 '
                                                ));

                                                //retire a l'affichage
                                                $key = array_search($child->getFirstname().'___'.$child->getLastname(), $les_enfants);
                                                $tab_temp = array();
                                                for($k=0; $k<count($les_enfants); $k++)
                                                {
                                                    if($k != $key)
                                                        $tab_temp[] = $les_enfants[$k];
                                                }
                                                $les_enfants=$tab_temp;
                                            }
                                        }
                                        else if($_SESSION['type']=="family")
                                        {
                                            //si le doctor n'est pas celui de l'enfant
                                            if($child->getFamilyId() == $_SESSION['email'])
                                            {
                                                //test : OK, echo $child->getDoctorId();
                                                //change l'id du proprio
                                                $child->setFamilyId("sans_mail");

                                                $client = LocalDBClientBuilder::get();
                                                $response = $client->updateItem(array(
                                                    'TableName' => 'Users',
                                                    'Key' => array(
                                                        'email' => array('S' => $child->getEmail())
                                                    ),
                                                    'ExpressionAttributeNames' => [
                                                        '#NA' => 'familyId'
                                                    ],
                                                    'ExpressionAttributeValues' =>  [
                                                        ':val1' => array('S' => $child->getFamilyId())
                                                    ] ,
                                                    'UpdateExpression' => 'set #NA = :val1 '
                                                ));

                                                //retire a l'affichage
                                                $key = array_search($child->getFirstname().'___'.$child->getLastname(), $les_enfants);
                                                $tab_temp = array();
                                                for($k=0; $k<count($les_enfants); $k++)
                                                {
                                                    if($k != $key)
                                                        $tab_temp[] = $les_enfants[$k];
                                                }
                                                $les_enfants=$tab_temp;
                                                }
                                        }
                                    }
                            }
                        }
                        
                    }
                } 
                else 
                {
                    if(!$_POST['MAJ'])
                        echo "<h4 style=' margin: 15px 0 26px 70px; font-style: italic;'>".$_POST['nom']." ".$_POST['prenom']." n'a pas été créé car il y a déjà un enfant possédant cet e-mail.</h4>";
                    else if($_POST["Enregistrer"])
                    {
                        //MODIFICATION D'UN ENFANT (sans modification de l'e-mail):     
                        //MAJ prenom
                        $client = LocalDBClientBuilder::get();
                        $response = $client->updateItem(array(
                            'TableName' => 'Users',
                            'Key' => array(
                                'email' => array('S' => $_POST['mail'])
                            ),
                            'ExpressionAttributeNames' => [
                                '#NA' => 'lastname'
                            ],
                            'ExpressionAttributeValues' =>  [
                                ':val1' => array('S' => $_POST['prenom'])
                            ] ,
                            'UpdateExpression' => 'set #NA = :val1 '
                        ));
                        //MAJ nom
                        $client = LocalDBClientBuilder::get();
                        $response1 = $client->updateItem(array(
                            'TableName' => 'Users',
                            'Key' => array(
                                'email' => array('S' => $_POST['mail'])
                            ),
                            'ExpressionAttributeNames' => [
                                '#NA' => 'firstname'
                            ],
                            'ExpressionAttributeValues' =>  [
                                ':val1' => array('S' => $_POST['nom'])
                            ] ,
                            'UpdateExpression' => 'set #NA = :val1 '
                        ));
                        //MAJ mot de passe
                        $client = LocalDBClientBuilder::get();
                        $response2 = $client->updateItem(array(
                            'TableName' => 'Users',
                            'Key' => array(
                                'email' => array('S' => $_POST['mail'])
                            ),
                            'ExpressionAttributeNames' => [
                                '#NA' => 'password'
                            ],
                            'ExpressionAttributeValues' =>  [
                                ':val1' => array('S' => $_POST['password'])
                            ] ,
                            'UpdateExpression' => 'set #NA = :val1 '
                        ));
                        
                        echo "<h4 style=' margin: 15px 0 26px 70px; font-style: italic;'>".$_POST['nom']." ".$_POST['prenom']." a été modifié.</h4>";
                    }
                    else if($_POST['Supp'])
                    {
                        $childDao = new ChildDAO(LocalDBClientBuilder::get());
                        $children = $childDao->getALLChildren();

                        foreach($children as $child)
                        {
                            if(strpos($child->getType(), "child")!==FALSE)
                            {
                                if($_POST['mail_modif']== $child->getEmail())
                                    {
                                        //change l'id
                                        //si c'est un medecin
                                        if($_SESSION['type']=="doctor")
                                        {
                                            //si le doctor n'est pas celui de l'enfant
                                            if($child->getDoctorId() == $_SESSION['email'])
                                            {
                                                //test : OK, echo $child->getDoctorId();
                                                //change l'id du proprio
                                                $child->setDoctorId("sans_mail");

                                                $client = LocalDBClientBuilder::get();
                                                $response = $client->updateItem(array(
                                                    'TableName' => 'Users',
                                                    'Key' => array(
                                                        'email' => array('S' => $child->getEmail())
                                                    ),
                                                    'ExpressionAttributeNames' => [
                                                        '#NA' => 'doctorId'
                                                    ],
                                                    'ExpressionAttributeValues' =>  [
                                                        ':val1' => array('S' => $child->getDoctorId())
                                                    ] ,
                                                    'UpdateExpression' => 'set #NA = :val1 '
                                                ));
                                            }
                                            //retire a l'affichage
                                            $key = array_search($child->getFirstname().'___'.$child->getLastname(), $les_enfants);
                                            $tab_temp = array();
                                            for($k=0; $k<count($les_enfants); $k++)
                                            {
                                                if($k != $key)
                                                    $tab_temp[] = $les_enfants[$k];
                                            }
                                            $les_enfants=$tab_temp;
                                        }
                                        else if($_SESSION['type']=="teacher")
                                        {
                                            //si le doctor n'est pas celui de l'enfant
                                            if($child->getTeacherId() == $_SESSION['email'])
                                            {
                                                //test : OK, echo $child->getDoctorId();
                                                //change l'id du proprio
                                                $child->setTeacherId("sans_mail");

                                                $client = LocalDBClientBuilder::get();
                                                $response = $client->updateItem(array(
                                                    'TableName' => 'Users',
                                                    'Key' => array(
                                                        'email' => array('S' => $child->getEmail())
                                                    ),
                                                    'ExpressionAttributeNames' => [
                                                        '#NA' => 'teacherId'
                                                    ],
                                                    'ExpressionAttributeValues' =>  [
                                                        ':val1' => array('S' => $child->getTeacherId())
                                                    ] ,
                                                    'UpdateExpression' => 'set #NA = :val1 '
                                                ));
                                            }
                                            //retire a l'affichage
                                            $key = array_search($child->getFirstname().'___'.$child->getLastname(), $les_enfants);
                                            $tab_temp = array();
                                            for($k=0; $k<count($les_enfants); $k++)
                                            {
                                                if($k != $key)
                                                    $tab_temp[] = $les_enfants[$k];
                                            }
                                            $les_enfants=$tab_temp;
                                        }
                                        else if($_SESSION['type']=="family")
                                        {
                                            //si le doctor n'est pas celui de l'enfant
                                            if($child->getFamilyId() == $_SESSION['email'])
                                            {
                                                //test : OK, echo $child->getDoctorId();
                                                //change l'id du proprio
                                                $child->setFamilyId("sans_mail");

                                                $client = LocalDBClientBuilder::get();
                                                $response = $client->updateItem(array(
                                                    'TableName' => 'Users',
                                                    'Key' => array(
                                                        'email' => array('S' => $child->getEmail())
                                                    ),
                                                    'ExpressionAttributeNames' => [
                                                        '#NA' => 'familyId'
                                                    ],
                                                    'ExpressionAttributeValues' =>  [
                                                        ':val1' => array('S' => $child->getFamilyId())
                                                    ] ,
                                                    'UpdateExpression' => 'set #NA = :val1 '
                                                ));
                                            }
                                            //retire a l'affichage
                                            $key = array_search($child->getFirstname().'___'.$child->getLastname(), $les_enfants);
                                            $tab_temp = array();
                                            for($k=0; $k<count($les_enfants); $k++)
                                            {
                                                if($k != $key)
                                                    $tab_temp[] = $les_enfants[$k];
                                            }
                                            $les_enfants=$tab_temp;
                                        }
                                    }
                            }
                        }
                        
                        echo "<h4 style=' margin: 15px 0 26px 70px; font-style: italic;'>".$_POST['nom']." ".$_POST['prenom']." a été retiré de votre liste.</h4>";
                    }
                }
                
                
            }
            
        ?>
        <button type="button" class="btn btn-success" data-toggle="collapse" data-target="#demo">
            <span class="glyphicon glyphicon-plus-sign" style="margin-right: 10px;"></span>Ajouter un enfant</button>
        <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">
            <span class="glyphicon glyphicon-list-alt" style="margin-right: 10px;"></span>Créer un groupe d'enfant</button>
        <div id="demo" class="collapse">
          <div class="row" style="background-color: gainsboro; margin-left: 1px;">
              <div class="col-sm-5">
                  <!-- Choix d'un enfant existant sur la BDD -->
                  <form class='formB' action='gestionEnfants.php' method="POST" style="    margin: 10px 0 0 0;">
                      <input type="hidden" name="enfantExistant">
                    <div class="dropdown">
                      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="margin: 10px 0 0 0;">Choix d'un Enfant existant
                      <span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li value="ChoixEnfant"><a href="#">Choix d'un Enfant existant&nbsp;</a></li>
                        <li class="divider"></li>
                        <?php
                            $childDao = new ChildDAO(LocalDBClientBuilder::get());
                            $children = $childDao->getALLChildren();
                            
                            foreach($children as $child)
                            {
                                //print_r($child);
                                //echo $child->getFirstname()."<br/>";
                                $type = $child->getType();
                                if(strpos($child->getType(), "child")!==FALSE)
                                {
                                    $find = false;
                                    foreach($les_enfants as $un_enfant)
                                    {
                                        if(strpos($un_enfant, $child->getFirstname()) !==false)
                                        {
                                            if(strpos($un_enfant, $child->getLastname()) !==false)
                                                    $find = true;
                                        }
                                    }
                                    if($find == false)
                                        $list_children[] = $child->getFirstname().'&nbsp;'.$child->getLastname();
                                }
                            }
                            
                            //print_r($list_children);
                            if(count($list_children)== 0)
                                echo '<li value="pas_d_enfant"><a href="#">Vous gérez l\'ensemble des enfants existant !</a></li>';
                            for($e=0; $e<count($list_children); $e++)
                            {
                                echo '<li value="'.$list_children[$e].'"><a href="#">'.$list_children[$e].'</a></li>';
                            }
                        ?>
                      </ul>
                    </div>
                        <button type='submit' class='btn btn-success' name="Enregistrer" onclick style="margin: 10px 10px 10px 0; "><span class='glyphicon glyphicon-floppy-saved' style='margin-right: 7px;'></span>Enregistrer</button>
                  </form>
              </div>
              <div class="col-sm-1"><h4 style="margin-top: 20px;">OU</h4></div>
              <div class="col-sm-6">
                  <!-- Creation d'un nouvel enfant -->
                  <form class='formB' action='gestionEnfants.php' method="POST" style="    margin: 10px 0 0 0;" onsubmit="return verif_champs();">
                        <label for="nom">Nom de l'enfant :</label>
                        <input name="nom" class="form-control" id="nom">
                        <label for="prenom">Prénom de l'enfant :</label>
                        <input name="prenom" class="form-control" id="prenom">
                        <label for="mail">E-mail de l'enfant :</label>
                        <input name="mail" class="form-control" id="mail">
                        <label for="password">Mot de passe de l'enfant :</label>
                        <input name="password" type='password' class="form-control" id="password">
                        <label for="repassword">Confirmer le mot de passe de l'enfant :</label>
                        <input name="repassword" type='password' class="form-control" id="repassword">
                        <?php
                        //ajoute les champ en fonction du type
                        if($_SESSION['type']=="doctor")
                        {
                            echo '<label for="teacher">E-mail de l\'enseignant lié à l\'enfant :</label>'
                            . '<input name="teacher" class="form-control" id="teacher">'
                            . '<label for="family">E-mail de la famille liée à l\'enfant :</label>'
                            . '<input name="family" class="form-control" id="family">';
                        }
                        else if($_SESSION['type'] == 'teacher')
                        {
                            echo '<label for="doctor">E-mail du médecin lié à l\'enfant :</label>'
                            . '<input name="doctor" class="form-control" id="doctor">'
                            . '<label for="family">E-mail de la famille liée à l\'enfant :</label>'
                            . '<input name="family" class="form-control" id="family">';
                        }
                        else if($_SESSION['type'] == 'family')
                        {
                            echo '<label for="doctor">E-mail du médecin lié à l\'enfant :</label>'
                            . '<input type="doctor" class="form-control" id="doctor">'
                            . '<label for="teacher">E-mail de l\'enseignant lié à l\'enfant :</label>'
                            . '<input type="teacher" class="form-control" id="teacher">';
                        }
                        ?>

                        <button type='submit' class='btn btn-success' name='Enregistrer' onclick style="margin: 10px 10px 10px 15px; float: right;"><span class='glyphicon glyphicon-floppy-saved' style='margin-right: 7px;'></span>Enregistrer</button>
                    </form>
              </div>
          </div>
        </div>
        
        <h1>Liste des Enfants</h1>  
         <!--class="table table-hover sortable"-->
        <table class="table table-hover sortable"  data-toggle="table"
               data-height="460"
               data-url="sortable/data1.json"
               data-sort-name="price"
               data-sort-order="desc">
          <thead>
            <tr>
              <th data-field="name" data-sortable="true">Nom</th>
              <th>Prénom</th>
              <th>Modification</th>
            </tr>
          </thead>
          <tbody>
            <?php
                $nbr_enf = 0;
                 foreach ($les_enfants as $nom_pre)
                 {
                     $nbr_enf++;
                    $tab_nom_pre = explode('___', $nom_pre);
                    
                    //recherche les infos de l'enfant
                    $childDao = new ChildDAO(LocalDBClientBuilder::get());
                    $children = $childDao->getALLChildren();                           
                    foreach($children as $child)
                    {
                        if(strpos($tab_nom_pre[0], $child->getFirstname()) !==false)
                        {
                            if(strpos($tab_nom_pre[1], $child->getLastname()) !==false)
                            {
                                $theChild = $child;
                            }
                        }
                    }
                    
                    echo "<tr>
                    <td>".$tab_nom_pre[0]."</td>
                    <td>".$tab_nom_pre[1]."</td>
                    <td>
                    <form class='formB' action='gestionEnfants.php' method='POST' onsubmit='return m_verif_champs();'>
                    <button type='button' class='btn btn-primary' data-toggle='collapse' data-target='#demo2".$nbr_enf."'>
                        <span class='glyphicon glyphicon-pencil' style='margin-right: 10px;'></span>Modifier</button>
                    <div id='demo2".$nbr_enf."' class='collapse' style=' background-color: gainsboro; padding: 10px; margin-bottom: 10px;'>
                        <input name='mail_modif' value='".$theChild->getEmail()."' hidden>
                        <input name='MAJ' value='MAJ' hidden>
                        <label for='nom'>Nom de l'enfant :</label>
                        <input name='nom' class='form-control' id='m_nom' value='".$tab_nom_pre[0]."'>
                        <label for='prenom'>Prénom de l'enfant :</label>
                        <input name='prenom' class='form-control' id='m_prenom' value='".$tab_nom_pre[1]."'>
                        <label for='mail'>E-mail de l'enfant :</label>
                        <input name='mail' class='form-control' id='m_mail' value='".$theChild->getEmail()."'>
                        <label for='password'>Mot de passe de l'enfant :</label>
                        <input name='password' type='password' class='form-control' id='m_password' value='".$theChild->getPassword()."'>
                        <label for='repassword'>Confirmer le mot de passe de l'enfant :</label>
                        <input name='repassword' type='password' class='form-control' id='m_repassword' value='".$theChild->getPassword()."'>
                        <br/><br/>
                        <button type='submit' class='btn btn-success' name='Enregistrer' value='Enregistrer' onclick ><span class='glyphicon glyphicon-floppy-saved' style='margin-right: 7px;'></span>Enregistrer</button>
                    </div>
                    <button type='submit' class='btn btn-danger' name='Supp' value='Supp' onclick ><span class='glyphicon glyphicon-remove'  style='margin-right: 7px;'></span>Supprimer</button> 
                    </form></td>
                    </tr>";
                 }
            
            ?>
          </tbody>
        </table>
      </div>


    
</body>

<footer class="footer">
            <div class="container-fluid">
                <img  height="60px" src="img/logo.jpg"/> 
            </div>
        </footer>

<script type="text/javascript">
         $(".dropdown-menu li a").click(function(){
            $(".dropdown-toggle:first-child").html($(this).text()+' <span class="caret"></span>');
        });
        
        $(document).ready(function() {
            $("ul li a").click(function() {
                text = $(".dropdown-toggle:first-child").html($(this).text()+' <span class="caret"></span>').text();
                $("input[name='enfantExistant']").val(text);
                $(this).parents('.dropdown').find('.dropdown-toggle').html(text+' <span class="caret"></span>');
                
            });
        });
        
        
        function verif_champs(){
            //fonction javascript qui va verifier successivement tous les champs et si pas rempli mesage d'alert et empèche le fomrulaire d'être envoyé
                    //pour les listes déroulantes dont le choix est obligatoire:
            //type client
            var nom=document.getElementById('nom'); //on atteint l'element par son id
            if(nom.value==""){
                    //si value = vide qui correspond à "Choisissez dans la liste déroulante"
                    alert ('L\'enfant doit posséder un nom pour être ajouté à votre liste  !');
                    return false; //on sort de la fonction et on empeche l'envoi du formulaire
            }
            
            var prenom=document.getElementById('prenom'); //on atteint l'element par son id
            if(prenom.value==""){
                    //si value = vide qui correspond à "Choisissez dans la liste déroulante"
                    alert ('L\'enfant doit posséder un prénom pour être ajouté à votre liste  !');
                    return false; //on sort de la fonction et on empeche l'envoi du formulaire
            }
            
            var mail=document.getElementById('mail'); //on atteint l'element par son id
            if(mail.value==""){
                    //si value = vide qui correspond à "Choisissez dans la liste déroulante"
                    alert ('L\'enfant doit posséder un e-mail pour être ajouté à votre liste  !');
                    return false; //on sort de la fonction et on empeche l'envoi du formulaire
            }
            
            var password=document.getElementById('password'); //on atteint l'element par son id
            if(password.value==""){
                    //si value = vide qui correspond à "Choisissez dans la liste déroulante"
                    alert ('L\'enfant doit posséder un mot de passe pour être ajouté à votre liste  !');
                    return false; //on sort de la fonction et on empeche l'envoi du formulaire
            }
            
            var repassword=document.getElementById('repassword'); //on atteint l'element par son id
            if(repassword.value!=password.value){
                    //si value = vide qui correspond à "Choisissez dans la liste déroulante"
                    alert ('Le mot de passe de l\'enfant doit être identique dans les 2 champs "Mot de passe" et "Confirmer le mot de passe" !');
                    return false; //on sort de la fonction et on empeche l'envoi du formulaire
            }
            
            var teacher=document.getElementById('teacher'); //on atteint l'element par son id
            if(teacher)
            {
                if(teacher.value==""){
                        //si value = vide qui correspond à "Choisissez dans la liste déroulante"
                        alert ('L\'enfant doit être lié à l\'e-mail d\'un professeur pour être ajouté à votre liste  !');
                        return false; //on sort de la fonction et on empeche l'envoi du formulaire
                }
            }
            
            var family=document.getElementById('family'); //on atteint l'element par son id
            if(family)
            {
                if(family.value==""){
                        //si value = vide qui correspond à "Choisissez dans la liste déroulante"
                        alert ('L\'enfant doit être lié à l\'e-mail d\'un membre de sa famille pour être ajouté à votre liste  !');
                        return false; //on sort de la fonction et on empeche l'envoi du formulaire
                }
            }
            
            var doctor=document.getElementById('doctor'); //on atteint l'element par son id
            if(doctor)
            {
                if(doctor.value==""){
                        //si value = vide qui correspond à "Choisissez dans la liste déroulante"
                        alert ('L\'enfant doit être lié à l\'e-mail d\'un médecin pour être ajouté à votre liste  !');
                        return false; //on sort de la fonction et on empeche l'envoi du formulaire
                }
            }
            
            //et si on est arrivé la c'est que tout est ok donc
            return true; 
        }
        
        function m_verif_champs(){
            //fonction javascript qui va verifier successivement tous les champs et si pas rempli mesage d'alert et empèche le fomrulaire d'être envoyé
                    //pour les listes déroulantes dont le choix est obligatoire:
            //type client
            var nom=document.getElementById('m_nom'); //on atteint l'element par son id
            if(nom.value==""){
                    //si value = vide qui correspond à "Choisissez dans la liste déroulante"
                    alert ('L\'enfant doit posséder un nom pour être ajouté à votre liste  !');
                    return false; //on sort de la fonction et on empeche l'envoi du formulaire
            }
            
            var prenom=document.getElementById('m_prenom'); //on atteint l'element par son id
            if(prenom.value==""){
                    //si value = vide qui correspond à "Choisissez dans la liste déroulante"
                    alert ('L\'enfant doit posséder un prénom pour être ajouté à votre liste  !');
                    return false; //on sort de la fonction et on empeche l'envoi du formulaire
            }
            
            var mail=document.getElementById('m_mail'); //on atteint l'element par son id
            if(mail.value==""){
                    //si value = vide qui correspond à "Choisissez dans la liste déroulante"
                    alert ('L\'enfant doit posséder un e-mail pour être ajouté à votre liste  !');
                    return false; //on sort de la fonction et on empeche l'envoi du formulaire
            }
            
            var password=document.getElementById('m_password'); //on atteint l'element par son id
            if(password.value==""){
                    //si value = vide qui correspond à "Choisissez dans la liste déroulante"
                    alert ('L\'enfant doit posséder un mot de passe pour être ajouté à votre liste  !');
                    return false; //on sort de la fonction et on empeche l'envoi du formulaire
            }
            
            var repassword=document.getElementById('m_repassword'); //on atteint l'element par son id
            if(repassword.value!=password.value){
                    //si value = vide qui correspond à "Choisissez dans la liste déroulante"
                    alert ('Le mot de passe de l\'enfant doit être identique dans les 2 champs "Mot de passe" et "Confirmer le mot de passe" !');
                    return false; //on sort de la fonction et on empeche l'envoi du formulaire
            }
            
            //et si on est arrivé la c'est que tout est ok donc
            return true; 
        }
        
</script>

</html>

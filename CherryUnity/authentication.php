<?php 
 // Désactiver le rapport d'erreurs
    error_reporting(0);
    session_start() ?>
<!doctype html>
<html>
<head>
    <?php include 'head.php' ?>
    <title>Inscription </title>
</head>

<body>
    <?php include 'nav.php' ?>

    <div class="container">
        <div class="row">
            <form role="form" id="userForm" method="post" action="handlers/authenticationHandler.php" class="col-md-3 col-md-offset-3">
                <div class="form-group">
                    <label class="control-label" for="firstname">Prénom </label>
                    <input id="firstname" name="firstname" class="form-control" placeholder="Entrez un prénom" type="text">
                </div>

                <div class="form-group">
                    <label class="control-label" for="lastname">Nom </label>
                    <input id="lastname" name="lastname" class="form-control" placeholder="Entrez un nom" type="text">
                </div>

                <div class="form-group">
                    <label class="control-label" for="email">Email</label>
                    <input id="email" name="email" class="form-control" placeholder="Entrez un email" type="email">
                </div>

                <div class="form-group">
                    <label class="control-label" for="password">Mot de passe</label>
                    <input id="password" name="password" class="form-control" placeholder="Entrez un mot de passe" type="password">
                </div>

                <div class="form-group">
                    <label class="control-label" for="confirm_password">Confirmer le mot de passe</label>
                    <input id="confirm_password" name="confirm_password" class="form-control"  placeholder="Entrez le meme mot de passe" type="password">
                </div>

                <div class="form-group">
                    <label class="control-label" for="type">Type </label>
                    <select id="type" name="type">
                        <option value="child" >Enfant</option>
                        <option value="teacher" selected>Enseignant</option>
                        <option value="doctor">Médecin</option>
                        <option value="family">Membre de la famille</option>
                    </select>
                </div>
                
                <div class="form-group" id="adultsInput">
                    <label class="control-label" for="email">Email enseignant</label>
                    <input id="teacher" name="emailTeacher" class="form-control" placeholder="Entrez un email" type="email">
                    
                    <label class="control-label" for="email">Email médecin</label>
                    <input id="doctor" name="emailDoctor" class="form-control" placeholder="Entrez un email" type="email">
                    
                    <label class="control-label" for="email">Email famille</label>
                    <input id="family" name="emailFamily" class="form-control" placeholder="Entrez un email" type="email">
                </div>
                
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
    
    <?php include 'footer.php' ?>

    <script>
    var ddl = document.getElementById("type");
    var selectedValue = ddl.options[ddl.selectedIndex].value;
    if (selectedValue === "child") {
        $("#adultsInput").show();
    } else {
        $("#adultsInput").hide();
    }
    $('#type').on('change',function(){
        if( $(this).val()==="child"){
        $("#adultsInput").show();
        }
        else{
        $("#adultsInput").hide();
        }
    });
    </script>
    
</body>
</html>






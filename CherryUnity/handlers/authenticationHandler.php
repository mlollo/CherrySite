<!doctype html>
<html>
    
<head>
    <meta charset="utf-8">
    <title>Authentication</title>
    <?php
        $root = "../";
        require "../includes.php";
        use Aws\DynamoDb\Exception\DynamoDbException;
        ?>
</head>

<body>
    <?php
        function testUser ($email, $type) {
            try {
                //$client = DynamoDbClientBuilder::get();
                $client = LocalDBClientBuilder::get();
                $response = $client->getItem(array(
                    'TableName' => UserDAO::$TABLE_NAME,
                        'Key' => array(
                            'email' => array('S' => $email)
                        )
                    ));
                if (empty($response) || empty($response['Item'])) {
                    return false;
                }
                if ($response['Item']['type']['S'] == $type) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $e) {
                echo '<p>Exception reçue : ',  $e->getMessage(), "\n</p>";
            }
        }
        try {
            $client = LocalDBClientBuilder::get();//DynamoDbClientBuilder::get();
            
            $array = array();
            $error = false;
            
            $type = $_POST['type'];
            
            if ($type == 'child') {
                $error = true;
                
                if (!empty($_POST['emailFamily'])) {
                    $emailFamily = $_POST['emailFamily'];
                    $testFamily = testUser($emailFamily, "family");
                } else {
                    echo "Le champ famille ne doit pas être vide.<\br>";
                }
                if (!empty($_POST['emailDoctor'])) {
                    $emailDoctor = $_POST['emailDoctor'];
                    $testDoctor = testUser($emailDoctor, "doctor");
                } else {
                    echo "Le champ médecin ne doit pas être vide.</br>";
                }
                if (!empty($_POST['emailTeacher'])) {
                    $emailTeacher = $_POST['emailTeacher'];
                    $testTeacher = testUser($emailTeacher, "teacher");
                } else {
                    echo "Le champ enseignant ne doit pas être vide.</br>";
                }
                
                if (empty($testFamily) || $testFamily == false) {
                    echo "L'email précisé dans le champ famille n'est pas le bon.</br>";
                } else if (empty($testDoctor) || $testDoctor == false) {
                    echo "L'email précisé dans le champ médecin n'est pas le bon.</br>";
                } else if (empty($testTeacher) || $testTeacher == false) {
                    echo "L'email précisé dans le champ enseignant n'est pas le bon.</br>";
                } else {
                    $error = false;
                    $array['familyId'] = array('S' => $emailFamily);
                    $array['teacherId'] = array('S' => $emailTeacher);
                    $array['doctorId'] = array('S' => $emailDoctor);
                }
            }
            
            if ($error == false) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $confirmPassword = $_POST['confirm_password'];
                $lastname = $_POST['firstname'];
                $firstname = $_POST['lastname'];

                $array['email'] = array('S' => $email);
                $array['password'] = array('S' => $password);
                $array['lastname'] = array('S' => $lastname);
                $array['firstname'] = array('S' => $firstname);
                $array['type'] = array('S' => $type);

                $response = $client->getItem(array(
                'TableName' => 'Users',
                    'Key' => array(
                        'email' => array('S' => $email)
                    )
                ));

                if ($password != $confirmPassword) {
                    echo "Les deux mots de passe entrés sont différents.";
                } else if ((empty($response) || empty($response['Item']))) {
                    $client->putItem(array(
                        'TableName' => 'Users',
                        'Item' => $array
                    ));
                    session_destroy();
                    echo "<div class=\"container\">".
                            "Utilisateur créé. Redirection vers la <a href=\"index.php\"> page d'accueil </a> ...".
                        "</div>";
                    header('Refresh:1; url=../index.php');
                } else {
                    echo "L'email saisie est déjà utilisée par un autre utilisateur.";
                }
            }
        } catch (DynamoDbException $e) {
            echo '<p>Exception dynamoDB reçue : ',  $e->getMessage(), "\n</p>";
        } catch (Exception $e) {
            echo '<p>Exception reçue : ',  $e->getMessage(), "\n</p>";
        }
        ?>
</body>
</html>




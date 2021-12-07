<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test bd</title>
</head>
<body>
    <?php
        require 'function.php';
    ?>

    <form action="" method="get">
        <label>Pseudo
            <input type="text" name="pseudo" required>
        </label>
        <label>e-mail
            <input type="email" name="mail" required>
        </label>
        <label>password
            <input type="password" name="password" required>
        </label>
        <input type="submit" value="register">
    </form>

    <?php
        require_once 'ressources/auth.php';
        if(isset($_GET["mail"]) && isset($_GET["pseudo"]) && isset($_GET["password"])){
            //login access
            $db = dbInit();
            $query_register = $db->prepare("INSERT INTO User (pseudo, mail, password, id_user) VALUES (:pseudo, :mail, :password, :id_user)");
            $msg = "";
            if(!filter_var($_GET["mail"], FILTER_VALIDATE_EMAIL)){
                $msg .= "error format mail invalid ! \n";
            }
            else{
                $query_register->bindParam(":mail", $_GET["mail"]);
                $query_register->bindParam(":pseudo", $_GET["pseudo"]);
                $password = $_GET["password"];
                $password = password_hash($password, PASSWORD_DEFAULT);
                $query_register->bindParam(":password", $password);
                do {
                    $id_gen = random_int(10000, 99999);
                    $condition_query = $db->prepare("SELECT * FROM User WHERE id_user = :id_user");
                    $condition_query->bindParam(":id_user", $id_gen);
                    $condition_query->execute();
                    $result = $condition_query->fetchAll();
                } while(!empty($result));
                $query_register->bindParam(":id_user", $id_gen);
                if($query_register->execute()){
                    $msg .= "succesfully registered";
                }
                else{
                    $error = $query_register->errorInfo();
                    print_r($error);
                    $msg .= "error sql !";
                }
            }
            echo($msg);
            $objet = 'Inscription réussie';
            $contenu = '<!DOCTYPE html>
            <html>
            <body>
                <header>
                    <h1>Bravo, vous êtes sur internet</h1>
                    <p>Pour vérifier votre adresse mail <a href="http://movieparty.alwaysdata.net/verif.php?id='.$id_gen.'" target="blank">cliquez ici</a></p>
                </header>
            </body>
            </html>';
            $dest = $_GET["mail"];
            sendmail($objet, $contenu, $dest);
        }
        
    ?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test bd</title>
</head>
<body>

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
        if(isset($_GET["mail"]) && isset($_GET["pseudo"]) && isset($_GET["password"])){
            //login access
            $dsn = 'mysql:dbname=movieparty_db;host=mysql-movieparty.alwaysdata.net';
            $user = '244287';
            $password = 'x772hs44PYeCwbq';
            try{
            $db = new PDO($dsn, $user, $password);
            } catch (PDOException $e) {
                echo 'Échec lors de la connexion : ' . $e->getMessage();
            }

            $querry_register = $db->prepare("INSERT INTO User (pseudo, mail, password, id_user) VALUES (:pseudo, :mail, :password, :pseudo)"); //id_user : TODO generate an id (for instance it is just the nickname)
            $msg = "";
            if(!filter_var($_GET["mail"], FILTER_VALIDATE_EMAIL)){
                $msg .= "error format mail invalid ! \n";
            }
            else{
                $querry_register->bindParam(":mail", $_GET["mail"]);
                $querry_register->bindParam(":pseudo", $_GET["pseudo"]);
                $password = $_GET["password"];
                $password = password_hash($password, PASSWORD_DEFAULT);
                $querry_register->bindParam(":password", $password);
                if($querry_register->execute()){
                    $msg .= "succesfully registered";
                }
                else{
                    $error = $querry_register->errorInfo();
                    print_r($error);
                    $msg .= "error sql !";
                }
            }
            echo($msg);
        }
        
    ?>
</body>
</html>
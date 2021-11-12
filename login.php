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
        <label>password
            <input type="password" name="password" required>
        </label>
        <input type="submit" value="login">
    </form>

    <?php

        session_start();
        if(isset($_GET["pseudo"]) && isset($_GET["password"])){
            //login access
            $dsn = 'mysql:dbname=movieparty_db;host=mysql-movieparty.alwaysdata.net';
            $user = '244287';
            $password = 'x772hs44PYeCwbq';
            try{
            $db = new PDO($dsn, $user, $password);
            } catch (PDOException $e) {
                echo 'Échec lors de la connexion : ' . $e->getMessage();
            }

            $msg = "";
            $querry_login = $db->prepare("SELECT password FROM User WHERE pseudo = :pseudo");
            $querry_login->bindParam(":pseudo", $_GET["pseudo"]);
            $password = $_GET["password"];
            $querry_login->execute();
            $result = $querry_login->fetchAll();
            $hash = $result[0]["password"];

            if(password_verify($password, $hash)){
                $msg .= "succesfully loged in !";
                $_SESSION["pseudo"] = $_GET["pseudo"];
                header("Location: profil.php");
            }
            else{
                $msg .= "error pseudo ou mdp incorrect";
            }
            echo($msg);
            echo($_SESSION["pseudo"]);
        }
        
    ?>
</body>
</html>
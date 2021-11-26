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
        require_once 'ressources/auth.php';
        session_start();
        if(isset($_GET["pseudo"]) && isset($_GET["password"])){
            //login access
            $db = dbInit();

            $msg = "";
            $querry_login = $db->prepare("SELECT password, id_user FROM User WHERE pseudo = :pseudo");
            $querry_login->bindParam(":pseudo", $_GET["pseudo"]);
            $password = $_GET["password"];
            $querry_login->execute();
            $result = $querry_login->fetchAll();
            $hash = $result[0]["password"];

            if(password_verify($password, $hash)){
                $msg .= "succesfully loged in !";
                $_SESSION["id_user"] = $result[0]["id_user"];
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
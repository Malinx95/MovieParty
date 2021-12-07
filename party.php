<?php
    require './ressources/auth.php';
    if(isset($_GET["name"])){
        $db = dbInit();
        $query_party = $db->prepare("SELECT * FROM party WHERE name = :name");
        $query_party->bindParam(":name", $_GET["name"]);
        $query_party->execute();
        $result = $query_party->fetchAll();
        $name = $result[0]["name"];
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php if(isset($name)){echo($name);}else{echo("cette party n'existe pas");} ?></title>
</head>
<body>
    <?php 
        if(isset($name)){
            echo("<h1>" . $name . "</h1>");
            echo("<h2>" . $result[0]["description"] . "</h2>");
            echo("<h3> Le " . $result[0]["date"] . " à " . $result[0]["cine_name"] . " pour le film " . $result[0]["movie"]);
            session_start();
            if(isset($_SESSION["id_user"])){
                echo("<form action=\"\" method=\"get\"><input type=\"text\" name=\"id_user\" value=\"" . $_SESSION["id_user"] . "\"><input type=\"submit\" value\"rejoindre le groupe\"></form>");
            }
        }
        else{
            echo("<h1>Cette party n'existe pas </h1>");
        }
    ?>
</body>
</html>
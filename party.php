<?php
    require './ressources/auth.php';
    if(isset($_GET["name"])){
        session_start();
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
        if(isset($_GET["join"]) && isset($name)){
            $query_join = $db->prepare("INSERT INTO joined_group (name, id_user) VALUES (:name, :id_user)");
            $query_join->bindParam(":name", $name);
            $query_join->bindParam(":id_user", $_GET["join"]);
            if($query_join->execute()){
                echo "Succefully joined !";
            }
            else{
                echo "erreur sql : ";
                print_r($query_join->errorInfo());
            }
        }
        if(isset($name)){
            echo("<h1>" . $name . "</h1>\n");
            echo("<h2>" . $result[0]["description"] . "</h2>\n");
            echo("<h3> Le " . $result[0]["date"] . " à " . $result[0]["cine_name"] . " pour le film " . $result[0]["movie"] . "\n");
            $query_joined = $db->prepare("SELECT joined_group.id_user, pseudo FROM joined_group INNER JOIN user ON joined_group.id_user = user.id_user");
            $query_joined->execute();
            $result = $query_joined->fetchAll();
            echo "<h3>Utilisateur dans la party :</h3>\n";
            echo "<ul>\n";
            $is_in = false;
            $addr = substr($_SERVER["PHP_SELF"], 0, strripos($_SERVER["PHP_SELF"], "/")+1);
            $addr .= "profil.php?id_user=";
            foreach($result as $line){
                echo "<li><a href=" . $addr . $line[0] . ">" . $line[1] . "</a></li>\n";
                if($line[0] == $_SESSION["id_user"]){
                    $is_in = true;
                }
            }
            echo "</ul>\n";
            if(isset($_SESSION["id_user"]) && !$is_in){
                echo("<form action=\"\" method=\"get\"><input type=\"hidden\" name=\"name\" value=\"" . $name ."\"><input type=\"hidden\" name=\"join\" value=\"" . $_SESSION["id_user"] . "\"><input type=\"submit\" value\"rejoindre le groupe\"></form>\n");
            }
        }
        else{
            echo("<h1>Cette party n'existe pas </h1>\n");
        }
    ?>
</body>
</html>
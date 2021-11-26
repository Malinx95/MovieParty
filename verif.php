<?php
    session_start();
    $dsn = 'mysql:dbname=movieparty_db;host=mysql-movieparty.alwaysdata.net';
    $user = '244287';
    $password = 'x772hs44PYeCwbq';
    try{
    $db = new PDO($dsn, $user, $password);
    } catch (PDOException $e) {
        echo 'Échec lors de la connexion : ' . $e->getMessage();
    }
    //vérifier si l'id existe dans la base => verif passe à 1
    $id_url = $_GET["id"];
    $query_verif = $db->prepare("SELECT id_user FROM User WHERE id_user = :id_user");
    $query_verif->bindParam(":id_user", $id_url);
    $query_verif->execute();
    $result = $query_verif->fetchAll();
    if (!empty($result)) {
        $query_ok = $db->prepare("UPDATE User SET verified = 1 WHERE id_user = :id_user");
        $query_ok->bindParam(":id_user", $result[0]["id_user"]);
        $query_ok->execute();
        echo "<h1>Compte vérifié !</h1> \n <p><a href=\"./login.php\">Se connecter</a>";
    } else {
        echo "<p>Le lien de vérification n\'est plus valide.</p>";
    }
?>
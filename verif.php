<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <script src='main.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js"></script>
    <link rel="icon" href="./images/favicon.png">
    <link rel="stylesheet" href="./scss/custom.scss">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" media="screen and (min-width: 900px)" href="widescreen.css">
    <link rel="stylesheet" media="screen and (max-width: 600px)" href="smallscreen.css">
    <title>Register</title>
</head>
<body>
    <?php
        require_once 'ressources/auth.php';
        session_start();
        $db = dbInit();
        //vérifier si l'id existe dans la base => verif passe à 1
        $id_url = $_GET["id"];
        $query_verif = $db->prepare("SELECT id_user FROM user WHERE id_user = :id_user");
        $query_verif->bindParam(":id_user", $id_url);
        $query_verif->execute();
        $result = $query_verif->fetchAll();
        if (!empty($result)) {
            $query_ok = $db->prepare("UPDATE user SET verified = 1 WHERE id_user = :id_user");
            $query_ok->bindParam(":id_user", $result[0]["id_user"]);
            $query_ok->execute();
            echo "<h1>Compte vérifié !</h1> \n <p><a href=\"./login.php\">Se connecter</a>";
        } else {
            echo "<p>Le lien de vérification n\'est plus valide.</p>";
        }
    ?>
    <footer>
        <ul class="stylished-ul">
            <li class="category">Links</li>
            <li><a href="index.php">cineparty</a></li>
            <li><a href="">Plan du site</a></li>
            <li><a href="https://movieparty334667277.wordpress.com/" target="blank">Présentation du projet</a></li>
        </ul>
    </footer>
</body>
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
    <title>Log in</title>
</head>
<body>
    <div id="centered-item">
        <form class="needs-validation" method="get" novalidate>
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="validationTooltipUsername">Pseudo</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="validationTooltipUsernamePrepend">@</span>
                    </div>
                    <input type="text" class="form-control" id="validationTooltipUsername" name="pseudo" placeholder="Username" aria-describedby="validationTooltipUsernamePrepend" required>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="validationTooltip02">Mot de passe</label>
                <input type="password" class="form-control" id="validationTooltip02" name="password" placeholder="Mot de passe"  required>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Log in</button>
        </form>

        <?php
            require_once 'ressources/auth.php';
            session_start();
            if(isset($_GET["pseudo"]) && isset($_GET["password"])){
                //login access
                $db = dbInit();

                $msg = "";
                $querry_login = $db->prepare("SELECT password, id_user FROM user WHERE pseudo = :pseudo");
                $querry_login->bindParam(":pseudo", $_GET["pseudo"]);
                $password = $_GET["password"];
                $querry_login->execute();
                $result = $querry_login->fetchAll();
                $hash = $result[0]["password"];

                if(password_verify($password, $hash)){
                    $msg .= "succesfully loged in !";
                    $_SESSION["id_user"] = $result[0]["id_user"];
                    $_SESSION["pseudo"] = $result[0]["pseudo"];
                    $url = 'profil.php?id_user=' . $_SESSION["id_user"];
                    header("Location: $url");
                }
                else{
                    $msg .= "error pseudo ou mdp incorrect";
                }
                echo($msg);
            }
            
        ?>
        <p><a href="index.php">Retourner à l'accueil</a></p>
    </div>
    <footer>
      <ul class="stylished-ul">
        <li class="category">Links</li>
        <li><a href="index.php">cineparty</a></li>
        <li><a href="">Plan du site</a></li>
        <li><a href="https://movieparty334667277.wordpress.com/" target="blank">Présentation du projet</a></li>
      </ul>
    </footer>
</body>
</html>
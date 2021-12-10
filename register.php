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
        require 'function.php';
    ?>
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
            <label for="validationTooltip01">Mail</label>
            <input type="text" class="form-control" id="validationTooltip01" name="mail" placeholder="Mail" required>
            </div>
            <div class="col-md-4 mb-3">
            <label for="validationTooltip02">Mot de passe</label>
            <input type="password" class="form-control" id="validationTooltip02" name="password" placeholder="Mot de passe"  required>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Register</button>
        </form>

        <?php
            require_once 'ressources/auth.php';
            if(isset($_GET["mail"]) && isset($_GET["pseudo"]) && isset($_GET["password"])){
                //login access
                $db = dbInit();
                $query_register = $db->prepare("INSERT INTO user (pseudo, mail, password, id_user) VALUES (:pseudo, :mail, :password, :id_user)"); //id_user : TODO generate an id (for instance it is just the nickname)
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
                        $condition_query = $db->prepare("SELECT * FROM user WHERE id_user = :id_user");
                        $condition_query->bindParam(":id_user", $id_gen);
                        $condition_query->execute();
                        $result = $condition_query->fetchAll();
                    } while(!empty($result));
                    $query_register->bindParam(":id_user", $id_gen);
                    if($query_register->execute()){
                        $msg .= "<p>succesfully registered</p>";
                        $objet = 'Inscription réussie';
                        $contenu = '<!DOCTYPE html>
                        <html>
                        <body>
                            <header>
                                <h1>Bravo, vous êtes sur internet</h1>
                                <p>Pour vérifier votre adresse mail <a href="http://cineparty.alwaysdata.net/verif.php?id='.$id_gen.'" target="blank">cliquez ici</a></p>
                            </header>
                        </body>
                        </html>';
                        $dest = $_GET["mail"];
                        sendmail($objet, $contenu, $dest);
                    }
                    else{
                        $error = $query_register->errorInfo();
                        print_r($error);
                        $msg .= "error sql !";
                    }
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
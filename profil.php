<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Movieparty</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <script src='main.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js"></script>
    <link rel="icon" href="./images/favicon.png">
    <link rel="stylesheet" href="./scss/custom.scss">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" media="screen and (min-width: 900px)" href="widescreen.css">
    <link rel="stylesheet" media="screen and (max-width: 600px)" href="smallscreen.css">
</head>

<body>
    <?php
    require_once 'ressources/auth.php';
    session_start();
    $db = dbInit();
    if (isset($_SESSION["id_user"])) {
        echo $_SESSION["id_user"];
        $query_register = $db->prepare("UPDATE User SET mail = :mail, pseudo = :pseudo, nom = :nom, prenom = :prenom, date_naissance = :date_naissance WHERE id_user = :id_user");
        if (!filter_var($_GET["mail"], FILTER_VALIDATE_EMAIL)) {
            $msg = "error format mail invalid ! \n";
        } else {
            $query_register->bindParam(":id_user", $_SESSION["id_user"]);
            $query_register->bindParam(":mail", $_GET["mail"]);
            $query_register->bindParam(":pseudo", $_GET["pseudo"]);
            $query_register->bindParam(":nom", $_GET["name"]);
            $query_register->bindParam(":prenom", $_GET["first-name"]);
            $query_register->bindParam(":date_naissance", $_GET["date_naissance"]);
            $query_register->execute();
        }
    } else {
        header("Location : notfound.php");
    }
    ?>
    <header>
        <nav id="test" class="navbar navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Movieparty</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Movieparty</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="index.php" style="color: black;">Home</a>
                            </li>
                            <li class="nav-item">
                                <?php
                                    if (isset($_SESSION["id_user"])) {
                                        echo '<a class="nav-link" href="login.php" style="color: black;">Log in</a>
                                        <a class="nav-link" href="register.php" style="color: black;">Sign in</a>';
                                    } else {
                                        echo '<a class="nav-link" href="profil.php?id_user=' . $_SESSION["id_user"] . '" style="color: black;">' . $_SESSION["pseudo"] .  '</a>';
                                    }
                                ?>
                                <a class="nav-link" href="#" style="color: black;">Instagram, Twitter...</a>
                                <a class="nav-link" href="https://movieparty334667277.wordpress.com/" target="blank" style="color: black;">Le projet Movieparty</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: black;">
                                    Aller vers
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
                                    <li><a class="dropdown-item" href="#" style="color: black;">Groupes</a></li>
                                    <li><a class="dropdown-item" href="#" style="color: black;">Mes groupes</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#" style="color: black;">Se déconnecter</a></li>
                                </ul>
                            </li>
                        </ul>
                        <form class="d-flex">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div id="profile-background">
        <div id="profile-picture-process">
            <img src="./images/profile.jpg" alt="photo de profil" id="profile-picture" />
        </div>
    </div>
    <div id="nickname">
        <?php
        try {
            $db = dbInit();
        } catch (PDOException $e) {
            echo 'Échec lors de la connexion : ' . $e->getMessage();
        }
        $query_profile = $db->prepare("SELECT pseudo, nom, prenom, date_naissance, mail FROM User WHERE id_user = :id_user");
        $query_profile->bindParam(":id_user", $_SESSION["id_user"]);
        $query_profile->execute();
        $query_profile_result = $query_profile->fetchAll();
        $pseudo = $query_profile_result[0]["pseudo"];
        echo ("<h2>$pseudo</h2>");
        ?>
    </div>
    <form action="" method="get">
        <div class="form-display">
            <label for="name">Nom :</label>
            <input type="text" name="name" id="name" <?php $nom = $query_profile_result[0]["nom"] ;echo ("value='$nom'"); ?>>
        </div>
        <div class="form-display">
            <label for="first-name">Prénom:</label>
            <input type="text" name="first-name" id="first-name" <?php $prenom = $query_profile_result[0]["prenom"]; echo ("value='$prenom'"); ?>>
        </div>
        <div class="form-display">
            <label for="pseudo">Pseudo :</label>
            <input type="text" name="pseudo" id="pseudo" <?php $pseudo = $query_profile_result[0]["pseudo"]; echo ("value='$pseudo'"); ?>>
        </div>
        <div class="form-display">
            <label for="mail">mail :</label>
            <input type="text" name="mail" id="email" <?php $mail = $query_profile_result[0]["mail"]; echo ("value='$mail'"); ?>>
        </div>
        <label for="start">Date de naissance :</label>
        <input type="date" id="birthday" name="date_naissance" <?php $date_naissance = $query_profile_result[0]["date_naissance"]; echo ("value='$date_naissance'"); ?>>
        </div>
        <div class="form-display">
            <input type="submit" value="Enregistrer">
        </div>
    </form>

    <form action="" method="post">
        <div class="form-display">
            <label for="old-password">Ancien mot de passe :</label>
            <input type="text" name="old-password" id="old-password">
        </div>
        <div class="form-display">
            <label for="password">Nouveau mot de passe :</label>
            <input type="text" name="password" id="password">
        </div>
        <div class="form-display">
            <label for="retype-password">Valider le mot de passe :</label>
            <input type="text" name="retype-password" id="retype-password">
        </div>
        <div class="form-display">
            <input type="submit" value="Enregistrer">
        </div>
    </form>
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
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="function.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <script src='main.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="main.css">
    <link rel="icon" href="./images/favicon.png">
    <link rel="stylesheet" media="screen and (min-width: 900px)" href="widescreen.css">
    <link rel="stylesheet" media="screen and (max-width: 600px)" href="smallscreen.css">
</head>
<body>
    <header>
        <nav id="test" class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><img src="./images/favicon.png" style="width: 15%;" alt="logo" /></a>
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
                        if (!isset($_SESSION["id_user"])) {
                        echo '<a class="nav-link" href="login.php" style="color: black;">Log in</a>
                        <a class="nav-link" href="register.php" style="color: black;">Sign in</a>';
                        } else {
                        echo '<a class="nav-link" href="profil.php?id_user=' . $_SESSION["id_user"] .  '" style="color: black;">Mon profil</a>';
                        echo '<a class="nav-link" href="logout.php" style="color: black;">Se déconnecter</a>';
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
                    <li><a class="dropdown-item" href="logout.php" style="color: black;">Se déconnecter</a></li>
                    </ul>
                </li>
                </ul>

                <form action="./search.php?search=" method="get" id="search-index-form">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>

            </div>
            </div>
        </div>
        </nav>
    </header>
    <div id="other_pages" >
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
            if(isset($_GET["leave"]) && isset($name)){
                $query_leave = $db->prepare("DELETE FROM joined_group WHERE name = :name AND id_user = :id_user");
                $query_leave->bindParam(":name", $_GET["name"]);
                $query_leave->bindParam(":id_user", $_GET["leave"]);
                if($query_leave->execute()){
                    echo "Succefully left !";
                }
                else{
                    echo "erreur sql : ";
                    print_r($query_leave->errorInfo());
                }
            }
            if(isset($name)){
                echo("<h1>" . $name . "</h1>\n");
                echo("<h2>" . $result[0]["description"] . "</h2>\n");
                echo("<h3> Le " . $result[0]["date"] . " à " . $result[0]["cine_name"] . " pour le film " . $result[0]["movie"] . "\n");
                $query_joined = $db->prepare("SELECT joined_group.id_user, pseudo FROM joined_group INNER JOIN user ON joined_group.id_user = user.id_user WHERE name = " . "\"" . $_GET["name"] . "\"");
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
                    echo("<form action=\"\" method=\"get\"><input type=\"hidden\" name=\"name\" value=\"" . $name ."\"><input type=\"hidden\" name=\"join\" value=\"" . $_SESSION["id_user"] . "\"><input type=\"submit\" value=\"rejoindre le groupe\"></form>\n");
                }
                if(isset($_SESSION["id_user"]) && $is_in){
                    echo("<form action=\"\" method=\"get\"><input type=\"hidden\" name=\"name\" value=\"" . $name ."\"><input type=\"hidden\" name=\"leave\" value=\"" . $_SESSION["id_user"] . "\"><input type=\"submit\" value=\"quitter le groupe\"></form>\n");
                }
            }
            else{
                echo("<h1>Cette party n'existe pas </h1>\n");
            }
        ?>
    </div>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>horraire</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
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
    <?php
        include "function.php";
        session_start();
    ?>
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
	<div id="other_pages">
        <form action="" method="get" id="search_form">
            <label >Chercher par nom :
                <input type="text" name="search" id="search" placeholder="nom" <?php if(isset($_GET["search"]) && !empty($_GET["search"])){echo("value=\""); echo($_GET["search"]); echo("\"");} ?>>
            </label>
            <label id="cine_name">Chercher par cinema :
                <input type="text" name="cine_name" placeholder="cinema" <?php if(isset($_GET["cine_name"]) && !empty($_GET["cine_name"])){echo("value=\""); echo($_GET["cine_name"]); echo("\"");} ?>>
            </label>
            <label id="movie">Chercher par film :
                <input type="text" name="movie" placeholder="film" <?php if(isset($_GET["movie"]) && !empty($_GET["movie"])){echo("value=\""); echo($_GET["movie"]); echo("\"");} ?>>
            </label>
            <div>
                <label for="cinema">cinema</label>
                <input type="radio" id="cinema" name="option" value="cinema" <?php if(isset($_GET["option"])){if($_GET["option"] == "cinema"){echo "checked";}else{if($_GET["option"] != "party" && $_GET["option"] != "user"){echo "checked";}}}else{echo "checked";} ?>>
                <label for="party">party</label>
                <input type="radio" id="party" name="option" value="party" <?php if(isset($_GET["option"]) && $_GET["option"] == "party"){echo "checked";} ?>>
                <label for="user">user</label>
                <input type="radio" id="user" name="option" value="user"<?php if(isset($_GET["option"]) && $_GET["option"] == "user"){echo "checked";} ?>>
            </div>
            <input type="submit" value="Rechercher">
        </form>
        <?php
            if(isset($_GET["search"]) && !empty($_GET["search"]) && isset($_GET["option"]) && $_GET["option"] == "cinema"){
                echo(list_cinema());
            }
            if(isset($_GET["search"]) && !empty($_GET["search"]) && !isset($_GET["option"])){
                echo(list_cinema());
            }
            if(isset($_GET["id"]) && !is_null($_GET["id"])){
                echo(table_showtimes());
            }
            if(isset($_GET["search"]) && !empty($_GET["search"]) && isset($_GET["option"]) && $_GET["option"] == "user"){
                echo(list_users());
            }
            if(isset($_GET["option"]) && $_GET["option"] == "party"){
                echo(list_party());
            }
        ?>
    </div>
</body>
</html>
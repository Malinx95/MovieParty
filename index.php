<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name="google-site-verification" content="mGlldCqqiM8-I28qO26Z5HABiMXQrTD2Eu-VK7viYzg" />
    <meta name="msvalidate.01" content="1D6B1F0828DDB809916C4F729B8A0E09" />
    <meta name="keywords" content="cineparty,movieparty,chercher cinema,cinema,films,amis,couple,party,groupe cinema, groupe,seance cinema,seance,showtime,allocine,lmdb,ensemble">
    <meta name="description" content="Cineparty vous propose un moyen simple de rencontrer des personnes partageant votre passion : le cinéma !">
    <title>Cineparty</title>
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
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="./images/slide1.jpg" class="d-block w-100" alt="random1">
          <div class="carousel-caption d-none d-md-block">
            <h5>N'allez plus au cinéma seul.</h5>
            <p>Movieparty vous propose un moyen simple de rencontrer des personnes partageant votre passion : le cinéma.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="./images/slide2.jpg" class="d-block w-100" alt="random2">
          <div class="carousel-caption d-none d-md-block">
            <h5>Cherchez,rejoignez ou créez.</h5>
            <p>Vous n'avez qu'à rechercher un cinéma spécifique et à consulter les différents groupes de visionnage. Si aucun ne vous convient, il vous suffit d'en créer un.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="./images/slide3.jpg" class="d-block w-100" alt="random3">
          <div class="carousel-caption d-none d-md-block">
            <h5>Créez un compte et partez à l'aventure.</h5>
            <p>Essayez, c'est gratuit</p>
            <?php
              if (!isset($_SESSION["id_user"])) {
                echo 
                '<form action="./register.php" method="get" id="search-index-form">
                  <button type="button" class="btn btn-dark">S\'inscrire</button>
                </form>';
              }
            ?>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <div id="presentation">
      <div id="text-pres">
        <h2>Faites la connaissance de passionnés de cinéma</h2>
        <p>Vous avez envie d'aller voir un film au cinéma mais personne ne veut venir avec vous ? Cineparty vous met en relation avec des cinéphiles près de chez vous.</p>
        <p>Cherchez votre cinéma, sélectionez votre séance et rejoignez un groupe.</p>
      </div>
    </div>
    <div id="search-section">
        <h2>La spectacle commence ici</h2>
        <form action="./search.php?search=" method="get" id="search-index-form">
          <input name="search" autocomplete="off" title="Search" placeholder="Recherchez un cinéma, un film, un utilisateur, un groupe..." />
        </form>
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
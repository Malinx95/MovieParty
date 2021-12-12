<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name="keywords" content="cineparty,movieparty,chercher cinema,cinema,films,amis,couple,party,groupe cinema, groupe,seance cinema,seance,showtime,allocine,lmdb,ensemble">
    <title>Mon profil - cineparty</title>
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
      if(isset($_SESSION["id_user"]) && isset($_GET["ok"])){
        $query_register = $db->prepare("UPDATE user SET mail = :mail, pseudo = :pseudo, nom = :nom, prenom = :prenom, date_naissance = :date_naissance, description = :description  WHERE id_user = :id_user");
        if(!filter_var($_GET["mail"], FILTER_VALIDATE_EMAIL)){
            $msg .= "error format mail invalid ! \n";
        }
        else{
            $query_register->bindParam(":id_user", $_SESSION["id_user"]);
            $query_register->bindParam(":mail", $_GET["mail"]);
            $query_register->bindParam(":pseudo", $_GET["pseudo"]);
            $query_register->bindParam(":nom", $_GET["name"]);
            $query_register->bindParam(":prenom", $_GET["first-name"]);
            $query_register->bindParam(":date_naissance", $_GET["date_naissance"]);
            $query_register->bindParam(":description", $_GET["description"]);
            $query_register->execute();
        }
        if (isset($_FILES["avatar"])) {
          $query_update_pp = $db->prepare("UPDATE user SET profil_pic = :profil_pic, type_mime = :type_mime WHERE id_user = :id_user");
          $blob = file_get_contents($_FILES["avatar"]["tmp_name"]);
          $query_update_pp->bindParam(":profil_pic", $blob);
          $query_update_pp->bindParam(":type_mime", $_FILES["avatar"]["type"]);
          $query_update_pp->bindParam("id_user", $_SESSION["id_user"]);
          $query_update_pp->execute();
        }
        if (isset($_POST["password"]) && isset($_POST["retype-password"])) {
          if (isset($_POST["old-password"])) {
            $query_update_password = $db->prepare("SELECT password FROM user WHERE id_user = :id_user");
            $query_update_password->bindParam(":id_user", $_SESSION["id_user"]);
            $password = $_POST["old-password"];
            $query_update_password->execute();
            $result = $query_update_password->fetchAll();
            $hash = $result[0]["password"];
            if(password_verify($password, $hash)){
              if ($_POST["password"] == $_POST["retype-password"]) {
                $query_update_password = $db->prepare("UPDATE password = :password WHERE id_user = :id_user");
                $query_update_password->bindParam(":id_user", $_SESSION["id_user"]);
                $query_update_password->bindParam(":password", $_POST["password"]);
                $query_update_password->execute();
                $pwdmsg .= "mot de passe modifié";
              } else {
                $pwdmsg .= "mots de passe différents";
              }
          }
          else{
              $pwdmsg .= "mot de passe incorrect";
          }
          }
        }
      }
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
  <div id="profile-background">
    <div id="profile-picture-process">
      <?php
        $dsn = dbInit();
        $query_profile_pic = $db->prepare("SELECT profil_pic, type_mime FROM user WHERE id_user = :id_user");
        $query_profile_pic->bindParam(":id_user", $_GET["id_user"]);
        $query_profile_pic->execute();
        $query_profile_pic_result = $query_profile_pic->fetchAll();
        if (empty($query_profile_pic_result[0]["profil_pic"])) {
          echo '<img src="./images/profile.jpg" alt="photo de profil" id="profile-picture" />
          </div>';
        } else {
          echo '<img src="data:'. $query_profile_pic_result[0]["type_mime"] . ';base64,' . base64_encode($query_profile_pic_result[0]["profil_pic"]) . '" alt="photo de profil" id="profile-picture" />
          </div>';
        }
      ?>
      
  </div>
  <div id="nickname">
    <?php
        $dsn = dbInit();
        $query_profile = $db->prepare("SELECT pseudo, nom, prenom, date_naissance, mail FROM user WHERE id_user = :id_user");
        $query_profile->bindParam(":id_user", $_GET["id_user"]);
        $query_profile->execute();
        $query_profile_result = $query_profile->fetchAll();
        $pseudo = $query_profile_result[0]["pseudo"];
        echo("<h2>$pseudo</h2>");
    ?>
  </div>
  
  <div id="profile_description">
    <?php
      $dsn = dbInit();
      $query_desc = $db->prepare("SELECT description FROM user WHERE id_user = :id_user");
      $query_desc->bindParam(":id_user", $_GET["id_user"]);
      $query_desc->execute();
      $query_profile_desc = $query_desc->fetchAll();
      if(isset($query_profile_desc[0]["description"]) && !empty($query_profile_desc[0]["description"])){
        echo '<p>' . $query_profile_desc[0]["description"] . '</p>';
      }
      else{
        echo "<p>Cet utilisateur n'as pas de decription</p>";
      }
    ?>
  </div>

  <div id="privacy_infos">
      <?php
      if ($_SESSION["id_user"] == $_GET["id_user"]) {
        $dsn = dbInit();
        $query_profile = $db->prepare("SELECT pseudo, nom, prenom, date_naissance, mail, description FROM user WHERE id_user = :id_user");
        $query_profile->bindParam(":id_user", $_SESSION["id_user"]);
        $query_profile->execute();
        $query_profile_result = $query_profile->fetchAll();
        $nom = $query_profile_result[0]["nom"];
        $prenom = $query_profile_result[0]["prenom"];
        $pseudo = $query_profile_result[0]["pseudo"];
        $mail = $query_profile_result[0]["mail"];
        $date_naissance = $query_profile_result[0]["date_naissance"];
        $description = $query_profile_result[0]["description"];
        echo '<form action="" method="get" class="stylished-form">
          <div class="form-display">
            <label for="name">Description :</label>
            <input type="text" name="description" id="description" value="'. $description . '">
          <div class="form-display">
              <label for="name">Nom :</label>
              <input type="text" name="name" id="name" value="'. $nom . '">
          </div>
          <input type="hidden" name="id_user" id="id_user" value="' . $_GET["id_user"] . '">
          <div class="form-display">
            <label for="first-name">Prénom:</label>
            <input type="text" name="first-name" id="first-name" value="' . $prenom . '">
          </div>
          <div class="form-display">
            <label for="pseudo">Pseudo :</label>
            <input type="text" name="pseudo" id="pseudo" value="' . $pseudo . '">
          </div>
          <div class="form-display">
            <label for="mail">mail :</label>
            <input type="text" name="mail" id="email" value="' . $mail . '">
          </div>
          <div class="form-display">
            <label for="start">Date de naissance :</label>
            <input type="date" id="birthday" name="date_naissance" value="' . $date_naissance . '">
          </div>
          <div class="form-display">
          <input type="submit" name="ok" value="Enregistrer">
          </div>
        </form>
          <form method="post" enctype="multipart/form-data" class="stylished-form">
          <label for="avatar">Photo de profil:</label>
          <input type="file"
          id="avatar" name="avatar" accept="image/png, image/jpeg, image/gif">
          <div class="form-display">
          <input type="submit" name="ok" value="Enregistrer">
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
            <input type="submit" name="ok" value="Enregistrer">
          </div>
        </form>
        ';
      }
    ?>
  </div>
  <div id="party-list">
      <h3>Party rejoints par l'utilisateur :</h3>
      <?php
        $db = dbInit();
        $query_party = $db->prepare("SELECT name FROM joined_group WHERE id_user = :id_user");
        $query_party->bindParam(":id_user", $_GET["id_user"]);
        $query_party->execute();
        $result = $query_party->fetchAll();
        echo "<ul>\n";
        $addr = substr($_SERVER["PHP_SELF"], 0, strripos($_SERVER["PHP_SELF"], "/")+1);
        $addr .= "party.php?";
        foreach($result as $line){
            $data = array();
            $data["name"] = $line[0];
            $args = http_build_query($data);
            echo "<li><a href=" . $addr . $args . ">" . $line[0] . "</a></li>\n";
        }
        echo "</ul>\n";
      ?>
  </div>
  <footer>
      <ul class="stylished-ul">
        <li class="category">Links</li>
        <li><a href="index.php">cineparty</a></li>
        <li><a href="plandusite.php">Plan du site</a></li>
        <li><a href="https://movieparty334667277.wordpress.com/" target="blank">Présentation du projet</a></li>
      </ul>
    </footer>
</body>
</html>
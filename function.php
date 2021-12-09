<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require './PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';
    require './ressources/auth.php';
    function sendmail($objet, $contenu, $destinataire) {  
        // on crée une nouvelle instance de la classe
        $mail = new PHPMailer(true);
        // puis on l’exécute avec un 'try/catch' qui teste les erreurs d'envoi
        try {
          /* DONNEES SERVEUR */
          #####################
          $mail->setLanguage('fr', '../PHPMailer/language/');   // pour avoir les messages d'erreur en FR
          $mail->SMTPDebug = 0;            // en production (sinon "2")
          // $mail->SMTPDebug = 2;            // décommenter en mode débug
          $mail->isSMTP();                                                            // envoi avec le SMTP du serveur
          mailInit($mail);
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;     // encodage des données TLS (ou juste 'tls') > "Aucun chiffrement des données"; sinon PHPMailer::ENCRYPTION_SMTPS (ou juste 'ssl')
          $mail->Port       = 465;                                                               // port TCP (ou 25, ou 465...)
    
          /* DONNEES DESTINATAIRES */
          ##########################
          $mail->setFrom('movieparty@alwaysdata.fr');  //adresse de l'expéditeur (pas d'accents)
          $mail->addAddress($destinataire, 'Clients de Mon_Domaine');        // Adresse du destinataire (le nom est facultatif)
          // $mail->addReplyTo('moi@mon_domaine.fr', 'son nom');     // réponse à un autre que l'expéditeur (le nom est facultatif)
          // $mail->addCC('cc@example.com');            // Cc (copie) : autant d'adresse que souhaité = Cc (le nom est facultatif)
          // $mail->addBCC('bcc@example.com');          // Cci (Copie cachée) :  : autant d'adresse que souhaité = Cci (le nom est facultatif)
    
          /* PIECES JOINTES */
          ##########################
          // $mail->addAttachment('../dossier/fichier.zip');         // Pièces jointes en gardant le nom du fichier sur le serveur
          // $mail->addAttachment('../dossier/fichier.zip', 'nouveau_nom.zip');    // Ou : pièce jointe + nouveau nom
    
          /* CONTENU DE L'EMAIL*/
          ##########################
          $mail->isHTML(true);                                      // email au format HTML
          $mail->Subject = utf8_decode($objet);      // Objet du message (éviter les accents là, sauf si utf8_encode)
          $mail->Body    = $contenu;          // corps du message en HTML - Mettre des slashes si apostrophes
          $mail->AltBody = 'Vous vous êtes inscrits sur movieparty avec cet email'; // ajout facultatif de texte sans balises HTML (format texte)
    
          $mail->send();
          echo 'Message envoyé.';
        
        }
        // si le try ne marche pas > exception ici
        catch (Exception $e) {
          echo "Le Message n'a pas été envoyé. Mailer Error: {$mail->ErrorInfo}"; // Affiche l'erreur concernée le cas échéant
        }  
    }

    function table_showtimes(){
        require(__DIR__.'/allocine_graphql.class.php');
        $allocine = new Allocine();
        $day = 0;
        if(isset($_GET["date"]) && !is_null($_GET["date"])){
            $day = intval($_GET["date"]);
            $date = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d")+ 1 + $day, date("Y")));
        }else{
            $date = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")));
        }
        if(isset($_GET["id"]) && !is_null($_GET["id"])){
            $id = $_GET["id"];
        }
        if(isset($_GET["name"]) && !is_null($_GET["name"])){
            $cine = $_GET["name"];
        }

        $result = $allocine->showtimelist($id, $date);
        $nb_film = sizeof($result["data"]["movieShowtimeList"]["edges"]);
        $out = "<table id=\"showtimes\">\n";
        $out .="\t\t<thead>\n";
        $out .="\t\t\t<tr>\n";

        if($day <= 0){
            $out .= "\t\t\t\t<th><button id=\"previous\" disabled>&lt</button>\n";
        }
        else{
            $out .= "\t\t\t\t<th><button id=\"previous\">&lt</button>\n";
        }

        $out .="\t\t\t\t<th id=\"name\" colspan=\"";
        $out .=$nb_film -2;
        $out .="\">cinema : $cine - Le : $date</th>\n";

        if($day >= 7){
            $out .= "\t\t\t\t<th><button id=\"next\" disabled>&gt</button>\n";
        }
        else{
            $out .= "\t\t\t\t<th><button id=\"next\">&gt</button>\n";
        }

        $out .="\t\t\t</tr>\n";
        $out .="\t\t</thead>\n";
        $out .="\t\t<tbody>\n";
        $out .="\t\t\t<tr>\n";
        for ($i = 0; $i < $nb_film; $i++) {
            $out .="\t\t\t\t<td>";
            $out .=$result["data"]["movieShowtimeList"]["edges"][$i]["node"]["movie"]["title"];
            $out .="</td>\n";
        }
        $out .="\t\t\t</tr>\n";
        $nb_seance_max = 0;
        for ($i = 0; $i < $nb_film; $i++) {
            if(sizeof($result["data"]["movieShowtimeList"]["edges"]["$i"]["node"]["showtimes"]) > $nb_seance_max){
                $nb_seance_max = sizeof($result["data"]["movieShowtimeList"]["edges"]["$i"]["node"]["showtimes"]);
            }
        }
        for ($i = 0; $i < $nb_seance_max; $i++) {
            $out .="\t\t\t<tr>\n";
            for($j = 0; $j < $nb_film; $j++){
                $out .="\t\t\t\t<td>";
                if(isset($result["data"]["movieShowtimeList"]["edges"]["$j"]["node"]["showtimes"][$i]["startsAt"])){
                    $hour = substr($result["data"]["movieShowtimeList"]["edges"]["$j"]["node"]["showtimes"][$i]["startsAt"], 1 + strpos($result["data"]["movieShowtimeList"]["edges"]["$j"]["node"]["showtimes"][$i]["startsAt"],"T"), 5);
                    $data = array(
                        "cine_id" => $id,
                        "cine_name" => $cine,
                        "movie" => $result["data"]["movieShowtimeList"]["edges"][$j]["node"]["movie"]["title"],
                        "date" => "$date $hour"
                    );
                    $args = http_build_query($data);
                    $out .= "<a href=\"form_party.php?$args\">$hour</a>\n";
                }
                else{
                    $out .="/";
                }
                $out .="</td>\n";
            }
            $out .="\t\t\t</tr>\n";
        }
        $out .="\t\t</tbody>\n";
        $out .="\t</table>\n";
        return $out;
    }

    function list_cinema(){
        $url = "https://www.allocine.fr/_/autocomplete/mobile/theater/" . $_GET["search"];
        $json = file_get_contents($url);
        $search = json_decode($json, true);
        if(isset($search["results"]) && !is_null($search["results"])){
            $out = "<ul>\n";
            for($i = 0; $i < sizeof($search["results"]); $i++){
                $uri = $_SERVER["PHP_SELF"];
                $id = $search["results"][$i]["entity_id"];
                $name = $search["results"][$i]["label"];
                $city = $search["results"][$i]["text_search_data"]["0"];
                $zip = $search["results"][$i]["text_search_data"]["1"];
                $out .= "\t\t<li><a href=\"" . $uri . "?id=" . $id . "&name=" . $name . "\">" . $name . " (" . $city . " - " . $zip . ")</a></li>\n";
            }
            $out .= "\t</ul>\n";
        }
        else{
            $out = "Pas de resultat pour cette recherche !";
        }
        return $out;
    }

    function list_users(){
        $addr = substr($_SERVER["PHP_SELF"], 0, strripos($_SERVER["PHP_SELF"], "/")+1);
        $addr .= "profil.php?id_user=";
        $db = dbInit();
        $query_users = $db->prepare("SELECT id_user, pseudo FROM user");
        $query_users->execute();
        $result = $query_users->fetchAll();
        $noResult = true;
        $out = "<ul>\n";
        foreach($result as $line){
            if(stripos($line[1], $_GET["search"]) !== false){
                $out .= "\t\t<li><a href=\"" . $addr . $line[0] . "\">" . $line[1] . "</a></li>\n";
                $noResult = false;
            }
        }
        if($noResult){
            $out .= "<li>Pas de resultat pour cette recherche</li>";
        }
        $out .= "\t</ul>\n";
        return $out;
    }

    function list_party(){
        $addr = substr($_SERVER["PHP_SELF"], 0, strripos($_SERVER["PHP_SELF"], "/")+1);
        $addr .= "party.php?name=";
        $db = dbInit();
        $query_party = $db->prepare("SELECT * FROM party");
        $query_party->execute();
        $result = $query_party->fetchAll();
        $noResult = true;
        $out = "<ul>\n";
        $filters = [];
        if(isset($_GET["cine_name"]) && !empty($_GET["cine_name"])){
            $filters["cine_name"] = false;
        }
        if(isset($_GET["movie"]) && !empty($_GET["movie"])){
            $filters["movie"] = false;
        }
        if(isset($_GET["search"]) && !empty($_GET["search"])){
            $filters["search"] = false;
        }
        foreach($result as $line){
            if(isset($filters["search"])){
                if(stripos($line[0], $_GET["search"]) !== false){
                    $filters["search"] = true;
                }
            }
            if(isset($filters["movie"])){
                $url = "https://www.allocine.fr/_/autocomplete/mobile/movie/" . $_GET["movie"];
                $json = file_get_contents($url);
                $search = json_decode($json, true);
                if(isset($search["results"]) && !is_null($search["results"])){
                    for($i = 0; $i < sizeof($search["results"]); $i++){
                        $name = $search["results"][$i]["label"];
                        if($name == $line[4]){
                            $filters["movie"] = true;
                        }
                    }
                }
            }
            if(isset($filters["cine_name"])){
                $url = "https://www.allocine.fr/_/autocomplete/mobile/theater/" . $_GET["cine_name"];
                $json = file_get_contents($url);
                $search = json_decode($json, true);
                if(isset($search["results"]) && !is_null($search["results"])){
                    for($i = 0; $i < sizeof($search["results"]); $i++){
                        $name = $search["results"][$i]["label"];
                        if($name == $line[3]){
                            $filters["cine_name"] = true;
                        }
                    }
                }
            }
            $correct = true;
            foreach($filters as $k => $v){
                if($v == false){
                    $correct = false;
                }
                $filters[$k] = false;
            }
            if($correct){
                $noResult = false;
                $out .= "\t\t<li><a href=\"" . $addr . $line[0] . "\">" . $line[0] . " - " . $line[1] . "</a></li>\n";
            }
        }
        if($noResult){
            $out .= "<li>Pas de resultat pour cette recherche</li>";
        }
        $out .= "\t</ul>\n";
        return $out;
    }
?>
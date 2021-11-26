<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require './PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';
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
          $mail->Host       = 'smtp-movieparty.alwaysdata.net';                            // serveur SMTP
          $mail->SMTPAuth   = true;                                            // le serveur SMTP nécessite une authentification ("false" sinon)
          $mail->Username   = 'movieparty@alwaysdata.net';     // login SMTP
          $mail->Password   = 'zizicacamixtape123456789*';                                                // Mot de passe SMTP
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
?>
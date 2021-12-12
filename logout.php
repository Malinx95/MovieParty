<?php
    session_start();
    if(isset($_SESSION["id_user"])){
        unset($_SESSION["id_user"]);
        unset($_SESSION["pseudo"]);
        session_destroy();
        $_SESSION = array();
    }
    header("Location: index.php");
?>

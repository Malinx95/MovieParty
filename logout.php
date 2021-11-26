<?php
    session_start();
    if(isset($_SESSION["pseudo"])){
        unset($_SESSION["pseudo"]);
        session_destroy();
        $_SESSION = array();
    }
    header("Location: test.php");
?>

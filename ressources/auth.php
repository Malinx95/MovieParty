<?php

    function dbInit(){
        $dsn = 'mysql:dbname=movieparty_db;host=mysql-movieparty.alwaysdata.net';
        $user = '244287';
        $password = 'x772hs44PYeCwbq';
        try{
            $db = new PDO($dsn, $user, $password);
            return $db;
        } catch (PDOException $e) {
            echo 'Échec lors de la connexion : ' . $e->getMessage();
            return null;
        }
    }
    
?>
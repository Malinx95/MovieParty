<?php
    require_once 'ressources/auth.php';
    if(isset($_GET["name"]) && $_GET["name"] != "" && isset($_GET["description"]) && isset($_GET["cine_id"]) && isset($_GET["cine_name"]) && isset($_GET["movie"]) && isset($_GET["date"])){

        $db = dbInit();
        $query_register_party = $db->prepare("INSERT INTO party (name, description, cine_id, cine_name, movie, date) VALUES (:name, :description, :cine_id, :cine_name, :movie, :date)");
        $query_register_party->bindParam(":name", $_GET["name"]);
        $query_register_party->bindParam(":description", $_GET["description"]);
        $query_register_party->bindParam(":cine_id", $_GET["cine_id"]);
        $query_register_party->bindParam(":cine_name", $_GET["cine_name"]);
        $query_register_party->bindParam(":movie", $_GET["movie"]);
        $query_register_party->bindParam(":date", $_GET["date"]);
        if($query_register_party->execute()){
            $msg = "succesfully registered";
            echo($msg);
        }
        else{
            $error = $query_register_party->errorInfo();
            $out = "";
            foreach($error as $key => $value){
                $out .= "$value / ";
            }
            $data = array ();
            if(isset($_GET["name"])){
                $data["name"] = $_GET["name"];
            }
            if(isset($_GET["description"])){
                $data["description"] = $_GET["description"];
            }
            if(isset($_GET["cine_id"])){
                $data["cine_id"] = $_GET["cine_id"];
            }
            if(isset($_GET["cine_name"])){
                $data["cine_name"] = $_GET["cine_name"];
            }
            if(isset($_GET["movie"])){
                $data["movie"] = $_GET["movie"];
            }
            if(isset($_GET["date"])){
                $data["date"] = $_GET["date"];
            }
            $data["error"] = $out;
            $args = http_build_query($data);
            header("Location: form_party.php?$args");
        }

    }
    else {
        $data = array ();
        if(isset($_GET["name"])){
            $data["name"] = $_GET["name"];
        }
        if(isset($_GET["description"])){
            $data["description"] = $_GET["description"];
        }
        if(isset($_GET["cine_id"])){
            $data["cine_id"] = $_GET["cine_id"];
        }
        if(isset($_GET["cine_name"])){
            $data["cine_name"] = $_GET["cine_name"];
        }
        if(isset($_GET["movie"])){
            $data["movie"] = $_GET["movie"];
        }
        if(isset($_GET["date"])){
            $data["date"] = $_GET["date"];
        }
        $data["error"] = "Il manque une donnée !";
        $args = http_build_query($data);
        

        header("Location: form_party.php?$args");
    }

?>
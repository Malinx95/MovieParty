<?php

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
    else{
        $cine = "name not found";
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
                $hour =substr($result["data"]["movieShowtimeList"]["edges"]["$j"]["node"]["showtimes"][$i]["startsAt"], 1 + strpos($result["data"]["movieShowtimeList"]["edges"]["$j"]["node"]["showtimes"][$i]["startsAt"],"T"), 5);
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
    echo($out);

?>
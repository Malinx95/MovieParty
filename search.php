<!DOCTYPE html>
<html>
<head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>horraire</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
		<link rel="stylesheet" href="main.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="function.js"></script>
</head>
<body>

	<form action="" method="get">
        <label for="cinema">Chercher un cinema:
            <input type="text" name="search" id="cinema" placeholder="rechercher" <?php if(isset($_GET["cinema"]) && !empty($_GET["cinema"])){echo("value=\""); echo($_GET["cinema"]); echo("\"");} ?> required>
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
		include "function.php";

		if(isset($_GET["search"]) && !empty($_GET["search"]) && isset($_GET["option"]) && $_GET["option"] == "cinema"){
			echo(list_cinema());
		}
		if(isset($_GET["id"]) && !is_null($_GET["id"])){
			echo(table_showtimes());
		}
    ?>
</body>
</html>
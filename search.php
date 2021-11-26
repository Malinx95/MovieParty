<!DOCTYPE html>
<html>
<head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>horraire</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
		<link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="function.js"></script>
</head>
<body>

	<form action="" method="get">
        <label for="cinema">Chercher un cinema:
            <input type="text" name="cinema" id="cinema" placeholder="nom du cinema" <?php if(isset($_GET["cinema"]) && !empty($_GET["cinema"])){echo("value=\""); echo($_GET["cinema"]); echo("\"");} ?> required>
        </label>
        <input type="submit" value="Rechercher">
    </form>
    <?php
		include "function.php";

		if(isset($_GET["cinema"]) && !empty($_GET["cinema"])){
			echo(list_cinema());
		}
		if(isset($_GET["id"]) && !is_null($_GET["id"])){
			echo(table_showtimes());
		}
    ?>
</body>
</html>
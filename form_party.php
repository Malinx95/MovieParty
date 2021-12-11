<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form party</title>
</head>
<body>

    <?php
        if(isset($_GET["error"])){
            $error = $_GET["error"];
            echo("<h1>$error</h1>\n");
        }
    ?>

    <form action="add_party.php" method="get">
        <div>
            <label>Nom du group : 
                <input type="text" name="name" maxlength="50" <?php if(isset($_GET["name"])){echo("value=\"" . $_GET["name"] . "\"");}?> required >
            </label>
        </div>
        <div>
            <label>Description : 
                <input type="text" name="description" maxlength="500" <?php if(isset($_GET["description"])){echo("value=\"" . $_GET["description"] . "\"");}?> required>
            </label>
        </div>
        <div>
            <input type="text" name="cine_id" <?php if(isset($_GET["cine_id"])){echo("value=\"" . $_GET["cine_id"] . "\"");}?> readonly hidden required>
            <input type="text" name="id_user" <?php if(isset($_GET["id_user"])){echo("value=\"" . $_GET["id_user"] . "\"");}?> readonly hidden required>
        </div>
        <div>
            <label>Cinema : 
                <input type="text" name="cine_name" maxlength="50" <?php if(isset($_GET["cine_name"])){echo("value=\"" . $_GET["cine_name"] . "\"");}?> readonly required>
            </label>
        </div>
        <div>
            <label>Film :
                <input type="text" name="movie" maxlength="50" <?php if(isset($_GET["movie"])){echo("value=\"" . $_GET["movie"] . "\"");}?> readonly required>
            </label>
        </div>
        <div>
            <label>Date :
                <input type="text" name="date" <?php if(isset($_GET["date"])){echo("value=\"" .  $_GET["date"] . "\"");}?> readonly required>
            </label>
        </div>
        <div>
            <input type="submit" value="cree le groupe">
        </div>
        

    </form>
</body>
</html>
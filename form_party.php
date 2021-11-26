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
            <label>Nom du group
                <input type="text" name="name" maxlength="50" <?php if(isset($_GET["name"])){echo("value=\"" . $_GET["name"] . "\"");}?> >
            </label>
        </div>
        <div>
            <label>Description
                <input type="text" name="description" maxlength="500" <?php if(isset($_GET["description"])){echo("value=\"" . $_GET["description"] . "\"");}?> required>
            </label>
        </div>
        <div>
            <label>cine_id
                <input type="text" name="cine_id" minlength="5" maxlength="5" <?php if(isset($_GET["cine_id"])){echo("value=\"" . $_GET["cine_id"] . "\"");}?> required>
            </label>
        </div>
        <div>
            <label>cine_name
                <input type="text" name="cine_name" maxlength="50" <?php if(isset($_GET["cine_name"])){echo("value=\"" . $_GET["cine_name"] . "\"");}?> required>
            </label>
        </div>
        <div>
            <label>movie
                <input type="text" name="movie" maxlength="50" <?php if(isset($_GET["movie"])){echo("value=\"" . $_GET["movie"] . "\"");}?> required>
            </label>
        </div>
        <div>
            <label>date
                <input type="text" name="date" <?php if(isset($_GET["date"])){echo("value=\"" .  $_GET["date"] . "\"");}?> required>
            </label>
        </div>
        <div>
            <input type="submit" value="cree le groupe">
        </div>
        

    </form>
</body>
</html>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Degorttle</title>
    </head>
    <body>

        <?php

            include("Includes/Battle.php");
            
            // s obzirom da je u zadatku rečeno da će se podaci stvarno i nalaziti tamo, onda ovo nije potrebno
            // $one = htmlspecialchars($_GET["army1"]) === 0 ? rand(10, 25) : htmlspecialchars($_GET["army1"]);
            // $two = htmlspecialchars($_GET["army2"]) === 0 ? rand(10, 25) : htmlspecialchars($_GET["army2"]);
            
            echo $army1 = new Army(htmlspecialchars($_GET["army1"]));
            echo $army2 = new Army(htmlspecialchars($_GET["army2"]));
            
            $battle = new Battle($army1, $army2);
            $battle->startBattle();
        ?>

    </body>
</html>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>My First PHP Roleplay game</title>

        <?php include_once "assets/php/Character.php"; ?>
    </head>
    <body>

        <?php

            $player = new Character(120, 8, 12, 18);
            $enemy = new Character(200, 15, 10, 5);

            $player->setName("Gandalf");
            $enemy->setName("Sauron");

            echo $player->getName() . " vs. " . $enemy->getName() . "<br />";
        ?>

    </body>
</html>
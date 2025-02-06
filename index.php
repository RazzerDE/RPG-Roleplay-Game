<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My First PHP Roleplay game</title>
</head>
<body>

    <?php include_once "assets/php/Character.php";

        $character = new Character("Gandalf", 120, 8, 12, 18);
        $character->setHealthPoints(100);

        echo "Name: " . $character->getName() . "<br />";
        echo "Lebenspunkte: " . $character->getHealthPoints();

    ?>

</body>
</html>
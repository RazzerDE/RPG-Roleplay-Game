<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>My First PHP Roleplay game</title>

        <script> <!-- don't make attack again on page reload (is annoying) -->
            if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }
        </script>

        <?php
            require_once "assets/php/class/Character.php";
            require_once "assets/php/form.php";

            // use session to store the characters
            // without a session, the characters would be reset on every form.php submission
            session_start();

            // initialize the characters and handle the attack action
            initCharacters();

            echo $_SESSION['player']->getName() . " vs. " . $_SESSION['enemy']->getName() . "<br /><br />";
        ?>
    </head>
    <body>

        <form method="post">
            <div>
                <label for="weapon">Waffenart (Schwert/Dolch/etc):</label>
                <input type="text" id="weapon" name="weapon" required>
            </div>
            <div>
                <label for="block_dir">Blockrichtung (unten/mitte/oben):</label>
                <input type="text" id="block_dir" name="block_dir" required>
            </div>

            <button type="submit" name="attack" style="margin-top: 0.5rem;">Angreifen</button>

            <div style="margin-top: 2rem;">
                <label for="player_hp" >Spieler HP:</label>
                <input id="player_hp" type="text" readonly style="width: 3rem;"
                       value="<?php echo $_SESSION['player']->getHealth(); ?>">
            </div>
            <div>
                <label for="enemy_hp">Gegner HP:</label>
                <input id="enemy_hp" type="text" readonly style="width: 3rem;"
                       value="<?php echo $_SESSION['enemy']->getHealth(); ?>">
            </div>
        </form>

    </body>
</html>
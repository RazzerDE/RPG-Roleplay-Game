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
        ?>
    </head>
    <body style="display: flex; flex-direction: column; align-items: center;">
        
        <!-- title of page -->    
        <?php echo "<h1>" . $_SESSION['player']->getName() . " vs. " . $_SESSION['enemy']->getName() . "</h1>"; ?>

        <form method="post" style="display: flex; flex-direction: column;">
            <!-- Pick weapon type -->
            <div style="display: flex; flex-direction: column; align-items: center;">
                <label for="weapon">Waffenart:</label>

                <div>
                    <input type="radio" id="weapon_schwert" name="weapon" value="Schwert" required 
                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>>
                    <label for="weapon_schwert">Schwert</label>

                    <input type="radio" id="weapon_dolch" name="weapon" value="Dolch"
                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>>
                    <label for="weapon_dolch">Dolch</label>

                    <input type="radio" id="weapon_bogen" name="weapon" value="Bogen"
                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>>
                    <label for="weapon_bogen">Bogen</label>

                    <input type="radio" id="weapon_feuerball" name="weapon" value="Feuerball"
                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>>
                    <label for="weapon_feuerball">Feuerball</label>

                    <input type="radio" id="weapon_magischer_schlag" name="weapon" value="Magischer Schlag"
                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>>
                    <label for="weapon_magischer_schlag">Magischer Schlag</label>
                </div>
            </div>

            <!-- Pick block direction -->
            <div style="display: flex; flex-direction: column; align-items: center; margin-top: 1rem;">
                <label for="block_dir">Blockrichtung:</label>

                <div>
                    <input type="radio" id="block_unten" name="block_dir" value="unten" required
                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>>
                    <label for="block_unten">Unten</label>
                    
                    <input type="radio" id="block_mitte" name="block_dir" value="mitte"
                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>>
                    <label for="block_mitte">Mitte</label>
                    
                    <input type="radio" id="block_oben" name="block_dir" value="oben"
                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>>
                    <label for="block_oben">Oben</label>
                </div>
            </div>
            
            <div style="display: flex; flex-direction: row; column-gap: 1rem; justify-content: center;">
                <!-- Attack button -->
                <button type="submit" name="attack" style="margin-top: 1rem; align-self: center;" 
                <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>>
                    Angreifen
                </button>

                <!-- Restart button -->
                <button type="submit" name="restart" style="margin-top: 1rem; align-self: center;" 
                <?php echo ($_SESSION['player']->getHealth() > 0 && $_SESSION['enemy']->getHealth() > 0) ? 'disabled' : '' ?>>
                    Spiel neustarten
                </button>
            </div>

            <!-- Show health of players -->
            <div style="display: flex; margin-top: 2rem; column-gap: 2rem; justify-content: center;">
                <div>
                    <label for="player_hp" >Spieler HP:</label>
                    <input id="player_hp" type="text" readonly style="width: 3rem;"
                        value="<?php echo $_SESSION['player']->getHealth(); ?>">
                </div>
                <div>
                    <label for="enemy_hp">Gegner HP:</label>
                    <input id="enemy_hp" type="text" readonly style="width: 3rem;"
                        value="<?php echo $_SESSION['enemy']->getHealth(); ?>">
                </div>
            </div>
        </form>

        <div class="margin-top: 2rem;">
            <?php
                // Set winner
                if ($_SESSION['player']->getHealth() <= 0) {
                    echo "<h2>Du hast verloren.. 😢</h2>";

                } elseif ($_SESSION['enemy']->getHealth() <= 0 && $_SESSION['player']->getSkillPoints() == 0) {
                    $_SESSION['player']->addSkillPoints(2); // add skill points
                    $_SESSION['isWinner'] = true;
                    echo "<h2>Du hast gewonnen! 🥳</h2>";
                }
            ?>

            <!-- Show form to skill -->
            <?php if (isset($_SESSION['isWinner']) && $_SESSION['isWinner'] && $_SESSION['player']->getSkillPoints() > 0) : ?>
                <form method="post" style="display: flex; flex-direction: column; align-items: center; margin-top: 2rem;">
                    <h2>Skillpunkte verteilen</h2>
                    <p>Du hast <?php echo $_SESSION['player']->getSkillPoints(); ?> Skillpunkte zur Verfügung!</p>
                    
                    <div>
                        <label for="health_points">Gesundheit:</label>
                        <input type="number" id="health_points" name="health_points" value="0" min="0" max="<?php echo $_SESSION['player']->getSkillPoints(); ?>">
                    </div>

                    <div>
                        <label for="strength_points">Stärke:</label>
                        <input type="number" id="strength_points" name="strength_points" value="0" min="0" max="<?php echo $_SESSION['player']->getSkillPoints(); ?>">
                    </div>

                    <div>
                        <label for="dexterity_points">Geschicklichkeit:</label>
                        <input type="number" id="dexterity_points" name="dexterity_points" value="0" min="0" max="<?php echo $_SESSION['player']->getSkillPoints(); ?>">
                    </div>

                    <div>
                        <label for="intelligence_points">Intelligenz:</label>
                        <input type="number" id="intelligence_points" name="intelligence_points" value="0" min="0" max="<?php echo $_SESSION['player']->getSkillPoints(); ?>">
                    </div>

                    <button type="submit" name="distribute_points" style="margin-top: 1rem;">Punkte verteilen</button>
                </form>
            <?php endif; ?>
    </div>

    </body>
</html>
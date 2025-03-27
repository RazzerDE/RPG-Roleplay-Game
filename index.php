<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            require_once "assets/php/class/Character.php";
            require_once "assets/php/form.php";

            // use session to store the characters
            // without a session, the characters would be reset on every form.php submission
            session_start();

            // initialize the characters and handle the attack action
            initCharacters();
        ?>

        <meta charset="UTF-8">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/elements.css">
        <link rel="icon" type="image/png" href="assets/img/favicon.png">
        <title>RPG Game - <?php echo $_SESSION['player']->getName() . " vs. " . $_SESSION['enemy']->getName(); ?></title>

        <script>
            <!-- don't make POST requests again on page reload (is annoying) -->
            if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }
        </script>
    </head>
    <body style="display: flex; flex-direction: column; align-items: center;">
        
    <!-- Page Title -->
    <h1 style="text-align: center; margin-bottom: 20px;">
        <?php echo "<h1>" . $_SESSION['player']->getName() . " vs. " . $_SESSION['enemy']->getName() . "</h1>"; ?>
        <br />
    </h1>

    <form method="POST">
        <div class="game-container">
            <!-- Player Character -->
            <?php if ($_SESSION['player']) : ?>
                <div class="character-panel">
                    <div class="panel-title">Mein Charakter</div>

                    <!-- Player Stats -->
                    <div class="stat-item">
                        <img src="assets/img/heart.png" alt="Health-Icon" class="stat-icon" />
                        <span>Lebenspunkte: <?php echo $_SESSION['player']->getHealth(); ?></span>
                    </div>
                    <div class="stat-item">
                        <img src="assets/img/strength.png" alt="Strength-Icon" class="stat-icon" />
                        <span>Stärke: <?php echo $_SESSION['player']->getStrength(); ?></span>
                    </div>
                    <br />
                    <div class="stat-item">
                        <img src="assets/img/brain.png" alt="Intelligence-Icon" class="stat-icon" />
                        <span>Intelligenz: <?php echo $_SESSION['player']->getIntelligence(); ?></span>
                    </div>
                    <div class="stat-item">
                        <img src="assets/img/dexterity.png" alt="Dexterity-Icon" class="stat-icon" />
                        <span>Geschicklichkeit: <?php echo $_SESSION['player']->getDexterity(); ?></span>
                    </div>

                    <!-- Pick weapon to attack -->
                    <div style="margin-top: 15px;">
                        <label for="weapon" class="panel-title">Waffenauswahl</label>
                        <div style="height: 10px;"></div>

                        <div class="radio-group row">
                            <div>
                                <input type="radio" id="weapon_schwert" name="weapon" value="Schwert" required
                                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>
                                >
                                <img src="assets/img/outline/sword.svg" alt="Sword-Icon" class="stat-icon invert" />
                                <label for="weapon_schwert">Schwert</label>
                            </div>

                            <div>
                                <input type="radio" id="weapon_dolch" name="weapon" value="Dolch"
                                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>
                                >
                                <img src="assets/img/outline/knife.svg" alt="Dagger-Icon" class="stat-icon invert" />
                                <label for="weapon_dolch">Dolch</label>
                            </div>

                            <div>
                                <input type="radio" id="weapon_bogen" name="weapon" value="Bogen"
                                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>
                                >
                                <img src="assets/img/outline/bow.svg" alt="Bow-Icon" class="stat-icon invert" />
                                <label for="weapon_bogen">Bogen</label>
                            </div>
                        </div>

                        <div class="radio-group row" style="margin-top: 6px;">
                            <div>
                                <input type="radio" id="weapon_feuerball" name="weapon" value="Feuerball"
                                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>
                                >
                                <img src="assets/img/outline/fireball.svg" alt="Bow-Icon" class="stat-icon invert" />
                                <label for="weapon_feuerball">Feuerball</label>
                            </div>

                            <div>
                                <input type="radio" id="weapon_magischer_schlag" name="weapon" value="Magischer Schlag"
                                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>
                                >
                                <img src="assets/img/outline/magic_hit.svg" alt="Magic Hit-Icon" class="stat-icon invert" />
                                <label for="weapon_magischer_schlag">Magischer Schlag</label>
                            </div>
                        </div>
                    </div>

                    <!-- Pick block direction to defend -->
                    <div style="margin-top: 15px;">
                        <label for="block_dir" class="panel-title">Blockrichtung</label>
                        <div style="height: 10px;"></div>

                        <div class="radio-group column">
                            <div>
                                <input type="radio" id="block_oben" name="block_dir" value="oben" required
                                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>
                                >
                                <img src="assets/img/outline/up.svg" alt="Up-Icon" class="stat-icon invert" />
                                <label for="block_oben">Oben</label>
                            </div>
                            <div>
                                <input type="radio" id="block_mitte" name="block_dir" value="mitte"
                                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>
                                >
                                <img src="assets/img/outline/right.svg" alt="Right-Icon" class="stat-icon invert" />
                                <label for="block_mitte">Mitte</label>
                            </div>
                            <div>
                                <input type="radio" id="block_unten" name="block_dir" value="unten"
                                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>
                                >
                                <img src="assets/img/outline/down.svg" alt="Down-Icon" class="stat-icon invert" />
                                <label for="block_unten">Unten</label>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Enemy Character -->
            <?php if ($_SESSION['enemy']) : ?>
            <div class="character-panel" style="display: flex; flex-direction: column;">
                <div class="panel-title">Gegner - <?php echo $_SESSION['enemy']->getName() ?></div>

                <div class="stat-item">
                    <img src="assets/img/heart.png" alt="Health-Icon" class="stat-icon" />
                    <span>Lebenspunkte: <?php echo $_SESSION['enemy']->getHealth(); ?></span>
                </div>
                <div class="stat-item">
                    <img src="assets/img/strength.png" alt="Strength-Icon" class="stat-icon" />
                    <span>Stärke: <?php echo $_SESSION['enemy']->getStrength(); ?></span>
                </div>
                <br />
                <div class="stat-item">
                    <img src="assets/img/brain.png" alt="Intelligence-Icon" class="stat-icon" />
                    <span>Intelligenz: <?php echo $_SESSION['enemy']->getIntelligence(); ?></span>
                </div>
                <div class="stat-item">
                    <img src="assets/img/dexterity.png" alt="Dexterity-Icon" class="stat-icon" />
                    <span>Geschicklichkeit: <?php echo $_SESSION['enemy']->getDexterity(); ?></span>
                </div>

                <div style="margin-top: 5px;">
                    <div class="panel-title">Kampffortschritt</div>
                    <?php
                        // calculate progress for bar
                        $maxEnemyHealth = $_SESSION['enemy']->getMaxHealth();
                        $currentEnemyHealth = $_SESSION['enemy']->getHealth();
                        $healthLost = $maxEnemyHealth - $currentEnemyHealth;
                        $progressPercentage = ($healthLost / $maxEnemyHealth) * 100;

                        // set unique color based on $progressPercentage
                        $barColor = "#FF5252"; // red
                        if ($progressPercentage >= 25 && $progressPercentage < 75) {
                            $barColor = "#FFA726"; // orange
                        } elseif ($progressPercentage >= 75) {
                            $barColor = "#66BB6A"; // green
                        }
                    ?>

                    <div class="progress-bar">
                        <div style="height: 100%; width: <?php echo $progressPercentage; ?>%; background-color: <?php echo $barColor; ?>"></div>
                    </div>
                </div>

                <div class="hp-display" style="margin-top: 15px;">
                    <div class="hp-input">
                        <label for="player_hp">Spieler's Leben:</label>
                        <input id="player_hp" type="text" value="<?php echo $_SESSION['player']->getHealth(); ?>" readonly>
                    </div>
                    <div class="hp-input">
                        <label for="enemy_hp">Gegner's Leben:</label>
                        <input id="enemy_hp" type="text" value="<?php echo $_SESSION['enemy']->getHealth(); ?>" readonly>
                    </div>
                </div>

<!--                <div class="game-status">-->
<!--                    Du hast gewonnen!-->
<!--                </div>-->

<!--                <div class="skill-selection">-->
<!--                    <div class="panel-title">Skill Points: 1</div>-->
<!--                    <div class="radio-group">-->
<!--                        <label>-->
<!--                            <input type="radio" name="skill" value="health">-->
<!--                            Health-->
<!--                        </label>-->
<!--                        <label>-->
<!--                            <input type="radio" name="skill" value="strength">-->
<!--                            Strength-->
<!--                        </label>-->
<!--                        <label>-->
<!--                            <input type="radio" name="skill" value="dexterity">-->
<!--                            Dexterity-->
<!--                        </label>-->
<!--                        <label>-->
<!--                            <input type="radio" name="skill" value="intelligence">-->
<!--                            Intelligence-->
<!--                        </label>-->
<!--                    </div>-->
<!--                    <button class="btn skill-upgrade-btn">Skill Aufwerten</button>-->
<!--                </div>-->

                <div class="action-buttons" style="margin-top: auto;">
                    <button class="btn btn-attack" type="submit" name="attack"
                        <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>>
                        Angreifen
                    </button>
                    <button class="btn btn-reset" type="submit" name="restart"
                        <?php echo ($_SESSION['player']->getHealth() > 0 && $_SESSION['enemy']->getHealth() > 0) ? 'disabled' : '' ?>>
                        Nächste Runde
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </form>

    </body>
</html>
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
                    <div class="panel-title">My Character</div>

                    <!-- Player Stats -->
                    <div class="stat-item">
                        <img src="assets/img/heart.png" alt="Health-Icon" class="stat-icon" />
                        <span>Health: <?php echo $_SESSION['player']->getHealth(); ?></span>
                    </div>
                    <div class="stat-item">
                        <img src="assets/img/strength.png" alt="Strength-Icon" class="stat-icon" />
                        <span>Strength: <?php echo $_SESSION['player']->getStrength(); ?></span>
                    </div>
                    <br />
                    <div class="stat-item">
                        <img src="assets/img/brain.png" alt="Intelligence-Icon" class="stat-icon" />
                        <span>Intelligence: <?php echo $_SESSION['player']->getIntelligence(); ?></span>
                    </div>
                    <div class="stat-item">
                        <img src="assets/img/dexterity.png" alt="Dexterity-Icon" class="stat-icon" />
                        <span>Dexterity: <?php echo $_SESSION['player']->getDexterity(); ?></span>
                    </div>

                    <!-- Pick weapon to attack -->
                    <div style="margin-top: 15px;">
                        <label for="weapon" class="panel-title">Weapontype</label>
                        <div style="height: 10px;"></div>

                        <div class="radio-group row">
                            <div>
                                <input type="radio" id="weapon_schwert" name="weapon" value="Schwert" required
                                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>
                                >
                                <img src="assets/img/outline/sword.svg" alt="Sword-Icon" class="stat-icon invert" />
                                <label for="weapon_schwert">Sword</label>
                            </div>

                            <div>
                                <input type="radio" id="weapon_dolch" name="weapon" value="Dolch"
                                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>
                                >
                                <img src="assets/img/outline/knife.svg" alt="Dagger-Icon" class="stat-icon invert" />
                                <label for="weapon_dolch">Dagger</label>
                            </div>

                            <div>
                                <input type="radio" id="weapon_bogen" name="weapon" value="Bogen"
                                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>
                                >
                                <img src="assets/img/outline/bow.svg" alt="Bow-Icon" class="stat-icon invert" />
                                <label for="weapon_bogen">Bow</label>
                            </div>
                        </div>

                        <div class="radio-group row" style="margin-top: 6px;">
                            <div>
                                <input type="radio" id="weapon_feuerball" name="weapon" value="Feuerball"
                                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>
                                >
                                <img src="assets/img/outline/fireball.svg" alt="Bow-Icon" class="stat-icon invert" />
                                <label for="weapon_feuerball">Fireball</label>
                            </div>

                            <div>
                                <input type="radio" id="weapon_magischer_schlag" name="weapon" value="Magischer Schlag"
                                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>
                                >
                                <img src="assets/img/outline/magic_hit.svg" alt="Magic Hit-Icon" class="stat-icon invert" />
                                <label for="weapon_magischer_schlag">Magic Hit</label>
                            </div>
                        </div>
                    </div>

                    <!-- Pick block direction to defend -->
                    <div style="margin-top: 15px;">
                        <label for="block_dir" class="panel-title">Block direction</label>
                        <div style="height: 10px;"></div>

                        <div class="radio-group column">
                            <div>
                                <input type="radio" id="block_oben" name="block_dir" value="oben" required
                                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>
                                >
                                <img src="assets/img/outline/up.svg" alt="Up-Icon" class="stat-icon invert" />
                                <label for="block_oben">Up</label>
                            </div>
                            <div>
                                <input type="radio" id="block_mitte" name="block_dir" value="mitte"
                                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>
                                >
                                <img src="assets/img/outline/right.svg" alt="Right-Icon" class="stat-icon invert" />
                                <label for="block_mitte">Mid</label>
                            </div>
                            <div>
                                <input type="radio" id="block_unten" name="block_dir" value="unten"
                                    <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>
                                >
                                <img src="assets/img/outline/down.svg" alt="Down-Icon" class="stat-icon invert" />
                                <label for="block_unten">Down</label>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Enemy Character -->
            <?php if ($_SESSION['enemy']) : ?>
            <div class="character-panel" style="display: flex; flex-direction: column;">
                <div class="panel-title">Enemy - <?php echo $_SESSION['enemy']->getName() ?></div>

                <div class="stat-item">
                    <img src="assets/img/heart.png" alt="Health-Icon" class="stat-icon" />
                    <span>Health: <?php echo $_SESSION['enemy']->getHealth(); ?></span>
                </div>
                <div class="stat-item">
                    <img src="assets/img/strength.png" alt="Strength-Icon" class="stat-icon" />
                    <span>Strength: <?php echo $_SESSION['enemy']->getStrength(); ?></span>
                </div>
                <br />
                <div class="stat-item">
                    <img src="assets/img/brain.png" alt="Intelligence-Icon" class="stat-icon" />
                    <span>Intelligence: <?php echo $_SESSION['enemy']->getIntelligence(); ?></span>
                </div>
                <div class="stat-item">
                    <img src="assets/img/dexterity.png" alt="Dexterity-Icon" class="stat-icon" />
                    <span>Dexterity: <?php echo $_SESSION['enemy']->getDexterity(); ?></span>
                </div>

                <div style="margin-top: 5px;">
                    <div class="panel-title">Fightprogress</div>
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
                        <label for="player_hp">Player's Health:</label>
                        <input id="player_hp" type="text" value="<?php echo $_SESSION['player']->getHealth(); ?>" readonly>
                    </div>
                    <div class="hp-input">
                        <label for="enemy_hp">Enemy's Health:</label>
                        <input id="enemy_hp" type="text" value="<?php echo $_SESSION['enemy']->getHealth(); ?>" readonly>
                    </div>
                </div>

                <div class="game-status">
                    <?php
                        if ($_SESSION['enemy']->getHealth() <= 0 && $_SESSION['player']->getSkillPoints() == 0) {
                            $_SESSION['player']->addSkillPoints(2); // add skill points
                            $_SESSION['isWinner'] = true;

                            echo "<div class='green'>You won! 🎉</div>";
                        } else if ($_SESSION['player']->getHealth() <= 0) {
                            echo "<div class='red'>You lost.. 😢</div>";
                        }
                    ?>
                </div>

                <?php if (isset($_SESSION['isWinner']) && $_SESSION['isWinner'] && $_SESSION['player']->getSkillPoints() > 0) : ?>
                    <div class="skill-selection" style="margin-bottom: 30px;">
                        <div class="panel-title">Skill Points: <?php echo $_SESSION['player']->getSkillPoints(); ?></div>
                        <div class="radio-group">
                            <label>
                                <input type="checkbox" id="health_points" name="health_points">
                                Health
                            </label>
                            <label>
                                <input type="checkbox" id="strength_points" name="strength_points">
                                Strength
                            </label>
                            <label>
                                <input type="checkbox" id="dexterity_points" name="dexterity_points">
                                Dexterity
                            </label>
                            <label>
                                <input type="checkbox" id="intelligence_points" name="intelligence_points">
                                Intelligence
                            </label>
                        </div>
                        <button type="submit" name="set_skills" class="btn skill-upgrade-btn">Level Up Skills</button>
                    </div>

                <?php endif; ?>

                    <div class="action-buttons" style="margin-top: auto;">
                        <button class="btn btn-attack" type="submit" name="attack"
                            <?php echo ($_SESSION['player']->getHealth() <= 0 || $_SESSION['enemy']->getHealth() <= 0) ? 'disabled' : '' ?>>
                            Attack
                        </button>
                        <button class="btn btn-reset" type="submit" name="restart"
                            <?php echo ($_SESSION['player']->getHealth() > 0 && $_SESSION['enemy']->getHealth() > 0) ? 'disabled' : '' ?>>
                            Next Round
                        </button>
                    </div>
            <?php endif; ?>
        </div>
    </form>

    </body>
</html>
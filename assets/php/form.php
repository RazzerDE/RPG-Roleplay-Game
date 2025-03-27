<?php

    /**
     * Initializes the player and enemy characters if they do not already exist in the session.
     * Handles the attack action triggered via a POST request, updating the health of both characters.
     *
     * @return void
     */
    function initCharacters(): void {
        // create characters if they don't exist yet (or got restarted)
        if (!isset($_SESSION['player']) || !isset($_SESSION['enemy']) || isset($_POST['restart'])) {
            $_SESSION['player'] = new Character(120, 8, 12, 18);
            $_SESSION['player']->setName("Gandalf");

            // add skills to user values if they exist
            if (isset($_SESSION['player_skills'])) {
                updateSkills();
            }

            $_SESSION['isWinner'] = false;

            // pick random enemy
            chooseEnemy();
            return;
        }

        // Check if the 'attack' action has been triggered via a POST request
        if (isset($_POST['attack'])) {

            // Player attacks the enemy with the specified weapon
            $dmg = $_SESSION['player']->attack($_POST['weapon']);
            $enemy_hp = $_SESSION['enemy']->getHealth() - $dmg;
            $_SESSION['enemy']->setHealth($enemy_hp);

            // Enemy defends and counterattacks, player takes damage
            $dmg_taken = $_SESSION['enemy']->defend($_POST['block_dir']);
            $player_hp = $_SESSION['player']->getHealth() - $dmg_taken;
            $_SESSION['player']->setHealth($player_hp);
        }
        
        // something got skilled
        if (isset($_POST['set_skills']) && isset($_SESSION['isWinner'])) {
            $healthPoints = isset($_POST['health_points']) ? 1 : 0;
            $strengthPoints = isset($_POST['strength_points']) ? 1 : 0;
            $dexterityPoints = isset($_POST['dexterity_points']) ? 1 : 0;
            $intelligencePoints = isset($_POST['intelligence_points']) ? 1 : 0;
        
            // verify that points are not exceeding the correct amount
            $totalPoints = $healthPoints + $strengthPoints + $dexterityPoints + $intelligencePoints;
        
            if ($totalPoints <= $_SESSION['player']->getSkillPoints()) {
                $_SESSION['player_skills'] = [ // get skills from session and add new ones
                    'health' => $healthPoints + ($_SESSION['player_skills']['health'] ?? 0),
                    'strength' => $strengthPoints + ($_SESSION['player_skills']['strength'] ?? 0),
                    'dexterity' => $dexterityPoints + ($_SESSION['player_skills']['dexterity'] ?? 0),
                    'intelligence' => $intelligencePoints + ($_SESSION['player_skills']['intelligence'] ?? 0),
                ];

                $_SESSION['isWinner'] = false;
            } else {
                echo "<p style='color: red;'>Du kannst nicht mehr Skillpunkte verteilen, als dir zur Verfügung stehen.</p>";
            }
        }
    }

    /**
     * Selects a random enemy for the player to fight against.
     *
     * This function randomly chooses an enemy from three predefined options:
     * - Sauron (Normal difficulty)
     * - Morgoth (Medium difficulty)
     * - Gul'dan (Hard difficulty)
     *
     * Each enemy has different health, strength, dexterity, and intelligence values.
     * The selected enemy is assigned to the `$_SESSION['enemy']` variable, and their attributes
     * are used for the battle mechanics.
     *
     * @return void
     */
    function chooseEnemy(): void {
        $_SESSION['enemy'] = match (rand(1, 3)) {
            1 => new Character(200, 15, 10, 5, "Sauron"),  // Sauron (Normaler Gegner)
            2 => new Character(300, 20, 12, 8, "Morgoth"), // Morgoth (Stärkerer Gegner)
            default => new Character(500, 30, 18, 15, "Gul'dan"), // Gul'dan (Harter Gegner)
        };
    }

    /**
     * Updates the player's attributes by adding the skill points stored in the session.
     * 
     * This function retrieves the player's current attributes (Health, Strength, Dexterity, Intelligence) 
     * from the session and adds the corresponding skill points from `$_SESSION['player_skills']` to each attribute.
     * 
     * @return void
     */
    function updateSkills(): void {
        $player = $_SESSION['player'];

        $_SESSION['player']->setHealth($player->getHealth() + $_SESSION['player_skills']['health']);
        $_SESSION['player']->setStrength($player->getStrength() + $_SESSION['player_skills']['strength']);
        $_SESSION['player']->setDexterity($player->getDexterity() + $_SESSION['player_skills']['dexterity']);
        $_SESSION['player']->setIntelligence($player->getIntelligence() + $_SESSION['player_skills']['intelligence']);
    }


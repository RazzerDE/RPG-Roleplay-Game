<?php

    /**
     * Initializes the player and enemy characters if they do not already exist in the session.
     * Handles the attack action triggered via a POST request, updating the health of both characters.
     *
     * @return void
     */
    function initCharacters(): void {
        // create characters if they don't exist yet
        if (!isset($_SESSION['player']) || !isset($_SESSION['enemy'])) {
            $_SESSION['player'] = new Character(120, 8, 12, 18);
            $_SESSION['enemy'] = new Character(200, 15, 10, 5);

            $_SESSION['player']->setName("Gandalf");
            $_SESSION['enemy']->setName("Sauron");
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
    }


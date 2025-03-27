<?php

    /**
     * Initialisiert die Spieler- und Gegnercharaktere, sofern sie noch nicht in der Sitzung vorhanden sind.
     * Verarbeitet die über eine POST-Anfrage ausgelöste Angriffsaktion und aktualisiert den Gesundheitszustand beider Charaktere.
     *
     * @return void
     */
    function initCharacters(): void {
        // Charaktere erstellen, wenn sie noch nicht existieren (oder das Spiel neugestartet wurde)
        if (!isset($_SESSION['player']) || !isset($_SESSION['enemy']) || isset($_POST['restart'])) {
            $_SESSION['player'] = new Character(120, 8, 12, 18);
            $_SESSION['player']->setName("Gandalf");

            // Skillpunkte zu den Charakter Werten hinzufügen
            if (isset($_SESSION['player_skills'])) {
                updateSkills();
            }

            $_SESSION['isWinner'] = false;

            // zufälligen Gegner auswählen
            chooseEnemy();
            return;
        }

        // Überprüfe ob eine Angriffsaktion ausgelöst wurde
        if (isset($_POST['attack'])) {

            // Spieler greift den Gegner mit spezifischer Waffe an
            $dmg = $_SESSION['player']->attack($_POST['weapon']);
            $enemy_hp = $_SESSION['enemy']->getHealth() - $dmg;
            $_SESSION['enemy']->setHealth($enemy_hp);

            // Gegner verteidigt sich und kontert den Angriff
            $dmg_taken = $_SESSION['enemy']->defend($_POST['block_dir']);
            $player_hp = $_SESSION['player']->getHealth() - $dmg_taken;
            $_SESSION['player']->setHealth($player_hp);
        }
        
        // ein Skillpunkt wurde vergeben
        if (isset($_POST['set_skills']) && isset($_SESSION['isWinner'])) {
            $healthPoints = isset($_POST['health_points']) ? 1 : 0;
            $strengthPoints = isset($_POST['strength_points']) ? 1 : 0;
            $dexterityPoints = isset($_POST['dexterity_points']) ? 1 : 0;
            $intelligencePoints = isset($_POST['intelligence_points']) ? 1 : 0;
        
            // sicherstellen das die Summe der Skillpunkte <= max Skillpunkte
            $totalPoints = $healthPoints + $strengthPoints + $dexterityPoints + $intelligencePoints;
        
            if ($totalPoints <= $_SESSION['player']->getSkillPoints()) {
                $_SESSION['player_skills'] = [ // aktuelle skillpunkte abfragen und überschreibenwas
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
     * Wählt einen zufälligen Gegner aus, gegen den der Spieler kämpfen soll.
     *
     * Diese Funktion wählt zufällig einen Gegner aus drei vordefinierten Optionen aus:
     * – Sauron (Normaler Schwierigkeitsgrad)
     * – Morgoth (Mittlerer Schwierigkeitsgrad)
     * – Gul'dan (Schwerer Schwierigkeitsgrad)
     *
     * Jeder Gegner hat unterschiedliche Werte für Gesundheit, Stärke, Geschicklichkeit und Intelligenz.
     * Der ausgewählte Gegner wird der Variable `$_SESSION['enemy']` zugewiesen, und seine Attribute
     * werden für die Kampfmechanik verwendet.
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
     * Aktualisiert die Spielerattribute durch Hinzufügen der in der Sitzung gespeicherten Fertigkeitspunkte.
     *
     * Diese Funktion ruft die aktuellen Spielerattribute (Gesundheit, Stärke, Geschicklichkeit, Intelligenz)
     * aus der Sitzung ab und fügt jedem Attribut die entsprechenden Fertigkeitspunkte aus `$_SESSION['player_skills']` hinzu.
     *
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


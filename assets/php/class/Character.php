<?php

class Character {
    // Attribute
    private string $name;
    private int $health;
    private int $strength;
    private int $dexterity; // Geschicklichkeit
    private int $intelligence;

    private int $skillPoints = 0;
    private int $maxHealth = 100;

    // Konstruktor: wird aufgerufen, wenn ein neues Objekt erstellt wird, legt Standardwerte fest
    public function __construct(int $health = 100, int $strength = 10, int $dexterity = 10, int $intelligence = 10,
                                string $name = "Unnamed") {
        $this->health = $health;
        $this->maxHealth = $health;
        $this->strength = $strength;
        $this->dexterity = $dexterity;
        $this->intelligence = $intelligence;
        $this->name = $name;
    }

    //              FIGHT METHODS

    /**
     * Berechnet den Angriffsschaden basierend auf Waffentyp und Charakterstärke.
     *
     * @param string $weapon_type Der für den Angriff verwendete Waffentyp.
     * @return int Der berechnete Schaden des Angriffs.
     */
    public function attack(string $weapon_type): int {
        $baseDmg = match($weapon_type) {
            'Schwert' => 10,
            'Dolch' => 6,
            'Feuerball' => 5 + $this->intelligence * 0.3,
            'Magischer Schlag' => ($this->strength + $this->intelligence) * 0.4, // 40 % der Stärke und Intelligenz
            default => 4
        };

        // 50 % des Stärkeattributs werden zum Basisschaden hinzugefügt
        $dmg = $this->strength * 0.5; // 50 % der Stärke werden allen Angriffen hinzugefügt
        return (int)($baseDmg + $dmg);
    }

    /**
     * Verteidigt einen gegnerischen Angriff durch Blocken in eine bestimmte Richtung.
     *
     * @param string $block_dir Die Richtung, in die der Charakter zu blocken versucht (z. B. „unten“, „mitte“, „oben“).
     * @return int Gibt 0 zurück, wenn der Block erfolgreich ist, andernfalls 10.
     */
    public function defend(string $block_dir): int {
        $enemy_pos = ["unten", "mitte", "oben"][rand(0, 2)];

        if ($block_dir === $enemy_pos) {
            return 0; // block erfolgreich
        }

        return 10; // block fehlgeschlagen
    }


    //              GETTER METHODS


    public function getName(): string {
        return $this->name;
    }

    public function getHealth(): int {
        return $this->health;
    }

    public function getMaxHealth(): int {
        return $this->maxHealth;
    }

    public function getStrength(): int {
        return $this->strength;
    }

    public function getDexterity(): int {
        return $this->dexterity;
    }

    public function getIntelligence(): int {
        return $this->intelligence;
    }

    public function getSkillPoints(): int {
        return $this->skillPoints;
    } 


    //              SETTER METHODS


    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setHealth(int $health): void {
        $this->health = $health;
    }

    public function setStrength(int $strength): void {
        $this->strength = $strength;
    }

    public function setDexterity(int $dexterity): void {
        $this->dexterity = $dexterity;
    }

    public function setIntelligence(int $intelligence): void {
        $this->intelligence = $intelligence;
    }

    public function addSkillPoints(int $points): void {
        $this->skillPoints += $points;
    }
}
<?php

class Character {
    // Attributes
    private string $name;
    private int $health;
    private int $strength;
    private int $dexterity; // Geschicklichkeit
    private int $intelligence;

    private int $skillPoints = 0;
    private int $maxHealth = 100;

    // Constructor: called when a new object is created, set default values
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
     * Calculates the attack damage based on the weapon type and character's strength.
     *
     * @param string $weapon_type The type of weapon used for the attack.
     * @return int The calculated damage of the attack.
     */
    public function attack(string $weapon_type): int {
        $baseDmg = match($weapon_type) {
            'Schwert' => 10,
            'Dolch' => 6,
            'Feuerball' => 5 + $this->intelligence * 0.3,
            'Magischer Schlag' => ($this->strength + $this->intelligence) * 0.4, // 40% of strength and intelligence
            default => 4
        };

        // 50% of the strength attribute is added to the base damage
        $dmg = $this->strength * 10;//0.5; // 50% of strength is added to all attacks
        return (int)($baseDmg + $dmg);
    }

    /**
     * Defends against an enemy attack by blocking in a specified direction.
     *
     * @param string $block_dir The direction in which the character attempts to block (e.g., "unten", "mitte", "oben").
     * @return int Returns 0 if the block is successful, otherwise returns 10.
     */
    public function defend(string $block_dir): int {
        $enemy_pos = ["unten", "mitte", "oben"][rand(0, 2)];

        if ($block_dir === $enemy_pos) {
            return 0; // block success
        }

        return 10; // block failed
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
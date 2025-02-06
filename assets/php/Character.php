<?php

class Character {
    // Attributes
    private string $name;
    private int $health;
    private int $strength;
    private int $dexterity; // Geschicklichkeit
    private int $intelligence;

    // Constructor: called when a new object is created, set default values
    public function __construct(int $health = 100, int $strength = 10, int $dexterity = 10, int $intelligence = 10,
                                string $name = "Unnamed") {
        $this->health = $health;
        $this->strength = $strength;
        $this->dexterity = $dexterity;
        $this->intelligence = $intelligence;
        $this->name = $name;
    }


    //              GETTER METHODS


    public function getName(): string {
        return $this->name;
    }

    public function getHealthPoints(): int {
        return $this->health;
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


    //              SETTER METHODS


    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setHealthPoints(int $health): void {
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
}
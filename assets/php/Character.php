<?php

class Character {
    // Attributes
    private string $name;
    private int $healthPoints;
    private int $strength;
    private int $dexterity;
    private int $intelligence;

    // Constructor: called when a new object is created
    public function __construct(
        string $name = "Unnamed",
        int $healthPoints = 100,
        int $strength = 10,
        int $dexterity = 10,
        int $intelligence = 10
    ) {
        $this->name = $name;
        $this->healthPoints = $healthPoints;
        $this->strength = $strength;
        $this->dexterity = $dexterity;
        $this->intelligence = $intelligence;
    }


    //              GETTER METHODS


    public function getName(): string {
        return $this->name;
    }

    public function getHealthPoints(): int {
        return $this->healthPoints;
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

    public function setHealthPoints(int $healthPoints): void {
        $this->healthPoints = $healthPoints;
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
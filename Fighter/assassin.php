<?php

require_once 'fighter.php';
require_once 'tank.php';
require_once 'warrior.php';

class Assassin extends Fighter{
    public static $BaseHealth = 4;
    public static $BaseStrength = 7;

    public static $CounterChance = 20;
    public static $picURL = "/images/assassin.jpg";
    public static $Description;

    public function __construct($name){
        $this->health = Assassin::$BaseHealth;
        $this->strength = Assassin::$BaseStrength;

        $this->class = 'Assassin';
        $this->name = $name;
    }


    public function Attack($enemy, $interruptable = true){
        $blocked;
        $countered;
        $doubled = false;

        switch($enemy->class){
            case 'Tank':
                $blocked = AttackTank($enemy, $interruptable);
                break;
            case 'Assassin':
                $countered = AttackAssassin($enemy, $interruptable);
                break;
            case 'Warrior':
                AttackWarrior($enemy);
                break;
        }

        return new Round($this, $enemy, $blocked, $countered, $doubled);
    }

    private function AttackTank($enemy, $interruptable){
        if($interruptable && rand(1, 100) <= Tank::$BlockChance){
            return true;
        }else{
            $enemy->calcHealth -= $this->calcStrength;
            return false;
        }
    }

    private function AttackAssassin($enemy, $interruptable){
        if($interruptable && rand(1, 100) <= Assassin::$CounterChance){
            $enemy->Attack($this, false);
            return true;
        }else{
            $enemy->calcHealth -= $this->calcStrength;
            return false;
        }
    }
    
    private function AttackWarrior($enemy){
        $enemy->calcHealth -= $this->calcStrength;
    }
}

//PHP IS CANCER
Assassin::$Description = 
"The Assassin is a feared killer who attacks when his enemies won't expect it.
He is able to dodge his enemies attack and strike back by a chance of ".Assassin::$CounterChance."%."
;

?>
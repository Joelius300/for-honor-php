<?php

require_once 'fighter.php';
require_once 'assassin.php';
require_once 'warrior.php';
require_once '../lib/round.php';

class Tank extends Fighter{
    public static $BaseHealth = 7;
    public static $BaseStrength = 4;

    public static $BlockChance = 30;
    
    public static $picURL = "/images/tank.jpg";
    public static $Description;


    public function __construct($name){
        $this->health = Tank::$BaseHealth;
        $this->strength = Tank::$BaseStrength;

        $this->class = 'Tank';
        $this->name = $name;
    }

    

    public function Attack($enemy){
        $blocked = false;
        $countered = false;
        $doubled = false;
        
        $winner = null;

        switch($enemy->class){
            case 'Tank':
                $blocked = $this->AttackTank($enemy);
                break;
            case 'Assassin':
                $countered = $this->AttackAssassin($enemy);
                break;
            case 'Warrior':
                $this->AttackWarrior($enemy);
                break;
        }

        if($this->calcHealth < 1){
            $winner = $enemy;
        }else if($enemy->calcHealth < 1){
            $winner = $this;
        }

        return new Round($this, $enemy, $blocked, $countered, $doubled, $winner);
    }

    private function AttackTank($enemy){
        if(rand(1, 100) <= Tank::$BlockChance){
            return true;
        }else{
            $enemy->calcHealth -= $this->calcStrength;
            return false;
        }
    }

    private function AttackAssassin($enemy){
        if(rand(1, 100) <= Assassin::$CounterChance){
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
Tank::$Description = 
"The Tank is able to block incoming hits by a chance of ".Tank::$BlockChance."%.
He is not the deadliest of a fighter, but he is pretty hard to kill because of his massive shield."
;

?>
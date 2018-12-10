<?php

require_once 'fighter.php';
require_once 'assassin.php';
require_once 'warrior.php';

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
        switch($enemy->class){
            case 'Tank':
                AttackTank($enemy);
                break;
            case 'Assassin':
                AttackAssassin($enemy);
                break;
            case 'Warrior':
                AttackWarrior($enemy);
                break;
        }
    }

    private function AttackTank($enemy){
        if(rand(1, 100) <= Tank::$BlockChance){
            return;
        }else{
            $enemy->health -= $this->strength;
        }
    }

    private function AttackAssassin($enemy){
        if(rand(1, 100) <= Assassin::$CounterChance){
            $enemy->Attack($this);
        }else{
            $enemy->health -= $this->strength;
        }
    }
    
    private function AttackWarrior($enemy){
        $enemy->health -= $this->strength;
    }
}

//PHP IS CANCER
Tank::$Description = 
"The Tank is able to block incoming hits by a chance of ".Tank::$BlockChance."%.
He is not the deadliest of a fighter, but he is pretty hard to kill because of his massive shield."
;

?>
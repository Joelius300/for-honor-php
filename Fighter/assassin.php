<?php

require_once 'fighter.php';
require_once 'tank.php';
require_once 'warrior.php';

class Assassin extends Fighter{
    public static $BaseHealth = 4;
    public static $BaseStrength = 7;

    public static $CounterChance = 20;

    public static $Description;

    public function __construct(){
        $this->health = Assassin::$BaseHealth;
        $this->strength = Assassin::$BaseStrength;

        $this->class = 'Assassin';
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
Assassin::$Description = 
"The Assassin is a feared killer who attacks when his enemies won't expect it.
He is able to dodge his enemies attack and strike back by a chance of ".Assassin::$CounterChance."%."
;

?>
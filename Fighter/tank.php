<?php

require_once 'fighter.php';
require_once 'assassin.php';
require_once 'warrior.php';

class Tank extends Fighter{
    public static $BaseHealth = 7;
    public static $BaseStrength = 4;

    public $BlockChance = 30;

    public function __construct(){
        $this->health = Tank::$BaseHealth;
        $this->strength = Tank::$BaseStrength;

        $this->class = 'Tank';
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
        if(rand(1, 100) <= $enemy->BlockChance){
            return;
        }else{
            $enemy->health -= $this->strength;
        }
    }

    private function AttackAssassin($enemy){
        if(rand(1, 100) <= $enemy->CounterChance){
            $enemy->Attack($this);
        }else{
            $enemy->health -= $this->strength;
        }
    }
    
    private function AttackWarrior($enemy){
        $enemy->health -= $this->strength;
    }
}


?>
<?php

require_once 'fighter.php';
require_once 'tank.php';
require_once 'warrior.php';

class Assassin extends Fighter{
    public static $BaseHealth = 4;
    public static $BaseStrength = 7;

    public $CounterChance = 20;

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
<?php

require_once 'fighter.php';
require_once 'tank.php';
require_once 'assassin.php';

class Warrior extends Fighter{
    public static $BaseHealth = 6;
    public static $BaseStrength = 5;

    public $DoubleHitChance = 50;

    public function __construct(){
        $this->health = Warrior::$BaseHealth;
        $this->strength = Warrior::$BaseStrength;

        $this->class = 'Warrior';
    }


    public function Attack($enemy){
        switch($enemy->class){
            case 'Tank':
                AttackTank($enemy, false);
                break;
            case 'Assassin':
                AttackAssassin($enemy, false);
                break;
            case 'Warrior':
                AttackWarrior($enemy, false);
                break;
        }
    }

    private function AttackTank($enemy, $second){
        if(rand(1, 100) <= $enemy->BlockChance){
            return;
        }else{
            $enemy->health -= $this->strength;

            if(!$second && rand(1, 100) <= $this->DoubleHitChance){
                $this->AttackTank($enemy, true);
            }
        }
    }

    private function AttackAssassin($enemy, $second){
        if(rand(1, 100) <= $enemy->CounterChance){
            $enemy->Attack($this);
        }else{
            $enemy->health -= $this->strength;

            if(!$second && rand(1, 100) <= $this->DoubleHitChance){
                $this->AttackAssassin($enemy, true);
            }
        }
    }
    
    private function AttackWarrior($enemy, $second){
        $enemy->health -= $this->strength;

        if(!$second && rand(1, 100) <= $this->DoubleHitChance){
            $this->AttackWarrior($enemy, true);
        }
    }
}


?>
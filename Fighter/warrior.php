<?php

require_once 'fighter.php';
require_once 'tank.php';
require_once 'assassin.php';

class Warrior extends Fighter{
    public static $BaseHealth = 6;
    public static $BaseStrength = 5;

    public static $DoubleHitChance = 50;

    public static $Description;

    public function __construct($name){
        $this->health = Warrior::$BaseHealth;
        $this->strength = Warrior::$BaseStrength;

        $this->class = 'Warrior';
        $this->name = $name;
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
        if(rand(1, 100) <= Tank::$BlockChance){
            return;
        }else{
            $enemy->health -= $this->strength;

            if(!$second && rand(1, 100) <= Warrior::$DoubleHitChance){
                $this->AttackTank($enemy, true);
            }
        }
    }

    private function AttackAssassin($enemy, $second){
        if(rand(1, 100) <= Assassin::$CounterChance){
            $enemy->Attack($this);
        }else{
            $enemy->health -= $this->strength;

            if(!$second && rand(1, 100) <= Warrior::$DoubleHitChance){
                $this->AttackAssassin($enemy, true);
            }
        }
    }
    
    private function AttackWarrior($enemy, $second){
        $enemy->health -= $this->strength;

        if(!$second && rand(1, 100) <= Warrior::$DoubleHitChance){
            $this->AttackWarrior($enemy, true);
        }
    }
}

//PHP IS CANCER
Warrior::$Description = 
"The Warrior is a furious fighter who would never run away. He fights until either he or his enemy is dead.
With his two axes he is able to attack twice in a row by a chance of ".Warrior::$DoubleHitChance."%"
;

?>
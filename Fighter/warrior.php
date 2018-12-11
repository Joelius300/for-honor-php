<?php

require_once 'fighter.php';
require_once 'tank.php';
require_once 'assassin.php';

class Warrior extends Fighter{
    public static $BaseHealth = 6;
    public static $BaseStrength = 5;

    public static $DoubleHitChance = 50;
    
    public static $picURL = "/images/warrior.jpg";
    public static $Description;

    public function __construct($name){
        $this->health = Warrior::$BaseHealth;
        $this->strength = Warrior::$BaseStrength;

        $this->class = 'Warrior';
        $this->name = $name;
    }

    private $lastDoubled;

    public function Attack($enemy){
        $blocked = false;
        $countered = false;

        $this->lastDoubled = false;

        $winner = null;

        switch($enemy->class){
            case 'Tank':
                $blocked = $this->AttackTank($enemy, false, true);
                break;
            case 'Assassin':
                $countered = $this->AttackAssassin($enemy, false, true);
                break;
            case 'Warrior':
            $this->AttackWarrior($enemy, false);
                break;
        }
        
        if($this->calcHealth < 1){
            $winner = $enemy;
        }else if($enemy->calcHealth < 1){
            $winner = $this;
        }

        return new Round($this, $enemy, $blocked, $countered, $this->lastDoubled, $winner);
    }

    private function AttackTank($enemy, $second, $interruptable){
        if($interruptable && rand(1, 100) <= Tank::$BlockChance){
            return true;
        }else{
            $enemy->calcHealth -= $this->calcStrength;

            if(!$second && rand(1, 100) <= Warrior::$DoubleHitChance){
                $this->AttackTank($enemy, true, false);

                $this->lastDoubled = true;
            }

            return false;
        }
    }

    private function AttackAssassin($enemy, $second, $interruptable){
        if($interruptable && rand(1, 100) <= Assassin::$CounterChance){
            $enemy->Attack($this, false);
            return true;
        }else{
            $enemy->calcHealth -= $this->calcStrength;

            if(!$second && rand(1, 100) <= Warrior::$DoubleHitChance){
                $this->AttackAssassin($enemy, true, false);

                $this->lastDoubled = true;
            }

            return false;
        }
    }
    
    private function AttackWarrior($enemy, $second){
        $enemy->calcHealth -= $this->calcStrength;

        if(!$second && rand(1, 100) <= Warrior::$DoubleHitChance){
            $this->AttackWarrior($enemy, true);
            
            $this->lastDoubled = true;
        }
    }
}

//PHP IS CANCER
Warrior::$Description = 
"The Warrior is a furious fighter who would never run away. He fights until either he or his enemy is dead.
With his two axes he is able to attack twice in a row by a chance of ".Warrior::$DoubleHitChance."%"
;

?>
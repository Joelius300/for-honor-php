<?php

class Round{
    private $attacker;
    private $defender;

    private $defenderBlocked;
    private $defenderCountered;
    private $attackerDoubled;
    
    public function __construct($attacker, $defender, $defenderBlocked = false, $defenderCountered = false, $attackerDoubled = false){
        $this->attacker = $attacker;
        $this->defender = $defender;

        $this->blocked = $defenderBlocked;
        $this->countered = $defenderCountered;
        $this->doubled = $attackerDoubled;
    }

    public function output(){
        echo "$attacker->name attacked $defender->name for $attacker->calcStrength damage.\n\r";
        if($this->defenderBlocked){
            echo "$defender->name blocked the hit and didn't take damage.";
        }else if($this->defenderCountered){
            echo "$defender->name countered the hit and didn't take damage. He returned the favour with $defender->calcStrength damage himself.";
        }else if($this->attackerDoubled){
            echo "He was fast and attacked once more doing $attacker->calcStrength damage.";
        }

        echo "\n\r";
        echo "Health $defender->name: $defender->calcHealth hp";
        echo "Health $attacker->name: $attacker->calcHealth hp";
    }
}

?>
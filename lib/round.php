<?php

class Round{
    private $attackerName;
    private $attackerCalcStrength;
    private $attackerCalcHealth;
    
    private $defenderName;
    private $defenderCalcStrength;
    private $defenderCalcHealth;

    private $defenderBlocked;
    private $defenderCountered;
    private $attackerDoubled;

    public $winner;
    public $gameOver;
    
    public function __construct($attacker, $defender, $defenderBlocked = false, $defenderCountered = false, $attackerDoubled = false, $winner = null){
        $this->attackerName = $attacker->name;
        $this->attackerCalcStrength = $attacker->calcStrength;
        $this->attackerCalcHealth = $attacker->calcHealth;

        $this->defenderName = $defender->name;
        $this->defenderCalcStrength = $defender->calcStrength;
        $this->defenderCalcHealth = $defender->calcHealth;


        $this->defenderBlocked = $defenderBlocked;
        $this->defenderCountered = $defenderCountered;
        $this->attackerDoubled = $attackerDoubled;

        if(!empty($winner)){
            $this->gameOver = true;
            $this->winner = $winner;
        }else{
            $this->gameOver = false;
        }
    }

    public function output(){
        echo "<span class='AttackerName'>" . $this->attackerName . "</span> attacked <span class='DefenderName'>" . $this->defenderName . "</span> for <span class='Damage'>" . $this->attackerCalcStrength . "</span> damage.<br>";
        if($this->defenderBlocked){
            echo "<span class='DefenderName'>" . $this->defenderName . "</span> blocked the hit and didn't take damage.<br>";
        }else if($this->defenderCountered){
            echo "<span class='DefenderName'>" . $this->defenderName . "</span> countered the hit and didn't take damage. He returned the favour with <span class='Damage'>" . $this->defenderCalcStrength . "</span> damage himself.<br>";
        }else if($this->attackerDoubled){
            echo "He was fast and attacked once more doing <span class='Damage'>" . $this->attackerCalcStrength . "</span> damage.<br>";
        }

        echo "\n\r";
        echo "Health " . $this->defenderName . ": " . $this->defenderCalcHealth . " hp<br>";
        echo "Health " . $this->attackerName . ": " . $this->attackerCalcHealth . " hp<br>";

        if(!empty($this->winner)){
            echo "<br>";
            $this->callWinner($this->winner);
        }
    }


    private static function callWinner($winner){
        echo "<span class='WinnerName'>$winner->name</span> hat gewonnen!";
    }
}

?>
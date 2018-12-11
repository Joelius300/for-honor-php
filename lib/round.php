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
        echo "<span class='AttackerName'>" . $this->attackerName . "</span> <img src='/images/attack.png' width='25px' height='25px'> <span class='Damage'>" . $this->attackerCalcStrength . "</span> damage <img src='/images/attack.png' width='25px' height='25px'> <span class='Damage'> <span class='DefenderName'>" . $this->defenderName . "</span> <br>";
        if($this->defenderBlocked){
            echo "<span class='DefenderName'>" . $this->defenderName . "</span> <img src='/images/tank.jpg' width='25px' height='25px'> the hit and didn't take damage.<br>";
        }else if($this->defenderCountered){
            echo "<span class='DefenderName'>" . $this->defenderName . "</span> countered the hit and didn't take damage. He returned the favour with <span class='Damage'>" . $this->defenderCalcStrength . "</span> damage himself.<br>";
        }else if($this->attackerDoubled){
            echo "He knocked his enemies defense down and attacked once more doing <span class='Damage'>" . $this->attackerCalcStrength . "</span> damage again.<br>";
        }

        echo "<br>";
        echo "Health <span class='DefenderName'>" . $this->defenderName . "</span>: <span class='Health'>" . $this->defenderCalcHealth . "</span> hp<br>";
        echo "Health <span class='AttackerName'>" . $this->attackerName . "</span>: <span class='Health'>" . $this->attackerCalcHealth . "</span> hp<br>";

        if(!empty($this->winner)){
            echo "<br>";
            $this->callWinner($this->winner);
        }
    }


    private static function callWinner($winner){
        echo "<img src='https://upload.wikimedia.org/wikipedia/commons/a/a6/Trophy_Flat_Icon.svg' width='50px' height='50px'><span class='WinnerName'>$winner->name</span><img src='https://upload.wikimedia.org/wikipedia/commons/a/a6/Trophy_Flat_Icon.svg' width='50px' height='50px'>";

    }
}

?>
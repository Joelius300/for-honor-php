<?php

require_once 'tank.php';
require_once 'assassin.php';
require_once 'warrior.php';

abstract class Fighter{
    private static $ClassesNames = array(0 => 'Tank', 1 => 'Assassin', 2 => 'Warrior');

    public static function GetAmountClasses(){
        return count(self::$ClassesNames);
    }

    public static function ResolveClass($idOrName){        
        try{
            return Fighter::$ClassesNames[$idOrName];
        }catch (Exception $e) {
            try{
                return array_search (Fighter::$ClassesNames, $idOrName);
            }catch (Exception $e) {
                return 'Unable to resolve class';
            }
        }
    }

    public static function FillDefaults(){
        $i = 0;
        for($i = 0; $i < count(self::$ClassesNames); $i++){
            echo "
            defaults[$i] = {};
            defaults[$i].name = '". self::$ClassesNames[$i]."';
            defaults[$i].baseHealth = ". self::ResolveClass($i)::$BaseHealth .";
            defaults[$i].baseStrength = ". self::ResolveClass($i)::$BaseStrength .";
            defaults[$i].description = ". json_encode(self::ResolveClass($i)::$Description) .";
            defaults[$i].picURL = '". self::ResolveClass($i)::$picURL ."';
            ";
        }
    }

    public static function GetOptionsHTML(){
        for($i = 0; $i < count(self::$ClassesNames); $i++){
            echo '<option value=' .$i. '>' .self::$ClassesNames[$i]. '</option>';
        }
    }

    public function CalcFightValues(){
        $this->calcHealth = $this->health * self::$healthMultiplier;
        $this->calcStrength = $this->strength * self::$strengthMultiplier;
    }

    public static $healthMultiplier = 50;
    public static $strengthMultiplier = 10;

    public $id;

    public $name;
    public $health;
    public $strength;

    public $calcHealth;
    public $calcStrength;
    
    public $userID;
    public $username;

    public $class;


    public abstract function Attack($enemy);
}
?>
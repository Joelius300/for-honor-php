<?php

require_once 'tank.php';
require_once 'assassin.php';
require_once 'warrior.php';


//This class is the master class for all other fighter classes
//It is only intended to be derived from not to be instanciated
//This class also hold static values which are used globally
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

    //This Javascript code is echoed within a view. This is needed to transfer the php variables to js variables.
    //These js variables are then used for switching between classes in the create view
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

    //This code makes use of the static php variables that can be accessed by a counter (here $i) 
    //The generated html code is echoed inside of a select within the create view to enable the user to switch between classes
    public static function GetOptionsHTML(){
        for($i = 0; $i < count(self::$ClassesNames); $i++){
            echo '<option value=' .$i. '>' .self::$ClassesNames[$i]. '</option>';
        }
    }

    //This is a simple multiplication to reduce redundant code in other places as well as the error quote
    public function CalcFightValues(){
        $this->calcHealth = $this->health * self::$healthMultiplier;
        $this->calcStrength = $this->strength * self::$strengthMultiplier;
    }

    public static $healthMultiplier = 150;
    public static $strengthMultiplier = 25;

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
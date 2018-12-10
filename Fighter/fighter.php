<?php

require_once 'tank.php';
require_once 'assassin.php';
require_once 'warrior.php';

abstract class Fighter{
    private static $ClassesNames = array(0 => 'Tank', 1 => 'Assassin', 2 => 'Warrior');

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
            defaults[$i].name = '". self::$ClassesNames[$i]."';\n\r
            defaults[$i].baseHealth = ". self::ResolveClass($i)::$BaseHealth .";\n\r
            defaults[$i].baseStrength = ". self::ResolveClass($i)::$BaseStrength .";\n\r
            defaults[$i].description = ". json_encode(self::ResolveClass($i)::$Description) .";\n\r
            defaults[$i].picURL = '/images/".strtolower(self::$ClassesNames[$i]).".jpg';\n\r
            ";
        }
    }

    public static function GetOptionsHTML(){
        for($i = 0; $i < count(self::$ClassesNames); $i++){
            echo '<option value=' .$i. '>' .self::$ClassesNames[$i]. '</option>\n\r';
        }
    }

    public static $healthMultiplier = 25;
    public static $strengthMultiplier = 10;

    public $name;
    public $health;
    public $strength;

    public $class;


    public abstract function Attack($enemy);
}
?>
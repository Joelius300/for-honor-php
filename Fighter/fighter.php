<?php

require_once 'tank.php';
require_once 'assassin.php';
require_once 'warrior.php';

abstract class Fighter{
    private static $ClassesNames = array(0 => 'Tank', 1 => 'Assassin', 2 => 'Warrior');

    public static function ResolveClass($idOrName){        
        try{
            return $ClassesNames[$idOrName];
        }catch (Exception $e) {
            try{
                return array_search ($ClassesNames, $idOrName);
            }catch (Exception $e) {
                return 'Unable to resolve class';
            }
        }
    }

    public static $healthMultiplier = 25;
    public static $strengthMultiplier = 10;


    public $health;
    public $strength;

    public $class;


    public abstract function Attack($enemy);
}
?>
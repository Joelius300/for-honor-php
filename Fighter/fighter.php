<?php

require_once 'tank.php';
require_once 'assassin.php';
require_once 'warrior.php';

abstract class Fighter{
    private static $ClassesNames = array(0 => 'Tank', 1 => 'Assassin', 2 => 'Warrior');
    private static $ClassesIDs = array('Tank' => 0, 'Assassin' => 1, 'Warrior' => 2);

    public static function ResolveClass($idOrName){        
        try{
            return $ClassesNames[$idOrName];
        }catch (Exception $e) {
            try{
                return $ClassesIDs[$idOrName];
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
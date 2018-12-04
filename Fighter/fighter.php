<?php

require_once 'tank.php';
require_once 'assassin.php';
require_once 'warrior.php';

abstract class Fighter{
    private static $Classes = array('Tank', 'Assassin', 'Warrior');

    public static function ResolveClass($id){
        $returnstring;
        
        try{
            return $Classes[$id];
        }catch (Exception $e) {
            return 'Unable to resolve class';
        }
    }

    public static $multiplier = 20;


    public $health;
    public $strength;

    public $class;


    public abstract function Attack($enemy);
}
?>
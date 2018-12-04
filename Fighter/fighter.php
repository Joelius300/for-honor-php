<?php
class Fighter{
    private static $Classes = array('Tank', 'Assassin', 'Warrior');

    public static function ResolveClass($id){
        $returnstring;
        
        try{
            return $Classes[$id];
        }catch (Exception $e) {
            return 'Unable to resolve class';
        }
    }

    
}
?>
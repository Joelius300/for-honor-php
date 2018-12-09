<?php

// require_once('../repository/FighterRepository.php');
require_once("../lib/View.php");


class FightController{
    private $repos;

    public function __construct(){
        // $this->repos = new FighterRepository();
    }

    public function index()
    {
        $view = new View('fight_list');
        $view->title = 'Wähle einen Gegner';
        $view->display();
    }
}
?>
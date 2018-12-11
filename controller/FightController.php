<?php

//require_once('../repository/FighterRepository.php');
require_once("../lib/View.php");
require_once("../controller/FighterController.php");
	

class FightController{
    private $fighterController;

    public function __construct(){
        //$this->fighterRepos = new FighterRepository();
        $this->fighterController = new FighterController();
    }

    public function index()
    {
        $view = new View('fight_list');
        $view->title = 'Wähle einen Gegner';
        $view->fighters = $this->fighterController->GetAll(0, 5000);
        $view->display();
    }

    // public function Fight(){
    //     $enemy = $this->fighterController->GetFighter($_GET['enemy']);
    //     $youself = $this->fighterController->GetFighter($_SESSION['fighterID']);        
    // }

}
?>
<?php

require_once('../repository/FighterRepository.php');
require_once('../repository/UserRepository.php');
require_once("../lib/View.php");
require_once("../Fighter/fighter.php");
require_once("../Fighter/assassin.php");
require_once("../Fighter/tank.php");
require_once("../Fighter/warrior.php");


class FighterController{
    private $fighterRepos;
    private $userRepos;

    public function __construct(){
        $this->fighterRepos = new FighterRepository();
        $this->userRepos = new UserRepository();
    }

    public function index()
    {
        header('Location: /Fighter/Edit');
    }

    public function Create()
    {
        $view = new View('fighter_create');
        $view->title = 'Kämpfer erstellen';
        $view->avaiablePoints = $this->userRepos->getAvaiablePoints($_SESSION['userID']);
        $view->display();
    }

    public function Edit()
    {
        $loggedUser = $this->userRepos->readById($_SESSION['userID']);

        $view = new View('fighter_edit');
        $view->title = 'Kämpfer bearbeiten';
        $view->avaiablePoints = $this->userRepos->getAvaiablePoints($loggedUser->id);
        $view->Fighter = $this->GetFighter($loggedUser->Fighter_ID);
        $view->FighterID = $loggedUser->Fighter_ID;
        $view->display();
    }

    public function GetFighter($id){
        $result = $this->fighterRepos->readById($id);   
        if(empty($result) || !isset($result)){
            header('Location: /Fighter/Create');
        }
        
        $class = Fighter::ResolveClass($result->Class);

        $fighter = new $class($result->Name);

        $fighter->health = $result->HealthPoints;
        $fighter->strength = $result->StrengthPoints;

        return $fighter;
    }

    public function insert(){
        $insert_id = $this->fighterRepos->insert($_POST['name'], $_POST['class'], $_POST['strengthValue'], $_POST['healthValue']); 
        
        $this->userRepos->updateFighterID($_SESSION['userID'], $insert_id);
        header('Location: /');
    }

    public function update(){
        $this->fighterRepos->update($_POST['id'], $_POST['name'], $_POST['strengthValue'], $_POST['healthValue']); 
        header('Location: /');
    }
}
?>
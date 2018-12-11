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

    public function CreateWithError($error){
        $view = new View('fighter_create');
        $view->title = 'Kämpfer erstellen';
        $view->avaiablePoints = $this->userRepos->getAvaiablePoints($_SESSION['userID']);
        $view->error = $error;
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

    public function EditWithError($error)
    {
        $loggedUser = $this->userRepos->readById($_SESSION['userID']);

        $view = new View('fighter_edit');
        $view->title = 'Kämpfer bearbeiten';
        $view->avaiablePoints = $this->userRepos->getAvaiablePoints($loggedUser->id);
        $view->Fighter = $this->GetFighter($loggedUser->Fighter_ID);
        $view->FighterID = $loggedUser->Fighter_ID;
        $view->error = $error;
        $view->display();
    }

    public function GetFighter($id){
        $result = $this->fighterRepos->readById($id);   
        if(empty($result) || !isset($result)){
            header('Location: /Fighter/Create');
        }

        $fighter = $this->GetFighterFromRow($result);

        return $fighter;
    }

    private function GetFighterFromRow($result){              
        $class = Fighter::ResolveClass($result->Class);

        $fighter = new $class($result->Name);

        $fighter->id = $result->id;

        if(isset($result->userID) && !empty($result->userID) && isset($result->username) && !empty($result->username)) {
            $fighter->userID = $result->userID;
            $fighter->username = $result->username;
        }

        $fighter->health = $result->HealthPoints;
        $fighter->strength = $result->StrengthPoints;

        return $fighter;
    }

    public function insert(){
        if(!$this->ValidateEssentials($_POST['name'], $_POST['healthValue'], $_POST['strengthValue'], 'Create') || !$this->ValidateClass($_POST['class'], 'Create')){
            // $this->CreateWithError('Ein Fehler ist aufgetreten. Kontrollieren Sie Ihre Eingaben und versuchen Sie es erneut.');
            return;
        }

        try{
            $insert_id = $this->fighterRepos->insert($_POST['name'], $_POST['class'], $_POST['healthValue'], $_POST['strengthValue']); 
            
            $this->userRepos->updateFighterID($_SESSION['userID'], $insert_id);
            $_SESSION['fighterID'] = $insert_id;
            header('Location: /');
        }catch(Exception $e){
            $this->CreateWithError('Ein Fehler ist aufgetreten. Kontrollieren Sie Ihre Eingaben und versuchen Sie es erneut.');
        }
    }

    public function update(){
        if(!$this->ValidateEssentials($_POST['name'], $_POST['healthValue'], $_POST['strengthValue'], 'Edit')){
            // $this->EditWithError('Ein Fehler ist aufgetreten. Kontrollieren Sie Ihre Eingaben und versuchen Sie es erneut.');
            return;
        }

        try{
            $this->fighterRepos->update($_POST['id'], $_POST['name'], $_POST['healthValue'], $_POST['strengthValue']); 
            header('Location: /');
        }catch (Exception $e){
            $this->EditWithError('Ein Fehler ist aufgetreten. Kontrollieren Sie Ihre Eingaben und versuchen Sie es erneut.');
        }
    }

    private function ValidateEssentials($name, $health, $strength, $NameOfAction){
        if(!$this->ValidateName($name, $NameOfAction)){
            return false;
        }
        if(!$this->ValidateHealth($health, $NameOfAction)){
            return false;
        }
        if(!$this->ValidateStrength($strength, $NameOfAction)){
            return false;
        }

        return true;
    }

    private function ValidateName($name, $NameOfAction){
        if(strlen($name) > 30 || strlen($name) < 1 || !isset($name)){
            $action = $NameOfAction.'WithError';
            $this->$action('Name can only be 1 to 30 chars long.');
            return false;
        }
        return true;
    }

    private function ValidateClass($class, $NameOfAction){
        //Apparently this isn't actually working since the select automatically selects index 0 when you would get an invalid index (not an option for the select)
        if($class < 0 || $class > Fighter::GetAmountClasses() -1 || !isset($class)){
            $action = $NameOfAction.'WithError';
            $this->$action('You cannot manipulate the class');
            return false;
        }
        return true;
    }

    private function ValidateHealth($health, $NameOfAction){
        if($health < 1 || $health > 10 || !isset($health)){
            $action = $NameOfAction.'WithError';
            $this->$action('Health can only be between 1 and 10 (incl.).');
            return false;
        }
        return true;
    }

    private function ValidateStrength($strength, $NameOfAction){
        if($strength < 1 || $strength > 10 || !isset($strength)){
            $action = $NameOfAction.'WithError';
            $this->$action('Strength can only be between 1 and 10 (incl.).');
            return false;
        }
        return true;
    } 


    public function GetAll($start, $count){
        $rows = $this->fighterRepos->readAllJoin($start, $count);
        $fighters = array();
        for($i = 0; $i < count($rows); $i++){
            $fighters[$i] = $this->GetFighterFromRow($rows[$i]);
        }

        return $fighters;
    }
}
?>
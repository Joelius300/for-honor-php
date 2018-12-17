<?php

require_once('../repository/FighterRepository.php');
require_once('../repository/UserRepository.php');
require_once("../lib/View.php");

//Includes the fighting classes
require_once("../Fighter/fighter.php");
require_once("../Fighter/assassin.php");
require_once("../Fighter/tank.php");
require_once("../Fighter/warrior.php");

//This controller handles everything related to the fighter itself
//This includes
// * Creating a fighter from a row from the Database,
// * Preparing fighters for updates, inserts and deletes + forwarding after the said actions
// * Validating name, class, health-/stengthpoints, etc
// * Showing views for creating and editing fighters
class FighterController{
    private $fighterRepos;
    private $userRepos;

    public function __construct(){
        $this->fighterRepos = new FighterRepository();
        $this->userRepos = new UserRepository();
    }

    //Not needed -> redirect to edit
    public function index()
    {
        header('Location: /Fighter/Edit');
    }

    //Shows the create view because the methode name will be in the URL
    public function Create()
    {
        if(!isset($_SESSION['fighterID'])){
            $view = new View('fighter_create');
            $view->title = 'Kämpfer erstellen';
            $view->avaiablePoints = $this->userRepos->getAvaiablePoints($_SESSION['userID']);
            $view->display();
        }else{
            header('Location: /Fighter/Edit');
        }
    }

    //Shows the create view whilst adding an Error to it that will be displayed as an JS alert popup
    public function CreateWithError($error){
        $view = new View('fighter_create');
        $view->title = 'Kämpfer erstellen';
        $view->avaiablePoints = $this->userRepos->getAvaiablePoints($_SESSION['userID']);
        $view->error = $error;
        $view->display();
    }

    //Shows the edit view because the methode name will be in the URL
    public function Edit()
    {
        if(isset($_SESSION['fighterID'])){
            $loggedUser = $this->userRepos->readById($_SESSION['userID']);

            $view = new View('fighter_edit');
            $view->title = 'Kämpfer bearbeiten';
            $view->avaiablePoints = $this->userRepos->getAvaiablePoints($loggedUser->id);
            $view->Fighter = $this->GetFighter($_SESSION['fighterID']);
            $view->FighterID = $_SESSION['fighterID'];
            $view->display();
        }else{
            header('Location: /Fighter/Create');
        }
    }

    //Just like CreateWithError
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

    //Redirects data from db to create an instance of a fighter
    public function GetFighter($id){
        $result = $this->fighterRepos->readById($id);   
        if(empty($result)){
            header('Location: /Fighter/Create');
        }

        $fighter = $this->GetFighterFromRow($result);

        return $fighter;
    }

    //Uses data from db to create a fighter instance that can be used for fighting
    private function GetFighterFromRow($result){              
        $class = Fighter::ResolveClass($result->Class);

        $fighter = new $class($result->Name);

        $fighter->id = $result->id;

        if(isset($result->userID) && isset($result->username)) {
            $fighter->userID = $result->userID;
            $fighter->username = $result->username;
        }

        $fighter->health = $result->HealthPoints;
        $fighter->strength = $result->StrengthPoints;

        return $fighter;
    }

    //Takes and validates the values from the form and hands them to the repository for storing it in the db
    public function insert(){
        if(!$this->ValidateEssentials($_POST['name'], $_POST['healthValue'], $_POST['strengthValue'], $_POST['avaiablePoints'], 'Create', $_POST['class'])){
            // Errors already displayed in Validation itself (allows for a more specific error)
            // $this->CreateWithError('Ein Fehler ist aufgetreten. Kontrollieren Sie Ihre Eingaben und versuchen Sie es erneut.');
            return;
        }

        try{
            $insert_id = $this->fighterRepos->insert($_POST['name'], $_POST['class'], $_POST['healthValue'], $_POST['strengthValue']); 
            
            $this->userRepos->updateFighterID($_SESSION['userID'], $insert_id);
            $_SESSION['fighterID'] = $insert_id;

            $this->userRepos->updateAvaiablePoints($_SESSION['userID'], $_POST['avaiablePoints']);

            header('Location: /');
        }catch(Exception $e){
            $this->CreateWithError('Ein Fehler ist aufgetreten. Kontrollieren Sie Ihre Eingaben und versuchen Sie es erneut.');
        }
    }

    //Prepares and validates values for update using functions from this class and the repository
    public function update(){
        if(!$this->ValidateEssentials($_POST['name'], $_POST['healthValue'], $_POST['strengthValue'], $_POST['avaiablePoints'], 'Edit', null)){
            // Erorrs already displayed in Validation itself (more specific error)
            // $this->EditWithError('Ein Fehler ist aufgetreten. Kontrollieren Sie Ihre Eingaben und versuchen Sie es erneut.');
            return;
        }

        try{
            $this->fighterRepos->update($_POST['id'], $_POST['name'], $_POST['healthValue'], $_POST['strengthValue']); 

            $this->userRepos->updateAvaiablePoints($_SESSION['userID'], $_POST['avaiablePoints']);

            header('Location: /');
        }catch (Exception $e){
            $this->EditWithError('Ein Fehler ist aufgetreten. Kontrollieren Sie Ihre Eingaben und versuchen Sie es erneut.');
        }
    }

    //Puts together all the validation methods so you can reuse the parameters and also have all of them in one place
    private function ValidateEssentials($name, $health, $strength, $avaiablePoints, $NameOfAction, $class = null){
        if(!$this->ValidateName($name, $NameOfAction)){
            return false;
        }
        if($class != null){
            if(!$this->ValidateClass($class, $NameOfAction)){
                return false;
            }
        }
        if(!$this->ValidateHealthRange($health, $NameOfAction)){
            return false;
        }
        if(!$this->ValidateStrengthRange($strength, $NameOfAction)){
            return false;
        }
        if(!$this->ValidatePointRelations($health, $strength, $avaiablePoints, $NameOfAction, $class)){
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
        //But it would show an error and prevent the insert if it there was a problem
        if($class < 0 || $class > Fighter::GetAmountClasses() -1 || !isset($class)){
            $action = $NameOfAction.'WithError';
            $this->$action('You cannot manipulate the class');
            return false;
        }
        return true;
    }

    //Checks if the health inside the valid range (in a real world scenario you would access global variables for the upper (and lower) limits)
    private function ValidateHealthRange($health, $NameOfAction){
        if($health < 1 || $health > 10 || !isset($health)){
            $action = $NameOfAction.'WithError';
            $this->$action('Health can only be between 1 and 10 (incl.).');
            return false;
        }
        return true;
    }

    //Checks if the strength inside the valid range (in a real world scenario you would access global variables for the upper (and lower) limits)
    private function ValidateStrengthRange($strength, $NameOfAction){
        if($strength < 1 || $strength > 10 || !isset($strength)){
            $action = $NameOfAction.'WithError';
            $this->$action('Strength can only be between 1 and 10 (incl.).');
            return false;
        }
        return true;
    } 

    //Using the data from the db and the data that would apply after the changes go throught, 
    //this function determines if it the changes are possible with the points the user has
    private function ValidatePointRelations($health, $strength, $avaiablePointsNow, $NameOfAction, $class=null){
        $pointsSpend = $this->userRepos->readByID($_SESSION['userID'])->Points - $avaiablePointsNow;
        $deltaHealth;
        $deltaStrength;

        if(isset($_SESSION['fighterID'])){
            $fighterThen = $this->fighterRepos->readByID($_SESSION['fighterID']);
            $deltaHealth = $health - $fighterThen->HealthPoints;
            $deltaStrength = $strength - $fighterThen->StrengthPoints;
        }else{
            if($class == null){
                $action = $NameOfAction.'WithError';
                $this->$action('Something went horribly wrong. Try again.');
                return false;
            }else{
                $deltaHealth = $health - Fighter::ResolveClass($class)::$BaseHealth;
                $deltaStrength = $strength - Fighter::ResolveClass($class)::$BaseStrength;
            }
        }

        if($deltaHealth + $deltaStrength != $pointsSpend){
            $action = $NameOfAction.'WithError';
            $this->$action('You can only use as many points as you have. Don\'t try to cheat the system.');
            return false;
        }
        return true;
    }

    //This is essentially the same as the readAllJoin methode from the repos but it directly instantiates
    //a fighter from each row
    public function GetAll($start, $count){
        $rows = $this->fighterRepos->readAllJoin($start, $count);
        $fighters = array();
        for($i = 0; $i < count($rows); $i++){
            $fighters[$i] = $this->GetFighterFromRow($rows[$i]);
        }

        return $fighters;
    }

    //Wraps the function from the repos with some additional actions and forwarding
    public function Delete(){
        if(isset($_SESSION['fighterID'])){
            $this->fighterRepos->deleteById($_SESSION['fighterID']);

            unset($_SESSION['fighterID']);

            header('Location: /');
        }
    }
}
?>
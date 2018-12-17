<?php

require_once('../repository/UserRepository.php');
require_once('../repository/FighterRepository.php');
require_once("../lib/View.php");

//This controller is used for everything related to Users. This includes
// * Login
// * Logout
// * Validate credentials etc for Insert or Login
// * Read and prepare stats from db for further use in Views and Fights
// * etc

class UserController
{
    private $repos;
    private $fighterRepos;

    //Instanciates the repos needed
    public function __construct(){
        $this->repos = new UserRepository();
        $this->fighterRepos = new FighterRepository();
    }

    //Not used -> just redirect
    public function index()
    {
        //Anfrage weiterleiten (HTTP 302)
        header('Location: /user/Login');
    }

    //This prepares the stats read by the repos for further use in views and fights
    public function GetStats($userID){
        $user = $this->repos->readById($userID);
        $stats = array();

        $stats['Name'] = $user->Username;
        $stats['TotalGames'] = $user->TotalGames;
        $stats['Wins'] = $user->Wins;
        $stats['Losses'] = intval($user->TotalGames) - intval($user->Wins);

        return $stats;
    }

    //This is only used that we don't need another instance of the repos where there is already one of the controller
    public function UpdateStats($userID, $totalGames, $wins){
        $this->repos->updateStats($userID, $totalGames, $wins);
    }

    //Wrapper for the methode in the repos (validates then inserts)
    public function Register()
    {
        if(!$this->ValidateCredentials($_POST['username'], $_POST['password'])){
            return;
        }else{

            if($this->repos->insert($_POST['username'], $_POST['password']) > 0){
                $this->LoginUser($_POST['username'], $_POST['password']);
            }else{
                $this->CreateWithError('User already exists');
            }
        }
    }

    //Checks the format of the credentials (not if they exist in the db)
    private function ValidateCredentials($username, $password){
        if(strlen($username) > 30 || strlen($username) < 1 || empty($username)){
            $this->CreateWithError('Username must contain between 1 and 30 chars (incl.).');
            return false;
        }

        if(strlen($password) < 6 || empty($password)){
            $this->CreateWithError('Password must contain at least 6 chars.');
            return false;
        }

        return true;
    }
    
    //Same as Create but shows an Error first
    private function CreateWithError($error){
        unset($_SESSION['userID']);
        $view = new View('user_create');
        $view->title = 'Benutzer erstellen';
        $view->error = $error;
        $view->display();
    }

    //Same as Login but shows an Error first
    private function LoginWithError($error){
        unset($_SESSION['userID']);
        unset($_SESSION['fighterID']);
        $view = new View('login');
        $view->title = 'Login';
        $view->username = '';
        $view->error = $error;
        $view->display();
    }

    //Has to check if user is already logged and if so redirect them
    //Otherwise show view for creating a user
    public function Create(){
        if(isset($_SESSION['userID'])){
            header('Location: /');
        }else{
            $view = new View('user_create');
            $view->title = 'Benutzer erstellen';
            $view->display();
        }
    }

    //Has to check if user is already logged and if so redirect them
    //Otherwise show view for Login
    public function Login(){
        if(isset($_SESSION['userID'])){
            header('Location: /');
        }else{
            $view = new View('login');
            $view->title = 'Login';
            $view->username = '';
            $view->display();
        }
    }

    //reset(/unset) everything and destroy session
    public function Logout(){
        unset($_SESSION['userID']);
        unset($_SESSION['fighterID']);
        unset($_SESSION['isAbleToFight']);
        session_destroy();

        header('Location: /user/Login');
    }

    public function doLogin(){
        $this->LoginUser($_POST['username'], $_POST['password']);
    }

    //Check login credentials and if they are correct log the user in (set userID)
    //Otherwise return to the view with an error
    private function LoginUser($username, $password){
        try{
            $user = $this->repos->readByUsername($username);
            
            if(!empty($user) && password_verify($password, $user->Password)){
                $_SESSION['userID'] = $user->id;
                $_SESSION['fighterID'] = $user->Fighter_ID;

                $_SESSION['isAbleToFight'] = true;

                header('Location: /');
            }else{                
                $this->LoginWithError('Wrong Username or Password');
            }
        }catch (Exception $e) {
            $this->LoginWithError('Wrong Username or Password');
        }   
    }

    //Wrapping for methode from repos (validation + forwarding)
    public function Delete(){
        if(isset($_SESSION['userID'])){
            $this->repos->deleteById($_SESSION['userID']);
            
            if(isset($_SESSION['fighterID'])){
                $this->fighterRepos->deleteById($_SESSION['fighterID']);
            }

            $this->Logout();
        }else{
            $this->Logout();
        }
    }
}

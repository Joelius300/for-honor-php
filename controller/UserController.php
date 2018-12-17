<?php

require_once('../repository/UserRepository.php');
require_once('../repository/FighterRepository.php');
require_once("../lib/View.php");


class UserController
{
    public static $ERROR;

    private $repos;
    private $fighterRepos;

    public function __construct(){
        $this->repos = new UserRepository();
        $this->fighterRepos = new FighterRepository();
    }

    public function index()
    {
        //Anfrage weiterleiten (HTTP 302)
        header('Location: /user/Login');
    }

    public function GetStats($userID){
        $user = $this->repos->readById($userID);
        $stats = array();

        $stats['Name'] = $user->Username;
        $stats['TotalGames'] = $user->TotalGames;
        $stats['Wins'] = $user->Wins;
        $stats['Losses'] = intval($user->TotalGames) - intval($user->Wins);

        return $stats;
    }

    public function UpdateStats($userID, $totalGames, $wins){
        $this->repos->updateStats($userID, $totalGames, $wins);
    }

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
    
    private function CreateWithError($error){
        unset($_SESSION['userID']);
        $view = new View('user_create');
        $view->title = 'Benutzer erstellen';
        $view->error = $error;
        $view->display();
    }

    private function LoginWithError($error){
        unset($_SESSION['userID']);
        unset($_SESSION['fighterID']);
        $view = new View('login');
        $view->title = 'Login';
        $view->username = '';
        $view->error = $error;
        $view->display();
    }

    public function Create(){
        if(isset($_SESSION['userID'])){
            header('Location: /');
        }else{
            $view = new View('user_create');
            $view->title = 'Benutzer erstellen';
            $view->display();
        }
    }

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

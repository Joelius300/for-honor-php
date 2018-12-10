<?php

require_once('../repository/UserRepository.php');
require_once("../lib/View.php");


class UserController
{
    public static $ERROR;

    private $repos;

    public function __construct(){
        $this->repos = new UserRepository();
    }

    public function index()
    {
        //Anfrage weiterleiten (HTTP 302)
        header('Location: /user/Login');
    }

    public function Register()
    {
        if($this->repos->insert($_POST['username'], $_POST['password']) > 0){
            $this->LoginUser($_POST['username'], $_POST['password']);
            unset(UserController::$ERROR);
        }else{
            UserController::$ERROR = 'User already exists';
            header('Location: /user/Create');
        }
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

                unset(UserController::$ERROR);
                header('Location: /');
            }else{
                UserController::$ERROR = 'Wrong Username or Password';
                header('Location: /user/Login');
            }
        }catch (Exception $e) {
            UserController::$ERROR = 'Wrong Username or Password';
            header('Location: /user/Login');
        }   
    }
}

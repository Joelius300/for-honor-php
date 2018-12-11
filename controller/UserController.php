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
        }else{
            unset($_SESSION['userID']);
            $view = new View('user_create');
            $view->title = 'Benutzer erstellen';
            $view->error = 'User already exists';
            $view->display();
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

                header('Location: /');
            }else{                
                unset($_SESSION['userID']);
                $view = new View('login');
                $view->title = 'Login';
                $view->username = '';
                $view->error = 'Wrong Username or Password';
                $view->display();
            }
        }catch (Exception $e) {
            unset($_SESSION['userID']);
            $view = new View('login');
            $view->title = 'Login';
            $view->username = '';
            $view->error = 'Wrong Username or Password';
            $view->display();
        }   
    }
}

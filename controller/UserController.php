<?php

require_once('../repository/UserRepository.php');
require_once("../lib/View.php");


class UserController
{
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
            header('Location: /user/Login');
        }else{
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
        try{
            $user = $this->repos->readByUsername($_POST['username']);
            
            if(password_verify($_POST['password'], $user->Password)){
                $_SESSION['userID'] = $user->id;

                header('Location: /');
            }else{
                header('Location: /user/Login');
            }
        }catch (Exception $e) {
            header('Location: /user/Login');
    }
    }
}

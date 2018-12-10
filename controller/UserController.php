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
        $view = new View('user_create');
        $view->title = 'Benutzer erstellen';
        $view->display();
    }

    public function Create(){
        if($this->repos->create($_POST['username'], $_POST['password']) > 0){
            header('Location: /user/Login');
        }else{
            header('Location: /user/Create');
        }
    }

    public function Login(){
        $view = new View('login');
        $view->title = 'Login';
        $view->username = '';
        $view->display();
    }

    public function doLogin(){
        try{
            $user = $this->repos->readByUsername($_POST['username']);

            if(password_verify($_POST['password'], $user['Password'])){
                session_start();
                $_SESSION['userID'] = $user['id'];

                header('Location: /');
            }else{
                header('Location: /user/Login');
            }
        }catch (Exception $e) {
            header('Location: /user/Login');
    }
    }
}

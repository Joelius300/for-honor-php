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
        //Anfrage an die URI /user/crate weiterleiten (HTTP 302)
        header('Location: /user/showLogin');
    }

    public function showCreate()
    {
        $view = new View('user_create');
        $view->title = 'Benutzer erstellen';
        $view->display();
    }

    public function create(){
        $this->repos->create($_POST['username'], $_POST['password']); 
        header('Location: /user/showLogin');
    }

    public function showLogin(){
        $view = new View('login');
        $view->title = 'Login';
        $view->username = '';
        $view->display();
    }

    public function login(){
        $user = $this->repos->readByUsername($_POST['username']);

        if(password_verify($_POST['password'], $user['Password'])){
            session_start();
            $_SESSION['loggedIn'] = true;
            $_SESSION['userID'] = $user['id'];

            header('Location: /');
        }else{
            $view = new View('login');
            $view->title = 'Login';
            $view->username = $_POST['username'];
            $view->display();
        }
    }
}

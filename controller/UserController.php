<?php

require_once('../repository/UserRepository.php');
require_once("../lib/View.php");

/**
 * Siehe Dokumentation im DefaultController.
 */
class UserController
{
    private $repos;

    public function __construct(){
        $this->repos = new UserRepository();
    }

    public function index()
    {
        //Anfrage an die URI /user/crate weiterleiten (HTTP 302)
        header('Location: /user/create');
    }

    public function create()
    {
        $view = new View('user_create');
        $view->title = 'Benutzer erstellen';
        $view->display();
    }

    public function save(){
        $this->repos->create($_POST['username'], $_POST['password']); 
        header('Location: /user/create');
    }
}

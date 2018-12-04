<?php

require_once '../repository/UserRepository.php';
require_once("../lib/View.php");

/**
 * Siehe Dokumentation im DefaultController.
 */
class UserController
{
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

    public function save($username, $password){
        $data->save($username, $password);  
    }
}

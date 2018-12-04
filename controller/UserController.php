<?php

/**
 * Siehe Dokumentation im DefaultController.
 */
class UserController
{
    private $data;

    public function __construct()
    {
        require_once("../lib/Data.php");

        $data = new Data("localhost", "forHonorUser", "forHonor123");
    }

    public function index()
    {
        // Anfrage an die URI /user/crate weiterleiten (HTTP 302)
        header('Location: /user/create');
    }

    public function create()
    {
        require_once("../lib/View.php");

        $view = new View('user_form');
        $view->title = 'Benutzer erstellen';
        $view->heading = 'Benutzer erstellen';
        $view->display();
    }

    public function save($username, $password){
        $data->save($username, $password);  
    }
}

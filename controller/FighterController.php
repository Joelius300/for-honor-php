<?php

require_once('../repository/FighterRepository.php');
require_once("../lib/View.php");


class FighterController{
    private $repos;

    public function __construct(){
        $this->repos = new FighterRepository();
    }

    public function index()
    {
        $view = new View('fighter_index');
        $view->title = 'Wähle einen Gegner';
        $view->display();
    }

    public function create()
    {
        $view = new View('fighter_create');
        $view->title = 'Kämpfer erstellen';
        $view->display();
    }

    public function edit()
    {
        $view = new View('fighter_edit');
        $view->title = 'Kämpfer bearbeiten';
        $view->display();
    }

    public function save(){
        $this->repos->save(); 
        header('Location: /');
    }


}
?>
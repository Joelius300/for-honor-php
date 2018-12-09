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
        header('Location: /Fighter/Edit');
    }

    public function Create()
    {
        $view = new View('fighter_create');
        $view->title = 'Kämpfer erstellen';
        $view->display();
    }

    public function Edit()
    {
        $view = new View('fighter_edit');
        $view->title = 'Kämpfer bearbeiten';
        $view->display();
    }

    public function insert(){
        $this->repos->insert($_POST['name'], $_POST['class'], $_POST['strengthValue'], $_POST['healthValue']); 
        header('Location: /');
    }

    public function update(){

    }
}
?>
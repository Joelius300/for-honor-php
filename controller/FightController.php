<?php

//require_once('../repository/FighterRepository.php');
require_once("../lib/View.php");
require_once("../lib/round.php");
require_once("../controller/FighterController.php");
require_once("../repository/UserRepository.php");
	

class FightController{
    private $fighterController;
    private $userRepos;

    private $yourTurn;

    public function __construct(){
        //$this->fighterRepos = new FighterRepository();
        $this->fighterController = new FighterController();
        $this->userRepos = new UserRepository();
    }

    public function index()
    {
        $_SESSION['isAbleToFight'] = true;

        $view = new View('fight_list');
        $view->title = 'Wähle einen Gegner';
        $view->fighters = $this->fighterController->GetAll(0, 5000);
        $view->display();
    }

    public function Fight(){
        if($_SESSION['isAbleToFight']){
            $_SESSION['isAbleToFight'] = false;

            $enemy = $this->fighterController->GetFighter($_GET['enemy']);
            $yourself = $this->fighterController->GetFighter($_SESSION['fighterID']);

            $enemy->CalcFightValues();
            $yourself->CalcFightValues();

            $this->doFight($yourself, $enemy);
        }else{
            header('Location: /');
        }
    }

    private function doFight($yourself, $enemy){
        $rounds = array();
        $winner;

        $this->yourTurn = true;
        while(true){
            $round = $this->PlayRound($yourself, $enemy);

            $rounds[] = $round;

            if($round->gameOver){
                $winner = $round->winner;
                break;
            }
        }

        $this->EndGame($rounds, $winner, $yourself->id, $enemy->id);
    }

    private function EndGame($rounds, $winner, $yourFighterID, $enemyFighterID){   
        $youWon = $winner->id == $yourFighterID;
        
        $this->UpdateUserStats($_SESSION['userID'], 1, $youWon);
        $this->UpdateUserStats($this->userRepos->getUserIDfromFighterID($enemyFighterID), 1, !$youWon);
        
        $view = new View('fight_result');
        $view->title = 'Resultat';
        $view->rounds = $rounds;
        $view->winner = $winner;
        $view->display();
    }

    private function UpdateUserStats($userID, $totalGamesDelta, $youWon){

    }

    private function PlayRound($yourself, $enemy){
        $round;

        if($this->yourTurn){
            $round = $yourself->Attack($enemy);
        }else{
            $round = $enemy->Attack($yourself);
        }

        $this->yourTurn = !$this->yourTurn;

        return $round;
    }    
}
?>
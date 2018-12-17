<?php

require_once("../lib/View.php");
require_once("../lib/round.php");
require_once("../controller/FighterController.php");
require_once("../controller/UserController.php");
	
//This controller does everything regarding the fight itself. 
//Fighter conversion and the damage dealing is not handeled here but in the FighterController
class FightController{
    private $fighterController;
    private $userController;

    private $yourTurn;

    public function __construct(){
        $this->fighterController = new FighterController();
        $this->userController = new UserController();
    }

    //Default method opening when only the controller is called
    //Only the first 5000 Fighters will be shown here and in a real world scenario
    //this would be different 
    public function index()
    {
        $_SESSION['isAbleToFight'] = true;

        $view = new View('fight_list');
        $view->title = 'Wähle einen Gegner';
        $view->fighters = $this->fighterController->GetAll(0, 5000);
        $view->display();
    }

    //Start of the fight itself. Called Fight because that's what's written in the URL.
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

    //Hold the fighting cycle which produces the rounds that are going to be output 
    //as soon as the fight is over
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

        $this->EndGame($rounds, $winner, $yourself->id);
    }

    //Ends the game and displays what happened during the fight.
    //The stats only change for the attacking user. 
    private function EndGame($rounds, $winner, $yourFighterID){   
        $youWon = $winner->id == $yourFighterID;

        $this->UpdateUserStats($_SESSION['userID'], 1, $youWon);
        
        $view = new View('fight_result');
        $view->title = 'Resultat';
        $view->rounds = $rounds;
        $view->winner = $winner;
        $view->display();
    }

    //Here are the calculations done that need to happen before calling the function connected to the DB
    private function UpdateUserStats($userID, $totalGamesDelta, $youWon){
        $stats = $this->userController->GetStats($userID);
        $totalGames = $stats['TotalGames'] + $totalGamesDelta;
        $wins = $stats['Wins'] + ($youWon ? 1 : 0);

        $this->userController->UpdateStats($userID, $totalGames, $wins);
    }

    //Represents a single cycle in the doFight loop
    //What fighter is attacking is stored in a bool which is looked at by the user who started the fight
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
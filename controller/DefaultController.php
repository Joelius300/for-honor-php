<?php
require_once("../controller/UserController.php");

/**
 * 
 * ALLE DEUTSCHEN KOMMENTARE HIER SIND VOM STANDARD BBC-MVC FRAMEWORK UND STIMMEN EVENTUELL 
 * NICHT MIT DEN EFFEKTIVEN IMPLEMENTIERUNGEN ÜBEREIN!
 * 
 * Der Controller ist der Ort an dem es für jede Seite, welche der Benutzer
 * anfordern kann eine Methode gibt, welche die dazugehörende Businesslogik
 * beherbergt.
 *
 * Welche Controller und Funktionen muss ich erstellen?
 *   Es macht sinn, zusammengehörende Funktionen (z.B: User anzeigen, erstellen,
 *   bearbeiten & löschen) gemeinsam in einem passend benannten Controller (z.B:
 *   UserController) zu implementieren. Nicht zusammengehörende Features sollten
 *   jeweils auf unterschiedliche Controller aufgeteilt werden.
 *
 * Was passiert in einer Controllerfunktion?
 *   Die Anforderungen an die einzelnen Funktionen sind sehr unterschiedlich.
 *   Folgend die gängigsten:
 *     - Dafür sorgen, dass dem Benutzer eine View (HTML, CSS & JavaScript)
 *         gesendet wird.
 *     - Daten von einem Model (Verbindungsstück zur Datenbank) anfordern und
 *         der View übergeben, damit diese Daten dann für den Benutzer in HTML
 *         Code umgewandelt werden können.
 *     - Daten welche z.B. von einem Formular kommen validieren und dem Model
 *         übergeben, damit sie in der Datenbank persistiert werden können.
 */
class DefaultController
{
    /**
     * Die index Funktion des DefaultControllers sollte in jedem Projekt
     * existieren, da diese ausgeführt wird, falls die URI des Requests leer
     * ist. (z.B. http://my-project.local/). Weshalb das so ist, ist und wann
     * welcher Controller und welche Methode aufgerufen wird, ist im Dispatcher
     * beschrieben.
     */

    private $userController;

    public function __construct(){
        $this->userController = new UserController();
    }

    public function index()
    {
        // In diesem Fall möchten wir dem Benutzer die View mit dem Namen
        //   "home" rendern. Wie das genau funktioniert, ist in der
        //   View Klasse beschrieben.
        require_once("../lib/View.php");

        $view = new View('home');
        $view->title = 'Home';

        //The Session Header activates inside of the View so it has to be catched here as well but no action is required. 
        if(isset($_SESSION['userID'])){
            $view->stats = $this->userController->GetStats($_SESSION['userID']);
        }

        $view->display();
    }
}

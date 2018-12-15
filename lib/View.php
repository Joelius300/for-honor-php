 <!-- Bootstrap core CSS -->
 <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="http://1000hz.github.io/bootstrap-validator/dist/validator.min.js"></script>


<!-- Custom styles for this template -->
<link href="/css/style.css?v=<?=time();?>" rel="stylesheet" type="text/css">

<!-- selects (this v=... is only for testing purposes! it prevents the browser from caching the css-->
<link href="/css/select.css?v=<?=time();?>" rel="stylesheet" type="text/css">
<!-- <script src="/js/select.js?v=<?=time();?>"></script>  -->
<script src="/js/SelectBarContainer.js?v=<?=time();?>"></script>     
<script src="/js/SelectBar.js?v=<?=time();?>"></script>     

<script src="/js/ClassSwitcher.js?v=<?= time(); ?>"></script>     


<?php

/**
 * ALLE KOMMENTARE HIER SIND VOM STANDARD BBC-MVC FRAMEWORK UND STIMMEN EVENTUELL 
 * NICHT MIT DEN EFFEKTIVEN IMPLEMENTIERUNGEN ÜBEREIN!
 * 
 * 
 * Die View is das V aus MVC. Dabei geht es um alles, was dem Client (Browser)
 * als Antwort auf einen Request zurückgegeben wird. Im Normalfall ist das der
 * HTML Code.
 *
 * Der Controller entscheidet in jeder Funktion ob und wenn ja, welche View
 * gerendert werden soll. Hat der Controller Daten aus der Datenbank gehold oder
 * errechnet, so übergibt er diese der View damit sie dort dargestellt werden
 * können. Konkret könnte dies folgendermassen aussehen.
 *
 *   class ArtikelController
 *   {
 *     public function show()
 *     {
 *       $artikel = ...; // Artikel vom Model anfordern
 *
 *       // View erstellen (name = Dateiname im View Verzeichnis)
 *       $view = new View('article_show');
 *
 *       // Werte welche für die Darstellung benötigt werden übergeben.
 *       $view->title = $artikel->name;
 *       $view->article = $article;
 *
 *       // HTML generieren und dem Client senden
 *       $view->display();
 *     }
 *   }
 *
 * Sobald die Funktion display() auf der view aufgerufen wird, passieren die
 * folgenden drei Schritte.
 *   1. Die Datei "header.php" aus dem View Verzeichnis wird gerendert. Darin
 *        sollte ger Ganze HTML Code sein, welcher bei allen seiten gleich ist
 *        und vor den Inhalt kommt. Dadurch entstehen keine Redundanzen.
 *   2. Die Datei, welche o heisst wie im Konstruktor übergeben wird gerendert.
 *        Darin sollte ger Ganze HTML Code sein, welcher speziell für diese
 *        Seite gedacht ist.
 *   3. Die Datei "footer.php" aus dem View Verzeichnis wird gerendert. Darin
 *        sollte ger Ganze HTML Code sein, welcher bei allen seiten gleich ist
 *        und nach dem Inhalt. Dadurch entstehen keine Redundanzen.
 *
 * In allen drei Schritten stehen die vom Controller übergebenen Variablen zur
 * Verfügung. Diese können in den Viewfiles wie folgt ausgegeben werden.
 *
 *   <!-- Einzelne Variable ausgeben -->
 *   <title><?= $title; ?> | Bbc MVC</title>
 *
 *   <!-- Über ein Array iterieren und mit den Elementen eine Liste erstellen -->
 *   <ul>
 *     <?php foreach ($users as $user) { ?>
 *       <li><?= $user->name; ?></li>
 *     <?php } ?>
 *   </ul>
 */

class View
{
    private $viewfile;

    private $properties = array();

    public function __construct($viewfile)
    {
        $this->viewfile = "./../views/$viewfile.php";
        if(!file_exists($this->viewfile)){
            $this->viewfile = "./../views/home.php";
        }
    }

    public function __set($key, $value)
    {
        if (!isset($this->$key)) {
            $this->properties[$key] = $value;
        }
    }

    public function __get($key)
    {
        if (isset($this->properties[$key])) {
            return $this->properties[$key];
        }
    }

    public function display()
    {
        extract($this->properties);
        
        require $this->viewfile;
    }
}

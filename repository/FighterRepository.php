<?php

require_once '../lib/Repository.php';

/**
 * Das FighterRepository ist zuständig für alle Zugriffe auf die Tabelle "fighter".
 */
class FighterRepository extends Repository
{
    /**
     * Diese Variable wird von der Klasse Repository verwendet, um generische
     * Funktionen zur Verfügung zu stellen.
     */
    protected $tableName = 'fighter';

    /**
     * Speichert einen neuen Fighter in die Datenbank
     */
    public function insert()
    {
        
    }
}

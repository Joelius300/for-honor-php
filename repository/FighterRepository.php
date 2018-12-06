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
    public function insert($class, $healthpoints, $strengthpoints)
    {
        $query = "INSERT INTO $this->tableName (`Class`, `Healthpoints`, `Strengthpoints`) VALUES (?, ?, ?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('iii', $class, $healthpoints, $strengthpoints); //bindet die Variablen als ints (i) zu den Parametern
        
        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }

        return $statement->insert_id;
    }
}

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
    public function insert($name, $class, $healthpoints, $strengthpoints)
    {
        $query = "INSERT INTO $this->tableName (`Name`, `Class`, `HealthPoints`, `StrengthPoints`) VALUES (?, ?, ?, ?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('siii', $name, $class, $healthpoints, $strengthpoints); //bindet die Variablen als ints (i) zu den Parametern
        
        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }

        return $statement->insert_id;
    }

    public function update($id, $name, $healthpoints, $strengthpoints)
    {
        $query = "UPDATE $this->tableName set `Name` = ?, `HealthPoints` = ?, `StrengthPoints` = ? where `id` = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('siii', $name, $healthpoints, $strengthpoints, $id); //bindet die Variablen zu den Parametern
        
        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
    }

    public function readAllJoin($start = 0, $amount = 100)
    {
        $loggedUserID = $_SESSION['userID'];

        $query = 
        "SELECT `fighter`.*, `user`.`id` as `userID`, `user`.`Username` as `username` FROM fighter inner join `user` on `fighter`.id = `user`.Fighter_ID 
        where `user`.`id` <> $loggedUserID 
        LIMIT $start, $amount";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        // Datensätze aus dem Resultat holen und in das Array $rows speichern
        $rows = array();
        while ($row = $result->fetch_object()) {
            $rows[] = $row;
        }

        return $rows;
    }
}

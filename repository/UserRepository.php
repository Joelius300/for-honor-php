<?php

require_once '../lib/Repository.php';

/**
 * Das UserRepository ist zuständig für alle Zugriffe auf die Tabelle "user".
 */
class UserRepository extends Repository
{
    /**
     * Diese Variable stellt den Namen der Tabelle auf dem SQL-Server dar.
     */
    protected $tableName = 'user';

    /**
     * Speichert einen neuen benutzer mit Username und Passwort.
     *
     * Das Passwort wird mit PHP eigenen Funktionen gehashed.
     */
    public function insert($username, $password)
    {
        if(!$this->userExists($username)){

            $options = array(
                'cost' => 12
            );

            $password = password_hash($password, PASSWORD_BCRYPT, $options);

            $query = "INSERT INTO $this->tableName (`Username`, `Password`) VALUES (?, ?)";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('ss', $username, $password); //bindet die beiden Variablen als zwei Strings (ss) zu den Parametern
            
            if (!$statement->execute()) {
                throw new Exception($statement->error);
            }

            return $statement->insert_id;
        }else{
            return -5;
        }
    }

    //returns the user with given name
    public function readByUsername($username){
        // Query erstellen
        $query = "SELECT * FROM {$this->tableName} WHERE username=?";

        // Datenbankverbindung anfordern und, das Query "preparen" (vorbereiten)
        // und die Parameter "binden"
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('s', $username);

        // Das Statement absetzen
        $statement->execute();

        // Resultat der Abfrage holen
        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        // Ersten Datensatz aus dem Reultat holen
        $row = $result->fetch_object();

        // Datenbankressourcen wieder freigeben
        $result->close();

        // Den gefundenen Datensatz zurückgeben
        return $row;
    }

    //read only the points from the table
    public function getAvaiablePoints($id){
        return $this->readById($id)->Points;
    }

    //update only the points in the table
    public function updateAvaiablePoints($id, $points){
        $query = "UPDATE $this->tableName set `Points` = ? where `id` = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('si', $points, $id); //bindet die Variablen zu den Parametern
        
        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
    }

    //update all the stats for a user
    public function updateStats($userID, $totalGames, $wins){
        $query = "UPDATE $this->tableName set `TotalGames` = ?, `Wins` = ? where `id` = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('iii', $totalGames, $wins, $userID); //bindet die Variablen zu den Parametern
        
        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
    }

    //set a new fighter id (when fighter is created)
    public function updateFighterID($userID, $fighterID){
        $query = "UPDATE $this->tableName set `Fighter_ID` = ? where `id` = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ii', $fighterID, $userID); //bindet die Variablen zu den Parametern
        
        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
    }

    //checks if a user with said name is registered in the db
    public function userExists($username){
        $query = "SELECT * FROM {$this->tableName} WHERE username=?";

        // Datenbankverbindung anfordern und, das Query "preparen" (vorbereiten)
        // und die Parameter "binden"
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('s', $username);

        // Das Statement absetzen
        $statement->execute();

        // Resultat der Abfrage holen
        $result = $statement->get_result();

        if (!$result) {
            throw new Exception($statement->error);
        }

        if ($result->num_rows > 0) {
            return true;
        }else{
            return false;
        }
    }
}

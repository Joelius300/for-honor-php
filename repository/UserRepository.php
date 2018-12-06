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
        //$salt = 'oü9ggih8dfaw4';
        //$password = hash('sha256', ($password . $salt));

        $options = array(
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
            'cost' => 12,
          );

        $password = password_hash($password, PASSWORD_BCRYPT, $options);

        $query = "INSERT INTO $this->tableName (`Username`, `Password`) VALUES (?, ?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ss', $username, $password); //bindet die beiden Variablen als zwei Strings (ss) zu den Parametern
        
        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }

        return $statement->insert_id;
    }

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
}

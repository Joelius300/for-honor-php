<?php

class Data{
    private $conn;

    public function __construct($servername, $username, $password){
        // Create connection
        $conn = mysqli_connect($servername, $username, $password);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }


    public function AddUser($username, $password){
        $stmt = $mysqli->prepare("INSERT INTO user(username, pw) VALUES (?, ?)");

        mysqli_stmt_bind_param($stmt, "username", $username);
        mysqli_stmt_bind_param($stmt, "pw", $password);
        mysqli_stmt_execute($stmt);
    }

}

?>
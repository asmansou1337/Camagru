<?php

class Setup {

    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    function createDB()
    {
        $sql = "CREATE DATABASE IF NOT EXISTS camagru_db";
        if($this->pdo->query($sql) === FALSE)
        {
            throw new Exception("Unable to create Database");
        }
    }

    function createTables()
    {

        $sql = "CREATE TABLE IF NOT EXISTS user_account( ".
        "id INT(12) UNSIGNED AUTO_INCREMENT PRIMARY KEY, ".
        "firstName VARCHAR(100) , ".
        "lastName VARCHAR(100) , ".
        "username VARCHAR(100) NOT NULL, ".
        "email VARCHAR(100) NOT NULL, ".
        "password VARCHAR(255) NOT NULL, ".
        "token VARCHAR(255) NOT NULL, ".
        "active VARCHAR(3) NOT NULL, ".
        "notify VARCHAR(3) NOT NULL );";
        if($this->pdo->query($sql) === FALSE)
        {
            throw new Exception("Unable to create User_account table");
        }

        $sql = "CREATE TABLE IF NOT EXISTS picture_like( ".
        "id INT(12) UNSIGNED AUTO_INCREMENT PRIMARY KEY, ".
        "id_user INT(12) , ".
        "id_picture INT(12) , ".
        "like_nbr INT(255)); ";
        if($this->pdo->query($sql) === FALSE)
        {
            throw new Exception("Unable to create picture_like table");
        }

        $sql = "CREATE TABLE IF NOT EXISTS comment( ".
        "id INT(12) UNSIGNED AUTO_INCREMENT PRIMARY KEY, ".
        "id_user INT(12) , ".
        "id_picture INT(12), ".
        "comment VARCHAR(255)); ";
        if($this->pdo->query($sql) === FALSE)
        {
            throw new Exception("Unable to create comment table");
        }

        $sql = "CREATE TABLE IF NOT EXISTS picture( ".
        "id INT(12) UNSIGNED AUTO_INCREMENT PRIMARY KEY, ".
        "id_user INT(12) , ".
        "name VARCHAR(100) , ".
        "img_path VARCHAR(100) , ".
        "creation_date DATETIME NOT NULL);";
        if($this->pdo->query($sql) === FALSE)
        {
            throw new Exception("Unable to create picture table");
        }

       /* if ($this->pdo->query($sql) === TRUE) {
            echo "Table MyGuests created successfully";
        } else {
            echo "Error creating table: ";
        }*/
    }
}
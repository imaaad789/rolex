<?php

class Create_DateBase {
    private $host="localhost";
    private $username="root"; 
    private $password=""; 
    private $dbname="rolex";
    private $conn;

    public function __construct() {
        try {
            $this->conn=new PDO(
                "mysql:host=$this->host",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            die();
        }
        $this->BaseDonne();
    }

    public function BaseDonne() {
        try {
            $sql = "CREATE DATABASE IF NOT EXISTS $this->dbname";
            $this->conn->exec($sql);
            $this->conn->exec("USE $this->dbname");
        } catch(PDOException $e) {
            return "Error creating database: " . $e->getMessage();
        }
    }
}


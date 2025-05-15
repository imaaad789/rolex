<?php
    class DatabaseConnection {
        private $host="localhost";
        private $username="root";
        private $password="";
        private $dbname="rolex";
        private $conn;

        public function __construct(){
            $this->connect();
        }

        public function connect() {
            try {
                $this->conn = new PDO(
                    "mysql:host=$this->host;dbname=$this->dbname",
                    $this->username,
                    $this->password
                );
                $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                return $this->conn;
            } catch (PDOException $e) {
                throw new Exception("Connection failed: " . $e->getMessage());
            }
        }

        public function __destruct() {
            $this->conn = null;
        }
    }


?>
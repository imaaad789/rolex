<?php
    class DatabaseConnection {
        private static $instance = null;
        private $conn;

        private $host = "localhost";
        private $username = "root";
        private $password = "";
        private $dbname = "rolex";

        private function __construct() {
            $this->connect();
        }

        public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new DatabaseConnection();
            }
            return self::$instance;
        }

        public function connect() {
            try {
                $this->conn = new PDO(
                    "mysql:host=$this->host;dbname=$this->dbname",
                    $this->username,
                    $this->password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_PERSISTENT => false
                    ]
                );
                return $this->conn;
            } catch (PDOException $e) {
                throw new Exception("Connection failed: " . $e->getMessage());
            }
        }

        public function getConnection() {
            return $this->conn;
        }

        public function __destruct() {
            $this->conn = null;
        }
    }
?>
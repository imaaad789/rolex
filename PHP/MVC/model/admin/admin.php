<?php

    class Admin {
        private $conn;
        public function __construct($conn) {
            $this->conn=$conn;
        }

        public function createTable() {
            try {
                $sql = "CREATE TABLE IF NOT EXISTS admin (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nom VARCHAR(50) NOT NULL,
                    prenom VARCHAR(50) NOT NULL,
                    email VARCHAR(100) NOT NULL UNIQUE,
                    date_naissance DATE NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    profile_image VARCHAR(255) DEFAULT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
                $this->conn->exec($sql);

                $stmt = $this->conn->query("SELECT COUNT(*) as count FROM admin");
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result['count'] == 0) {
                    $default_nom="Aimad";
                    $default_prenom="Benjedi";
                    $default_email="admin@rolex.com";
                    $default_date_naissance="2006-05-29";
                    $default_password="admin123";
                    $default_profile_image="#";

                    $hashed_password = password_hash($default_password, PASSWORD_BCRYPT);

                    $sql = "INSERT INTO admin (nom, prenom, email, date_naissance, password, profile_image)
                            VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute([
                        $default_nom,
                        $default_prenom,
                        $default_email,
                        $default_date_naissance,
                        $hashed_password,
                        $default_profile_image
                    ]);
                    return "Table 'admin' created and default admin ($default_email) added successfully!";
                }
                return "Table 'admin' created or already exists. No default admin added.";
            } catch (PDOException $e) {
                return "Error creating table or adding default admin: " . $e->getMessage();
            }
        }
        public function getAdmin() {
        try {
            $sql = "SELECT * FROM admin";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching orders: " . $e->getMessage());
        }
    }
        public function addAdmin($nom, $prenom, $email, $date_naissance, $plain_password, $profile_image = null) {
            try {
                if (empty($nom) || empty($prenom) || empty($email) || empty($date_naissance) || empty($plain_password)) {
                    return "Error: All required fields (nom, prenom, email, date_naissance, password) must be provided.";
                }
                if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
                    return "Error: Invalid email format.";
                }

                $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM admin WHERE email = ?");
                $stmt->execute([$email]);
                if ($stmt->fetch(PDO::FETCH_ASSOC)['count'] > 0) {
                    return "Error: Email $email already exists.";
                }

                $hashed_password=password_hash($plain_password,PASSWORD_BCRYPT);

                $sql = "INSERT INTO admin (nom, prenom, email, date_naissance, password, profile_image)
                        VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    $nom,
                    $prenom,
                    $email,
                    $date_naissance,
                    $hashed_password,
                    $profile_image
                ]);

                return "Admin $email added successfully!";
            } catch (PDOException $e) {
                return "Error adding admin: " . $e->getMessage();
            }
        }

        // delete admin
        public function deleteAdmin($email) {
            try {
                $sql = "DELETE FROM admin WHERE email = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$email]);

                return "Admin with email $email deleted successfully!";
            } catch (PDOException $e) {
                return "Error deleting admin: " . $e->getMessage();
            }
        }
        public function updateAdminPassword($email, $new_password) {
            try {
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $sql = "UPDATE admin SET password = ? WHERE email = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$hashed_password, $email]);
                return "Password updated successfully for $email!";
            } catch (PDOException $e) {
                throw new Exception("Error updating password: " . $e->getMessage());
            }
        }
    }

?>
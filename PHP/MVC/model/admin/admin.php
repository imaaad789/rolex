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
                    $default_admins=[
                        [
                            'nom' => 'Aimad',
                            'prenom' => 'Benjedi',
                            'email' => 'admin1@rolex.com',
                            'date_naissance' => '2006-05-29',
                            'password' => 'admin123',
                            'profile_image' => '/images/crown-gold.png'
                        ],
                        [
                            'nom' => 'abouhamou',
                            'prenom' => 'Marouane',
                            'email' => 'admin2@rolex.com',
                            'date_naissance' => '2005-08-11',
                            'password' => 'admin123',
                            'profile_image' => '/images/crown-gold.png'
                        ],
                        [
                            'nom' => 'belgnaou',
                            'prenom' => 'abdellah',
                            'email' => 'admin3@rolex.com',
                            'date_naissance' => '2001-07-22',
                            'password' => 'admin123',
                            'profile_image' => '/images/crown-gold.png'
                        ],
                        [
                            'nom' => 'Najimi',
                            'prenom' => 'Youssef',
                            'email' => 'admin4@rolex.com',
                            'date_naissance' => '2004-09-09',
                            'password' => 'admin123',
                            'profile_image' => '/images/crown-gold.png'
                        ]
                    ];

                    $sql = "INSERT INTO admin (nom, prenom, email, date_naissance, password, profile_image)
                            VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $this->conn->prepare($sql);
                    
                    $added_emails = [];
                    foreach ($default_admins as $admin) {
                        $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);
                        $stmt->execute([
                            $admin['nom'],
                            $admin['prenom'],
                            $admin['email'],
                            $admin['date_naissance'],
                            $hashed_password,
                            $admin['profile_image']
                        ]);
                        $added_emails[] = $admin['email'];
                    }
                    
                    return "La table «admin» a été créée et les administrateurs par défaut (" . implode(', ', $added_emails) . ") ont été ajoutés avec succès!";
                }

                return "La table «admin» a été créée ou existe déjà. Aucun administrateur par défaut n'a été ajouté.";
            } catch (PDOException $e) {
                return "Erreur lors de la création de la table ou de l'ajout d'un administrateur par défaut: " . $e->getMessage();
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
        public function addAdmin($nom,$prenom,$email,$date_naissance,$plain_password,$profile_image=null) {
            try {
                if (empty($nom) || empty($prenom) || empty($email) || empty($date_naissance) || empty($plain_password)) {
                    return "Erreur : Tous les champs obligatoires (nom,prénom,email,date_naissance, mot de passe) doivent être renseignés.";
                }
                if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
                    return "Erreur:format d'email non valide.";
                }

                $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM admin WHERE email = ?");
                $stmt->execute([$email]);
                if ($stmt->fetch(PDO::FETCH_ASSOC)['count'] > 0) {
                    return "Erreur : l'email $email existe déjà.";
                }

                $hashed_password=password_hash($plain_password,PASSWORD_BCRYPT);

                $sql = "INSERT INTO admin (nom,prenom,email,date_naissance,password,profile_image)
                        VALUES (:nom,:prenom,:email,:date_naissance,:password,:profile_image)";

                $stmt = $this->conn->prepare($sql);

                $stmt->bindParam(':nom',$nom);
                $stmt->bindParam(':prenom',$prenom);
                $stmt->bindParam(':email',$email);
                $stmt->bindParam(':date_naissance',$date_naissance);
                $stmt->bindParam(':password',$hashed_password);
                $stmt->bindParam(':profile_image',$profile_image);

                $stmt->execute();

                return "L'administrateur $email a été ajouté avec succès!";
            } catch (PDOException $e) {
                return "Erreur lors de l'ajout de l'administrateur: " . $e->getMessage();
            }
        }

        // delete admin
        public function deleteAdmin($email) {
            try {
                $sql = "DELETE FROM admin WHERE email = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$email]);

                return "L'administrateur avec l'email $email a été supprimé avec succès!";
            } catch (PDOException $e) {
                return "Erreur lors de supprimé de l'administrateur: " . $e->getMessage();
            }
        }
        public function updateAdminPassword($email, $new_password) {
            try {
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $sql = "UPDATE admin SET password = ? WHERE email = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$hashed_password, $email]);
                return "Mot de passe mis à jour avec succès pour $email!";
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la mise à jour du mot de passe: " . $e->getMessage());
            }
        }
    }

?>
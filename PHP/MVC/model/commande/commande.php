<?php

class Commande {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->createTable();
    }

    public function createTable() {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS commande (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nom VARCHAR(50) NOT NULL,
                prenom VARCHAR(50) NOT NULL,
                email VARCHAR(100) NOT NULL,
                adress VARCHAR(255) NOT NULL,
                ville VARCHAR(100) NOT NULL,
                code_postal VARCHAR(20) NOT NULL,
                numero_telephone VARCHAR(20) NOT NULL,
                reference_number VARCHAR(50) NOT NULL,
                type_paiement ENUM('MasterCard', 'Visa', 'Apple Pay') NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $this->conn->exec($sql);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error creating table commande: " . $e->getMessage());
        }
    }

    public function getCommande() {
        try {
            $sql = "SELECT * FROM commande";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching orders: " . $e->getMessage());
        }
    }

    public function getCommandeId($id) {
        try {
            $sql = "SELECT * FROM commande WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching orders: " . $e->getMessage());
        }
    }

    public function deleteCommande($order_id) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM commande WHERE id = ?");
            $stmt->execute([$order_id]);
            if ($stmt->fetch(PDO::FETCH_ASSOC)['count'] == 0) {
                throw new Exception("No order found with ID: $order_id");
            }

            $sql = "DELETE FROM commande WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$order_id]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error deleting order: " . $e->getMessage());
        }
    }


    public function InsetCommand($nom,$prenom,$email,$adress,$ville,$code_postal,$numero_telephone,$reference_number,$type_paiement) {
        try {
            $required_fields = ['nom','prenom','email','adress','ville','code_postal','numero_telephone','reference_number','type_paiement'];
            foreach ($required_fields as $field) {
                if (empty($$field)) {
                    throw new Exception("Manquant ou invalide $field.");
                }
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email format.");
            }

            $sql = "INSERT INTO commande (nom, prenom, email, adress, ville, code_postal, numero_telephone, reference_number, type_paiement, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$nom, $prenom, $email, $adress, $ville, $code_postal, $numero_telephone, $reference_number, $type_paiement]);

            return "Commande enregistrée avec succès pour l'order ID " . $this->conn->lastInsertId() . ".";
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'enregistrement de la commande : " . $e->getMessage());
        }
    }

}

?>
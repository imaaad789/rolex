<?php

require_once __DIR__ . '/../config/connexion_db.php';
require_once __DIR__ . '/../model/commande/Commande.php';

class CommandController {
    private $db;
    private $commandeModel;

    public function __construct() {
        // Utiliser le singleton
        $this->db = DatabaseConnection::getInstance()->getConnection();
        $this->commandeModel = new Commande($this->db);
    }

    public function Affiche_Commande() {
        try {
            $orders = $this->commandeModel->getCommande();
            return $orders;
        } catch (Exception $e) {
            $error = $e->getMessage();
        } finally {
            $this->db = null;
        }
    }

    public function Affiche_Commande_id($id) {
        try {
            $orders = $this->commandeModel->getCommandeId($id);
            return $orders;
        } finally {
            $this->db = null;
        }
    }

    public function Delete_Commande($order_id) {
        try {
            $this->commandeModel->deleteCommande($order_id);
            $message = "Order with ID $order_id deleted successfully!";
        } catch (Exception $e) {
            $error = $e->getMessage();
        } finally {
            $this->db = null;
        }
    }

    public function Validation_Commande($nom,$prenom,$email,$adress,$ville,$code_postal,$numero_telephone,$reference_number,$type_paiement) {
        try {
            $this->commandeModel->InsetCommand($nom,$prenom,$email,$adress,$ville,$code_postal,$numero_telephone,$reference_number,$type_paiement);
            $message = "Votre commande est validée avec succès et sera reçue dans 30 jours.";
            return $message;
        } catch (Exception $e) {
            $error = $e->getMessage();
        } finally {
            $this->db = null;
        }
    }
}
?>

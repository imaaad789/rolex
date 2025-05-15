<?php

require_once __DIR__ . '/../config/connexion_db.php';
require_once __DIR__ . '/../model/commande/Commande.php';

class WatchController {
    private $db;
    private $commandeModel;

    public function __construct() {
        $this->db = (new DatabaseConnection())->connect();
        $this->commandeModel = new Commande($this->db);
    }

    public function Affiche_Commande() {
        try {
            $orders = $this->commandeModel->getCommande();
            include __DIR__ . '/../Views/order/display_orders.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/order/display_orders.php';
        }
    }

    public function Delete_Commande($order_id) {
        try {
            $this->commandeModel->deleteCommande($order_id);
            $message = "Order with ID $order_id deleted successfully!";
            include __DIR__ . '/../Views/order/delete_order_result.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/order/delete_order_result.php';
        }
    }

    public function Validation_Commande($order_id) {
        try {
            $this->commandeModel->validateCommande($order_id);
            $message = "Your order is validated successfully and will be received in 30 days.";
            include __DIR__ . '/../Views/order/validate_order_result.php';
        } catch (Exception $e) {
            $error = $e->getMessage();
            include __DIR__ . '/../Views/order/validate_order_result.php';
        }
    }
}

?>
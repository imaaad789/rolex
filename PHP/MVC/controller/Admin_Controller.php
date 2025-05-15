<?php

require_once __DIR__ . '/../config/connexion_db.php';
require_once __DIR__ . '/../model/admin/admin.php';

class AdminController {
    private $db;
    private $adminModel;

    public function __construct() {
        $this->db = (new DatabaseConnection())->connect();
        $this->adminModel = new Admin($this->db);
    }

    public function createTable() {
        try {
            $this->adminModel->createTable();
            $message = "Table 'admin' created successfully!";
            include __DIR__ . '/../Views/admin/create_table_result.php';
        } catch (Exception $e) {
            $message = $e->getMessage();
            include __DIR__ . '/../Views/admin/create_table_result.php';
        }
    }

    public function addAdmin($nom, $prenom, $email, $date_naissance, $plain_password, $profile_image = null) {
        try {
            $this->adminModel->addAdmin($nom, $prenom, $email, $date_naissance, $plain_password, $profile_image);
            $message = "Admin $email added successfully!";
            include __DIR__ . '/../Views/admin/add_admin_result.php';
        } catch (Exception $e) {
            $message = $e->getMessage();
            include __DIR__ . '/../Views/admin/add_admin_result.php';
        }
    }

    public function deleteAdmin($email) {
        try {
            $this->adminModel->deleteAdmin($email);
            $message = "Admin with email $email deleted successfully!";
            include __DIR__ . '/../Views/admin/delete_admin_result.php';
        } catch (Exception $e) {
            $message = $e->getMessage();
            include __DIR__ . '/../Views/admin/delete_admin_result.php';
        }
    }
}

?>